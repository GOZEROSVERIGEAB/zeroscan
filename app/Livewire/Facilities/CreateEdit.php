<?php

namespace App\Livewire\Facilities;

use App\Models\Customer;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEdit extends Component
{
    use WithFileUploads;

    public ?Facility $facility = null;

    public bool $isEdit = false;

    public string $name = '';

    public string $description = '';

    public string $address = '';

    public string $city = '';

    public string $postal_code = '';

    public string $contact_name = '';

    public string $contact_email = '';

    public string $contact_phone = '';

    public bool $is_active = true;

    // Branding
    public $branding_logo = null;

    public ?string $branding_service_name = '';

    public ?string $currentLogoUrl = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'branding_logo' => 'nullable|image|max:2048',
            'branding_service_name' => 'nullable|string|max:100',
        ];
    }

    public function mount(?Facility $facility = null): void
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if ($facility && $facility->exists) {
            // Edit mode - require update permission
            if (! $team || ! $user->hasTeamPermission($team, 'update')) {
                abort(403, __('Du har inte behörighet att utföra denna åtgärd.'));
            }

            $this->facility = $facility;
            $this->isEdit = true;
            $this->name = $facility->name;
            $this->description = $facility->description ?? '';
            $this->address = $facility->address ?? '';
            $this->city = $facility->city ?? '';
            $this->postal_code = $facility->postal_code ?? '';
            $this->contact_name = $facility->contact_name ?? '';
            $this->contact_email = $facility->contact_email ?? '';
            $this->contact_phone = $facility->contact_phone ?? '';
            $this->is_active = $facility->is_active;
            $this->branding_service_name = $facility->branding_service_name ?? '';
            $this->currentLogoUrl = $facility->branding_logo_url;
        } else {
            // Create mode - require create permission
            if (! $team || ! $user->hasTeamPermission($team, 'create')) {
                abort(403, __('Du har inte behörighet att utföra denna åtgärd.'));
            }
        }
    }

    public function removeLogo(): void
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (! $team || ! $user->hasTeamPermission($team, 'update')) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        if ($this->facility && $this->facility->branding_logo_path) {
            Storage::disk('public')->delete($this->facility->branding_logo_path);
            $this->facility->update(['branding_logo_path' => null]);
            $this->currentLogoUrl = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $team = $user->currentTeam;

        // Verify permission before saving
        $requiredPermission = $this->isEdit ? 'update' : 'create';
        if (! $team || ! $user->hasTeamPermission($team, $requiredPermission)) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        // Get or create customer for user
        $customer = $user->customer;
        if (! $customer) {
            $customer = Customer::create([
                'name' => $user->currentTeam?->name ?? $user->name,
                'email' => $user->email,
                'is_active' => true,
            ]);
            $user->update(['customer_id' => $customer->id]);
        }

        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'address' => $this->address ?: null,
            'city' => $this->city ?: null,
            'postal_code' => $this->postal_code ?: null,
            'contact_name' => $this->contact_name ?: null,
            'contact_email' => $this->contact_email ?: null,
            'contact_phone' => $this->contact_phone ?: null,
            'is_active' => $this->is_active,
            'branding_service_name' => $this->branding_service_name ?: null,
        ];

        // Handle logo upload
        if ($this->branding_logo) {
            if ($this->isEdit && $this->facility->branding_logo_path) {
                Storage::disk('public')->delete($this->facility->branding_logo_path);
            }
            $data['branding_logo_path'] = $this->branding_logo->store('facility-logos', 'public');
        }

        if ($this->isEdit) {
            $this->facility->update($data);
            session()->flash('message', __('scanit.facilities.updated'));
        } else {
            $data['customer_id'] = $customer->id;
            Facility::create($data);
            session()->flash('message', __('scanit.facilities.created'));
        }

        $this->redirect(route('facilities.index'));
    }

    public function render()
    {
        return view('livewire.facilities.create-edit')
            ->layout('layouts.app');
    }
}
