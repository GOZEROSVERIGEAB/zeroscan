<?php

namespace App\Livewire;

use App\Jobs\ProcessScanningSession;
use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Models\Station;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PublicScanningPage extends Component
{
    use WithFileUploads;

    public Station $station;
    public array $branding;

    public int $step = 1;
    public int $maxImages;

    public array $photos = [];
    public array $uploadedPhotos = [];

    public ?string $visitorName = null;
    public ?string $visitorEmail = null;
    public bool $wantsReport = false;
    public bool $gdprConsent = false;

    public ?ScanningSession $session = null;

    protected $listeners = ['photoUploaded'];

    public function mount(Station $station): void
    {
        $this->station = $station->load('facility');
        $this->branding = $station->getEffectiveBranding();
        $this->maxImages = $station->max_images ?? 5;
    }

    public function rules(): array
    {
        return [
            'photos.*' => ['image', 'max:10240'],
            'visitorName' => ['nullable', 'string', 'max:255'],
            'visitorEmail' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function startScanning(): void
    {
        $this->step = 2;
    }

    public function updatedPhotos(): void
    {
        $this->validateOnly('photos.*');

        foreach ($this->photos as $photo) {
            if (count($this->uploadedPhotos) >= $this->maxImages) {
                break;
            }

            $path = $photo->store('scanned-items', 'public');

            $this->uploadedPhotos[] = [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'name' => $photo->getClientOriginalName(),
            ];
        }

        $this->photos = [];
    }

    public function removePhoto(int $index): void
    {
        if (isset($this->uploadedPhotos[$index])) {
            Storage::disk('public')->delete($this->uploadedPhotos[$index]['path']);
            unset($this->uploadedPhotos[$index]);
            $this->uploadedPhotos = array_values($this->uploadedPhotos);
        }
    }

    public function goToContactStep(): void
    {
        if (count($this->uploadedPhotos) === 0) {
            $this->addError('photos', 'Du måste ladda upp minst en bild');
            return;
        }

        $this->step = 3;
    }

    public function toggleWantsReport(): void
    {
        $this->wantsReport = !$this->wantsReport;
    }

    public function submitScan(): void
    {
        if ($this->wantsReport) {
            $this->validate([
                'visitorEmail' => ['required', 'email', 'max:255'],
                'gdprConsent' => ['accepted'],
            ], [
                'gdprConsent.accepted' => 'Du måste godkänna hanteringen av dina personuppgifter.',
            ]);
        }

        $this->session = ScanningSession::create([
            'station_id' => $this->station->id,
            'visitor_name' => $this->visitorName,
            'email' => $this->wantsReport ? $this->visitorEmail : null,
            'gdpr_consent' => $this->wantsReport ? $this->gdprConsent : false,
            'gdpr_consent_at' => $this->wantsReport && $this->gdprConsent ? now() : null,
            'status' => ScanningSession::STATUS_PENDING,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        foreach ($this->uploadedPhotos as $photo) {
            Inventory::create([
                'station_id' => $this->station->id,
                'scanning_session_id' => $this->session->id,
                'image_path' => $photo['path'],
                'status' => Inventory::STATUS_QUEUED,
            ]);
        }

        ProcessScanningSession::dispatch($this->session);

        $this->step = 4;
    }

    public function getProgressProperty(): int
    {
        return match ($this->step) {
            1 => 0,
            2 => 33,
            3 => 66,
            4 => 100,
            default => 0,
        };
    }

    public function render()
    {
        return view('livewire.public-scanning-page');
    }
}
