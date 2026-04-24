<?php

namespace App\Livewire\Facilities;

use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showDeleteModal = false;

    public ?Facility $facilityToDelete = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getCanDeleteProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (! $team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'delete');
    }

    public function getCanCreateProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (! $team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'create');
    }

    public function getCanEditProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (! $team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'update');
    }

    public function confirmDelete(int $facilityId): void
    {
        if (! $this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        $this->facilityToDelete = Facility::find($facilityId);
        $this->showDeleteModal = true;
    }

    public function deleteFacility(): void
    {
        if (! $this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));
            $this->showDeleteModal = false;
            $this->facilityToDelete = null;

            return;
        }

        if ($this->facilityToDelete) {
            // Soft delete all stations belonging to this facility
            $this->facilityToDelete->stations()->delete();
            // Soft delete the facility
            $this->facilityToDelete->delete();
            session()->flash('message', __('scanit.facilities.archived'));
        }

        $this->showDeleteModal = false;
        $this->facilityToDelete = null;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->facilityToDelete = null;
    }

    public function restoreFacility(int $facilityId): void
    {
        if (! $this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        $facility = Facility::withTrashed()->find($facilityId);

        if ($facility && $facility->trashed()) {
            $facility->restore();
            // Also restore all stations belonging to this facility
            $facility->stations()->withTrashed()->restore();
            session()->flash('message', __('scanit.facilities.restored'));
        }
    }

    public function getFacilitiesProperty()
    {
        $user = Auth::user();

        return Facility::query()
            ->withTrashed()
            ->whereHas('customer', fn ($q) => $q->where('id', $user->customer_id))
            ->where(function ($q) {
                // Show active items OR soft-deleted within 7 days
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>=', now()->subDays(7));
            })
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->withCount(['stations' => fn ($q) => $q->withTrashed()])
            ->withSum(['stations' => fn ($q) => $q->withTrashed()], 'total_scans')
            ->withSum(['stations' => fn ($q) => $q->withTrashed()], 'total_items')
            ->withSum(['stations' => fn ($q) => $q->withTrashed()], 'total_co2_savings')
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.facilities.index', [
            'facilities' => $this->facilities,
        ])->layout('layouts.app');
    }
}
