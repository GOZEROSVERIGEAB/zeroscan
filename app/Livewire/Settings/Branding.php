<?php

namespace App\Livewire\Settings;

use App\Models\Customer;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Branding extends Component
{
    use WithFileUploads;

    public ?Customer $customer = null;

    public ?string $service_name = '';

    public $logo = null;

    public ?string $currentLogoUrl = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->customer = Customer::find($user->customer_id);

        if ($this->customer) {
            $this->service_name = $this->customer->service_name ?? '';
            $this->currentLogoUrl = $this->customer->logo_url;
        }
    }

    public function getPreviewStationProperty(): ?Station
    {
        if (! $this->customer) {
            return null;
        }

        return Station::query()
            ->whereHas('facility.customer', fn ($q) => $q->where('id', $this->customer->id))
            ->where('is_active', true)
            ->first();
    }

    protected function rules(): array
    {
        return [
            'service_name' => 'nullable|string|max:100',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function save(): void
    {
        $this->validate();

        if (! $this->customer) {
            session()->flash('error', 'Ingen organisation hittades.');

            return;
        }

        $data = [
            'service_name' => $this->service_name ?: null,
        ];

        if ($this->logo) {
            if ($this->customer->logo_path) {
                Storage::disk('public')->delete($this->customer->logo_path);
            }

            $path = $this->logo->store('logos', 'public');
            $data['logo_path'] = $path;
            $this->currentLogoUrl = asset('storage/'.$path);
        }

        $this->customer->update($data);
        $this->logo = null;

        session()->flash('message', 'Varumärkesinställningar sparade!');
    }

    public function removeLogo(): void
    {
        if ($this->customer && $this->customer->logo_path) {
            Storage::disk('public')->delete($this->customer->logo_path);
            $this->customer->update(['logo_path' => null]);
            $this->currentLogoUrl = null;

            session()->flash('message', 'Logotypen har tagits bort.');
        }
    }

    public function render()
    {
        return view('livewire.settings.branding', [
            'previewStation' => $this->previewStation,
        ])->layout('layouts.app');
    }
}
