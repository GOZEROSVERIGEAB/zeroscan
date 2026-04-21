<?php

namespace App\Livewire;

use App\Jobs\ProcessScannedInventory;
use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Models\Station;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.public')]
class PublicScanningPage extends Component
{
    use WithFileUploads;

    public Station $station;
    public string $currentStep = 'info';
    public array $images = [];
    public array $tempImages = [];
    public ?string $email = null;
    public bool $gdprAccepted = false;
    public ?ScanningSession $session = null;

    protected $listeners = ['imageUploaded' => 'handleImageUpload'];

    public function mount(Station $station): void
    {
        $this->station = $station;
    }

    public function startCapture(): void
    {
        $this->currentStep = 'capture';
    }

    public function handleImageUpload(int $slot, string $imageData): void
    {
        $this->tempImages[$slot] = $imageData;
    }

    public function storeImage(int $slot): void
    {
        if (!isset($this->tempImages[$slot])) {
            return;
        }

        $imageData = $this->tempImages[$slot];

        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $extension = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            $filename = Str::uuid() . '.' . $extension;
            $path = "scans/{$this->station->id}/{$filename}";

            Storage::disk('public')->put($path, $imageData);
            $this->images[$slot] = $path;
            unset($this->tempImages[$slot]);
        }
    }

    public function removeImage(int $slot): void
    {
        if (isset($this->images[$slot])) {
            Storage::disk('public')->delete($this->images[$slot]);
            unset($this->images[$slot]);
        }

        if (isset($this->tempImages[$slot])) {
            unset($this->tempImages[$slot]);
        }
    }

    public function proceedToEmail(): void
    {
        if (count($this->images) === 0 && count($this->tempImages) === 0) {
            $this->addError('images', __('scanit.public.error_no_images'));

            return;
        }

        foreach ($this->tempImages as $slot => $imageData) {
            $this->storeImage($slot);
        }

        $this->currentStep = 'email';
    }

    public function skipEmail(): void
    {
        $this->email = null;
        $this->completeScan();
    }

    public function completeScan(): void
    {
        if ($this->email && !$this->gdprAccepted) {
            $this->addError('gdpr', __('scanit.validation.gdpr_required'));

            return;
        }

        if ($this->email) {
            $this->validate([
                'email' => 'email',
            ], [
                'email.email' => __('scanit.validation.email_invalid'),
            ]);
        }

        $this->session = ScanningSession::create([
            'station_id' => $this->station->id,
            'email' => $this->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        foreach ($this->images as $slot => $imagePath) {
            $inventory = Inventory::create([
                'station_id' => $this->station->id,
                'scanning_session_id' => $this->session->id,
                'image_path' => $imagePath,
                'status' => Inventory::STATUS_QUEUED,
            ]);

            ProcessScannedInventory::dispatch($inventory);
        }

        $this->station->incrementStats(count($this->images));

        $this->currentStep = 'thankyou';
    }

    public function scanMore(): void
    {
        $this->reset(['images', 'tempImages', 'email', 'gdprAccepted', 'session']);
        $this->currentStep = 'info';
    }

    public function getMaxImagesProperty(): int
    {
        return $this->station->max_images ?? 5;
    }

    public function render()
    {
        return view('livewire.public-scanning-page')
            ->layoutData(['station' => $this->station]);
    }
}
