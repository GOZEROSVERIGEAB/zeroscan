<?php

namespace App\Livewire\Stations;

use App\Models\Facility;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEdit extends Component
{
    use WithFileUploads;

    public ?Station $station = null;
    public bool $isEdit = false;

    public ?string $facility_id = null;
    public string $name = '';
    public string $description = '';
    public string $location_description = '';
    public string $info_page_text = '';
    public string $thank_you_text = '';
    public bool $is_active = true;
    public bool $require_email = false;
    public int $max_images = 5;
    public string $primary_color = '#97d700';

    // Branding override
    public bool $use_custom_branding = false;
    public $branding_logo = null;
    public ?string $branding_service_name = '';
    public ?string $currentLogoUrl = null;

    protected function rules(): array
    {
        return [
            'facility_id' => 'required|exists:facilities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location_description' => 'nullable|string|max:500',
            'info_page_text' => 'nullable|string|max:2000',
            'thank_you_text' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'require_email' => 'boolean',
            'max_images' => 'integer|min:1|max:10',
            'primary_color' => 'nullable|string|max:20',
            'use_custom_branding' => 'boolean',
            'branding_logo' => 'nullable|image|max:2048',
            'branding_service_name' => 'nullable|string|max:100',
        ];
    }

    public function mount(?Station $station = null): void
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if ($station && $station->exists) {
            // Edit mode - require update permission
            if (!$team || !$user->hasTeamPermission($team, 'update')) {
                abort(403, __('Du har inte behörighet att utföra denna åtgärd.'));
            }

            $this->station = $station;
            $this->isEdit = true;
            $this->facility_id = $station->facility_id;
            $this->name = $station->name;
            $this->description = $station->description ?? '';
            $this->location_description = $station->location_description ?? '';
            $this->info_page_text = $station->info_page_text ?? '';
            $this->thank_you_text = $station->thank_you_text ?? '';
            $this->is_active = $station->is_active;
            $this->require_email = $station->require_email ?? false;
            $this->max_images = $station->max_images ?? 5;
            $this->primary_color = $station->primary_color ?? '#97d700';
            $this->use_custom_branding = $station->use_custom_branding ?? false;
            $this->branding_service_name = $station->branding_service_name ?? '';
            $this->currentLogoUrl = $station->branding_logo_path ? asset('storage/' . $station->branding_logo_path) : null;
        } else {
            // Create mode - require create permission
            if (!$team || !$user->hasTeamPermission($team, 'create')) {
                abort(403, __('Du har inte behörighet att utföra denna åtgärd.'));
            }
        }
    }

    public function removeLogo(): void
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team || !$user->hasTeamPermission($team, 'update')) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        if ($this->station && $this->station->branding_logo_path) {
            Storage::disk('public')->delete($this->station->branding_logo_path);
            $this->station->update(['branding_logo_path' => null]);
            $this->currentLogoUrl = null;
        }
    }

    public function getSelectedFacilityProperty(): ?Facility
    {
        if (!$this->facility_id) {
            return null;
        }
        return Facility::find($this->facility_id);
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $team = $user->currentTeam;

        // Verify permission before saving
        $requiredPermission = $this->isEdit ? 'update' : 'create';
        if (!$team || !$user->hasTeamPermission($team, $requiredPermission)) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        $data = [
            'facility_id' => $this->facility_id,
            'name' => $this->name,
            'description' => $this->description ?: null,
            'location_description' => $this->location_description ?: null,
            'info_page_text' => $this->info_page_text ?: null,
            'thank_you_text' => $this->thank_you_text ?: null,
            'is_active' => $this->is_active,
            'require_email' => $this->require_email,
            'max_images' => $this->max_images,
            'primary_color' => $this->primary_color,
            'use_custom_branding' => $this->use_custom_branding,
            'branding_service_name' => $this->use_custom_branding ? ($this->branding_service_name ?: null) : null,
        ];

        // Handle logo upload
        if ($this->use_custom_branding && $this->branding_logo) {
            if ($this->isEdit && $this->station->branding_logo_path) {
                Storage::disk('public')->delete($this->station->branding_logo_path);
            }
            $data['branding_logo_path'] = $this->branding_logo->store('station-logos', 'public');
        }

        if ($this->isEdit) {
            $this->station->update($data);
            session()->flash('message', __('scanit.stations.updated'));
        } else {
            Station::create($data);
            session()->flash('message', __('scanit.stations.created'));
        }

        $this->redirect(route('stations.index'));
    }

    public function getFacilitiesProperty()
    {
        $user = Auth::user();

        return Facility::query()
            ->whereHas('customer', fn ($q) => $q->where('id', $user->customer_id))
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.stations.create-edit', [
            'facilities' => $this->facilities,
            'selectedFacility' => $this->selectedFacility,
        ])->layout('layouts.app');
    }
}
