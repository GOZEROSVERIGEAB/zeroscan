<?php

namespace App\Livewire\Stations;

use App\Models\Facility;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $facilityFilter = null;
    public bool $showDeleteModal = false;
    public ?Station $stationToDelete = null;

    protected $queryString = ['facilityFilter' => ['as' => 'facility']];

    public function mount(): void
    {
        if (request()->has('facility')) {
            $this->facilityFilter = request()->get('facility');
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getCanDeleteProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'delete');
    }

    public function getCanCreateProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'create');
    }

    public function getCanEditProperty(): bool
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        if (!$team) {
            return false;
        }

        return $user->hasTeamPermission($team, 'update');
    }

    public function confirmDelete(int $stationId): void
    {
        if (!$this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        $this->stationToDelete = Station::find($stationId);
        $this->showDeleteModal = true;
    }

    public function deleteStation(): void
    {
        if (!$this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));
            $this->showDeleteModal = false;
            $this->stationToDelete = null;

            return;
        }

        if ($this->stationToDelete) {
            $this->stationToDelete->delete();
            session()->flash('message', __('scanit.stations.archived'));
        }

        $this->showDeleteModal = false;
        $this->stationToDelete = null;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->stationToDelete = null;
    }

    public function restoreStation(int $stationId): void
    {
        if (!$this->canDelete) {
            session()->flash('error', __('Du har inte behörighet att utföra denna åtgärd.'));

            return;
        }

        $station = Station::withTrashed()->find($stationId);

        if ($station && $station->trashed()) {
            $station->restore();
            session()->flash('message', __('scanit.stations.restored'));
        }
    }

    public function copyLink(string $uuid): void
    {
        $this->dispatch('copy-to-clipboard', url: route('public.scan', $uuid));
    }

    public function getFacilitiesProperty()
    {
        $user = Auth::user();

        return Facility::query()
            ->whereHas('customer', fn ($q) => $q->where('id', $user->customer_id))
            ->orderBy('name')
            ->get();
    }

    public function getStationsProperty()
    {
        $user = Auth::user();

        return Station::query()
            ->withTrashed()
            ->whereHas('facility.customer', fn ($q) => $q->where('id', $user->customer_id))
            ->where(function ($q) {
                // Show active items OR soft-deleted within 7 days
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>=', now()->subDays(7));
            })
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->facilityFilter, fn ($q) => $q->whereHas('facility', fn ($fq) => $fq->withTrashed()->where('uuid', $this->facilityFilter)))
            ->with(['facility' => fn ($q) => $q->withTrashed()])
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.stations.index', [
            'stations' => $this->stations,
            'facilities' => $this->facilities,
        ])->layout('layouts.app');
    }
}
