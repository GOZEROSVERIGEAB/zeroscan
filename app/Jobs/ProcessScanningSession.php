<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Services\AIResponse;
use App\Services\AIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProcessScanningSession implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public int $timeout = 600;

    public function __construct(
        public ScanningSession $session
    ) {}

    public function handle(AIService $aiService): void
    {
        try {
            $this->markSessionAsProcessing();

            $inventories = $this->session->inventories()
                ->whereIn('status', [Inventory::STATUS_QUEUED, Inventory::STATUS_ERROR])
                ->get();

            $totalCo2Savings = 0;
            $totalItems = 0;
            $hasErrors = false;

            foreach ($inventories as $inventory) {
                try {
                    $this->processInventory($inventory, $aiService);
                    $totalItems++;
                    $totalCo2Savings += $inventory->fresh()->co2_savings ?? 0;
                } catch (Throwable $e) {
                    Log::error('Failed to process inventory in session', [
                        'session_id' => $this->session->id,
                        'inventory_id' => $inventory->id,
                        'error' => $e->getMessage(),
                    ]);
                    $hasErrors = true;
                }
            }

            $this->updateStationStatistics($totalItems, $totalCo2Savings);
            $this->updateFacilityStatistics($totalItems, $totalCo2Savings);
            $this->markSessionAsCompleted($totalItems, $totalCo2Savings, $hasErrors);

            if ($this->session->email && ! $this->session->report_sent) {
                SendEnvironmentalReport::dispatch($this->session);
            }

        } catch (Throwable $e) {
            Log::error('ProcessScanningSession job failed', [
                'session_id' => $this->session->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->markSessionAsFailed($e->getMessage());

            throw $e;
        }
    }

    protected function markSessionAsProcessing(): void
    {
        $updateData = [];

        if ($this->hasSessionColumn('status')) {
            $updateData['status'] = 'processing';
        }

        if ($this->hasSessionColumn('ai_processing_started_at')) {
            $updateData['ai_processing_started_at'] = now();
        }

        if (! empty($updateData)) {
            $this->session->update($updateData);
        }
    }

    protected function markSessionAsCompleted(int $totalItems, float $totalCo2Savings, bool $hasErrors): void
    {
        $updateData = [
            'completed_at' => now(),
        ];

        if ($this->hasSessionColumn('status')) {
            $updateData['status'] = $hasErrors ? 'completed_with_errors' : 'completed';
        }

        if ($this->hasSessionColumn('ai_processing_completed_at')) {
            $updateData['ai_processing_completed_at'] = now();
        }

        if ($this->hasSessionColumn('total_items')) {
            $updateData['total_items'] = $totalItems;
        }

        if ($this->hasSessionColumn('total_co2_savings')) {
            $updateData['total_co2_savings'] = $totalCo2Savings;
        }

        $updateData['inventory_uuids'] = $this->session->inventories()->pluck('uuid')->toArray();

        $this->session->update($updateData);
    }

    protected function markSessionAsFailed(string $errorMessage): void
    {
        $updateData = [];

        if ($this->hasSessionColumn('status')) {
            $updateData['status'] = 'failed';
        }

        if ($this->hasSessionColumn('error_message')) {
            $updateData['error_message'] = $errorMessage;
        }

        if (! empty($updateData)) {
            $this->session->update($updateData);
        }
    }

    protected function processInventory(Inventory $inventory, AIService $aiService): void
    {
        $inventory->markAsProcessing();

        $imagePath = $inventory->image_path;

        if (! Storage::disk('public')->exists($imagePath)) {
            throw new \RuntimeException("Image not found: {$imagePath}");
        }

        $imageBase64 = base64_encode(Storage::disk('public')->get($imagePath));
        $mimeType = Storage::disk('public')->mimeType($imagePath) ?? 'image/jpeg';

        $response = $aiService->analyzeImage($imageBase64, $mimeType);
        $data = $response->getJsonContent();

        if (empty($data)) {
            throw new \RuntimeException('AI returned invalid JSON response');
        }

        $this->updateInventoryWithAIData($inventory, $response, $data);
    }

    /**
     * Update the inventory record with AI analysis data.
     *
     * @param  array<string, mixed>  $data
     */
    protected function updateInventoryWithAIData(Inventory $inventory, AIResponse $response, array $data): void
    {
        $inventory->update([
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
            'ai_confidence' => $data['confidence'] ?? null,
            'ai_provider' => $response->provider,
            'ai_model' => $response->model,
            'ai_tokens_used' => $response->totalTokens(),
            'ai_response' => $data,
            'status' => Inventory::STATUS_COMPLETED,
            'processed_at' => now(),
        ]);
    }

    protected function updateStationStatistics(int $totalItems, float $totalCo2Savings): void
    {
        $station = $this->session->station;

        if (! $station) {
            return;
        }

        $station->incrementStats($totalItems, $totalCo2Savings);
    }

    protected function updateFacilityStatistics(int $totalItems, float $totalCo2Savings): void
    {
        $station = $this->session->station;

        if (! $station || ! $station->facility) {
            return;
        }

        $facility = $station->facility;

        if (method_exists($facility, 'incrementStats')) {
            $facility->incrementStats($totalItems, $totalCo2Savings);
        } elseif ($this->hasFacilityStatsColumns($facility)) {
            $facility->increment('total_scans');
            $facility->increment('total_items', $totalItems);
            $facility->increment('total_co2_savings', $totalCo2Savings);
        }
    }

    protected function hasSessionColumn(string $column): bool
    {
        return in_array($column, $this->session->getFillable());
    }

    protected function hasFacilityStatsColumns($facility): bool
    {
        $fillable = $facility->getFillable();

        return in_array('total_scans', $fillable)
            && in_array('total_items', $fillable)
            && in_array('total_co2_savings', $fillable);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error('ProcessScanningSession job failed permanently', [
            'session_id' => $this->session->id,
            'error' => $exception?->getMessage(),
        ]);

        $this->markSessionAsFailed($exception?->getMessage() ?? 'Unknown error');
    }
}
