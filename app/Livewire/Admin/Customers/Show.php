<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class Show extends Component
{
    public Customer $customer;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function activate(): void
    {
        $this->customer->update([
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        session()->flash('success', __('admin.customers.activated_success'));
    }

    public function suspend(): void
    {
        $this->customer->update([
            'subscription_status' => 'suspended',
            'is_active' => false,
        ]);

        session()->flash('success', __('admin.customers.suspended_success'));
    }

    public function render()
    {
        $this->customer->loadCount(['facilities', 'users']);
        $this->customer->load([
            'facilities' => function ($query) {
                $query->withCount('stations');
            },
            'users',
        ]);

        $stationsCount = $this->customer->facilities->sum('stations_count');

        return view('livewire.admin.customers.show', [
            'stationsCount' => $stationsCount,
        ])->layout('components.layouts.admin', ['title' => $this->customer->name]);
    }
}
