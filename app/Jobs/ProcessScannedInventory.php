<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Notifications\EnvironmentReportNotification;
use App\Services\AIResponse;
use App\Services\AIService;
use App\Services\EnvironmentalFactorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProcessScannedInventory implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public int $timeout = 180;

    public function __construct(
        public Inventory $inventory
    ) {}

    public function handle(AIService $aiService, EnvironmentalFactorService $factorService): void
    {
        try {
            $this->inventory->markAsProcessing();

            $imagePath = $this->inventory->image_path;

            if (!Storage::disk('public')->exists($imagePath)) {
                throw new \RuntimeException("Image not found: {$imagePath}");
            }

            $imageBase64 = base64_encode(Storage::disk('public')->get($imagePath));
            $mimeType = Storage::disk('public')->mimeType($imagePath) ?? 'image/jpeg';

            // Step 1: AI identifies the item (no environmental calculations)
            $response = $aiService->analyzeImage($imageBase64, $mimeType);
            $aiData = $response->getJsonContent();

            if (empty($aiData)) {
                throw new \RuntimeException('AI returned invalid JSON response');
            }

            // Step 2: Get verified environmental metrics from database
            $envMetrics = $factorService->calculateMetrics($aiData);

            // Step 3: Update inventory with both AI identification and verified metrics
            $this->updateInventoryWithVerifiedData($response, $aiData, $envMetrics);

            $this->checkAndSendReport();

        } catch (Throwable $e) {
            Log::error('AI Processing failed', [
                'inventory_id' => $this->inventory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->inventory->update([
                'status' => Inventory::STATUS_ERROR,
                'ai_response' => ['error' => $e->getMessage()],
            ]);

            throw $e;
        }
    }

    /**
     * Update inventory with AI identification and VERIFIED environmental metrics.
     *
     * @param AIResponse $response AI response object
     * @param array<string, mixed> $aiData AI identification data
     * @param array<string, mixed> $envMetrics Verified environmental metrics from database
     */
    protected function updateInventoryWithVerifiedData(AIResponse $response, array $aiData, array $envMetrics): void
    {
        // Build source citation for transparency
        $sourceInfo = $envMetrics['source'] ?? [];
        $co2Source = $sourceInfo['citation'] ?? $sourceInfo['name'] ?? null;
        $co2Notes = null;

        if ($envMetrics['data_source'] === 'verified_database') {
            $co2Notes = sprintf(
                'Källa: %s. Metod: %s. Publicerad: %s.',
                $sourceInfo['report'] ?? $sourceInfo['name'] ?? 'Okänd',
                $sourceInfo['methodology'] ?? 'LCA',
                $sourceInfo['publication_date'] ?? 'Okänt datum'
            );

            if ($sourceInfo['url']) {
                $co2Notes .= ' URL: ' . $sourceInfo['url'];
            }
        } elseif ($envMetrics['data_source'] === 'no_data') {
            $co2Source = 'Ingen verifierad data tillgänglig';
            $co2Notes = 'Denna produktkategori saknar verifierade miljöfaktorer i databasen.';
        }

        // Store full response with both AI data and verified metrics for audit trail
        $fullResponse = [
            'ai_identification' => $aiData,
            'environmental_metrics' => $envMetrics,
            'processing_timestamp' => now()->toIso8601String(),
        ];

        $this->inventory->update([
            // AI-identified data (item identification)
            'name' => $aiData['name'] ?? __('scanit.unknown_item'),
            'description' => $aiData['description'] ?? null,
            'category' => $aiData['category'] ?? null,
            'subcategory' => $aiData['subcategory'] ?? null,
            'brand' => $aiData['brand'] ?? null,
            'model' => $aiData['model'] ?? null,
            'materials' => $aiData['materials'] ?? null,
            'colors' => $aiData['colors'] ?? null,
            'weight' => $aiData['weight_kg'] ?? null,
            'height' => $aiData['dimensions']['height_cm'] ?? null,
            'width' => $aiData['dimensions']['width_cm'] ?? null,
            'depth' => $aiData['dimensions']['depth_cm'] ?? null,
            'estimated_value' => $aiData['estimated_value_sek'] ?? null,
            'condition_rating' => $aiData['condition']['rating'] ?? null,
            'condition_description' => $aiData['condition']['description'] ?? null,

            // VERIFIED environmental data (from database, NOT AI-estimated)
            'co2_savings' => $envMetrics['co2_savings_kg'],
            'co2_source' => $co2Source,
            'co2_calculation_notes' => $co2Notes,
            'water_savings' => $envMetrics['water_savings_liters'],
            'energy_savings' => $envMetrics['energy_savings_kwh'],

            // Environmental data verification tracking
            'environmental_category_id' => $envMetrics['category_id'] ?? null,
            'environmental_factor_id' => $envMetrics['factor_id'] ?? null,
            'environmental_data_verified' => $envMetrics['verification']['is_verified'] ?? false,
            'environmental_data_source' => $envMetrics['data_source'],

            // AI metadata
            'ai_confidence' => $aiData['confidence'] ?? null,
            'ai_provider' => $response->provider,
            'ai_model' => $response->model,
            'ai_tokens_used' => $response->totalTokens(),
            'ai_response' => $fullResponse,

            'status' => Inventory::STATUS_COMPLETED,
            'processed_at' => now(),
        ]);

        Log::info('Inventory processed with verified environmental data', [
            'inventory_id' => $this->inventory->id,
            'ai_category' => $aiData['category'] ?? null,
            'matched_category' => $envMetrics['matched_category']['slug'] ?? null,
            'co2_savings_kg' => $envMetrics['co2_savings_kg'],
            'data_source' => $envMetrics['data_source'],
            'is_verified' => $envMetrics['verification']['is_verified'] ?? false,
        ]);
    }

    protected function checkAndSendReport(): void
    {
        $session = $this->inventory->scanningSession;

        if (!$session) {
            return;
        }

        $pendingCount = $session->inventories()
            ->whereNotIn('status', [Inventory::STATUS_COMPLETED, Inventory::STATUS_ERROR])
            ->count();

        if ($pendingCount === 0 && $session->email && !$session->report_sent) {
            Notification::route('mail', $session->email)
                ->notify(new EnvironmentReportNotification($session));

            $session->update([
                'report_sent' => true,
                'completed_at' => now(),
            ]);

            Log::info('Environment report sent', [
                'session_id' => $session->id,
                'email' => $session->email,
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error('ProcessScannedInventory job failed permanently', [
            'inventory_id' => $this->inventory->id,
            'error' => $exception?->getMessage(),
        ]);

        $this->inventory->markAsError();
    }
}
