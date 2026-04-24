<?php

namespace App\Livewire;

use App\Services\HazardAnalysisService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.hazard')]
class HazardScanPage extends Component
{
    use WithFileUploads;

    public string $locale = 'de';

    public string $scannedCode = '';

    public bool $showScanner = false;

    public ?array $result = null;

    public ?string $error = null;

    public ?string $scannedImage = null;

    public $uploadedImage = null;

    protected HazardAnalysisService $hazardService;

    public function boot(HazardAnalysisService $hazardService): void
    {
        $this->hazardService = $hazardService;
    }

    public function mount(): void
    {
        $this->locale = session('hazard_locale', 'de');
        App::setLocale($this->locale);
    }

    public function setLocale(string $locale): void
    {
        $this->locale = in_array($locale, ['en', 'de']) ? $locale : 'de';
        session(['hazard_locale' => $this->locale]);
        App::setLocale($this->locale);

        if ($this->result && $this->scannedCode) {
            $this->result = $this->hazardService->lookupByBarcode($this->scannedCode, $this->locale);
        }
    }

    public function startScanner(): void
    {
        $this->showScanner = true;
        $this->error = null;
    }

    public function stopScanner(): void
    {
        $this->showScanner = false;
    }

    public function processBarcode(string $code): void
    {
        $this->scannedCode = $code;
        $this->showScanner = false;
        $this->error = null;

        Log::info('HazardScanPage: Processing barcode', ['code' => $code]);

        $result = $this->hazardService->lookupByBarcode($code, $this->locale);

        if ($result) {
            $this->result = $result;

            return;
        }

        $this->error = __('hazard.error_not_found');
    }

    #[On('process-image')]
    public function processImage(string $imageData): void
    {
        Log::info('HazardScanPage: Processing image via AI');

        $this->scannedImage = $imageData;
        $this->error = null;

        try {
            if (preg_match('/^data:([^;]+);base64,(.+)$/', $imageData, $matches)) {
                $mimeType = $matches[1];
                $base64Data = $matches[2];
            } else {
                $mimeType = 'image/jpeg';
                $base64Data = $imageData;
            }

            $this->result = $this->hazardService->analyzeImage($base64Data, $mimeType, $this->locale);

        } catch (\Exception $e) {
            Log::error('HazardScanPage: Image analysis failed', [
                'error' => $e->getMessage(),
            ]);
            $this->error = __('hazard.error_analysis_failed');
        }
    }

    public function resetScan(): void
    {
        $this->scannedCode = '';
        $this->result = null;
        $this->error = null;
        $this->showScanner = false;
        $this->scannedImage = null;
        $this->uploadedImage = null;
    }

    public function render()
    {
        // Ensure locale is set on every render
        App::setLocale($this->locale);

        return view('livewire.hazard-scan-page');
    }
}
