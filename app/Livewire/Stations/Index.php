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

    public function confirmDelete(Station $station): void
    {
        $this->stationToDelete = $station;
        $this->showDeleteModal = true;
    }

    public function deleteStation(): void
    {
        if ($this->stationToDelete) {
            $this->stationToDelete->delete();
            session()->flash('message', __('scanit.stations.deleted'));
        }

        $this->showDeleteModal = false;
        $this->stationToDelete = null;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->stationToDelete = null;
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
            ->whereHas('facility.customer', fn ($q) => $q->where('id', $user->customer_id))
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->facilityFilter, fn ($q) => $q->whereHas('facility', fn ($fq) => $fq->where('uuid', $this->facilityFilter)))
            ->with('facility')
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
