<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleActive(Customer $customer): void
    {
        $customer->update(['is_active' => ! $customer->is_active]);
    }

    public function activate(Customer $customer): void
    {
        $customer->update([
            'subscription_status' => Customer::STATUS_ACTIVE,
            'is_active' => true,
        ]);
    }

    public function suspend(Customer $customer): void
    {
        $customer->update([
            'subscription_status' => Customer::STATUS_SUSPENDED,
            'is_active' => false,
        ]);
    }

    public function render()
    {
        $customers = Customer::query()
            ->withCount(['facilities', 'users'])
            ->with(['facilities' => function ($query) {
                $query->withCount('stations');
            }])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('org_number', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, function ($query) {
                $query->where('subscription_status', $this->status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        $customers->getCollection()->transform(function ($customer) {
            $customer->stations_count = $customer->facilities->sum('stations_count');

            return $customer;
        });

        $statusCounts = [
            'all' => Customer::count(),
            'trial' => Customer::where('subscription_status', 'trial')->count(),
            'active' => Customer::where('subscription_status', 'active')->count(),
            'suspended' => Customer::where('subscription_status', 'suspended')->count(),
            'cancelled' => Customer::where('subscription_status', 'cancelled')->count(),
        ];

        return view('livewire.admin.customers.index', [
            'customers' => $customers,
            'statusCounts' => $statusCounts,
        ])->layout('components.layouts.admin', ['title' => __('admin.customers.title')]);
    }
}
