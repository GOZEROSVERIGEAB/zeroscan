<?php

namespace App\Livewire\Stations;

use App\Models\Station;
use Livewire\Component;

class QrCode extends Component
{
    public Station $station;
    public string $size = 'medium';

    public function mount(Station $station): void
    {
        $this->station = $station;
    }

    public function getQrUrlProperty(): string
    {
        return route('public.scan', $this->station->public_uuid);
    }

    public function getSizePixelsProperty(): int
    {
        return match ($this->size) {
            'small' => 200,
            'medium' => 300,
            'large' => 400,
            'xlarge' => 500,
            default => 300,
        };
    }

    public function getBrandingProperty(): array
    {
        return $this->station->getEffectiveBranding();
    }

    public function render()
    {
        return view('livewire.stations.qr-code', [
            'qrUrl' => $this->qrUrl,
            'sizePixels' => $this->sizePixels,
            'branding' => $this->branding,
        ])->layout('layouts.app');
    }
}
