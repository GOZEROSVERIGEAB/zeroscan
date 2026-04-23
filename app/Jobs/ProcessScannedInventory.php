<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Notifications\EnvironmentReportNotification;
use App\Services\AIResponse;
use App\Services\AIService;
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

    public function handle(AIService $aiService): void
    {
        try {
            $this->inventory->markAsProcessing();

            $imagePath = $this->inventory->image_path;

            if (!Storage::disk('public')->exists($imagePath)) {
                throw new \RuntimeException("Image not found: {$imagePath}");
            }

            $imageBase64 = base64_encode(Storage::disk('public')->get($imagePath));
            $mimeType = Storage::disk('public')->mimeType($imagePath) ?? 'image/jpeg';

            $response = $aiService->analyzeImage($imageBase64, $mimeType);
            $data = $response->getJsonContent();

            if (empty($data)) {
                throw new \RuntimeException('AI returned invalid JSON response');
            }

            $this->updateInventoryWithAIData($response, $data);

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
     * Update the inventory record with AI analysis data.
     *
     * @param array<string, mixed> $data
     */
    protected function updateInventoryWithAIData(AIResponse $response, array $data): void
    {
        $this->inventory->update([
            'name' => $data['name'] ?? __('scanit.unknown_item'),
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'subcategory' => $data['subcategory'] ?? null,
            'brand' => $data['brand'] ?? null,
            'model' => $data['model'] ?? null,
            'materials' => $data['materials'] ?? null,
            'colors' => $data['colors'] ?? null,
            'weight' => $data['weight_kg'] ?? null,
            'height' => $data['dimensions']['height_cm'] ?? null,
            'width' => $data['dimensions']['width_cm'] ?? null,
            'depth' => $data['dimensions']['depth_cm'] ?? null,
            'estimated_value' => $data['estimated_value_sek'] ?? null,
            'condition_rating' => $data['condition']['rating'] ?? null,
            'condition_description' => $data['condition']['description'] ?? null,
            'co2_savings' => $data['co2_savings']['kg'] ?? null,
            'co2_source' => $data['co2_savings']['source'] ?? null,
            'co2_calculation_notes' => $data['co2_savings']['calculation'] ?? null,
            'water_savings' => $data['water_savings_liters'] ?? null,
            'energy_savings' => $data['energy_savings_kwh'] ?? null,
            'ai_confidence' => $data['confidence'] ?? null,
            'ai_provider' => $response->provider,
            'ai_model' => $response->model,
            'ai_tokens_used' => $response->totalTokens(),
            'ai_response' => $data,
            'status' => Inventory::STATUS_COMPLETED,
            'processed_at' => now(),
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
