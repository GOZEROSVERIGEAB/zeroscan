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

    public function confirmDelete(Facility $facility): void
    {
        $this->facilityToDelete = $facility;
        $this->showDeleteModal = true;
    }

    public function deleteFacility(): void
    {
        if ($this->facilityToDelete) {
            $this->facilityToDelete->delete();
            session()->flash('message', __('scanit.facilities.deleted'));
        }

        $this->showDeleteModal = false;
        $this->facilityToDelete = null;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->facilityToDelete = null;
    }

    public function getFacilitiesProperty()
    {
        $user = Auth::user();

        return Facility::query()
            ->whereHas('customer', fn ($q) => $q->where('id', $user->customer_id))
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->withCount('stations')
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
