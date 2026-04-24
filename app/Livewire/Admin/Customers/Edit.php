<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class Edit extends Component
{
    public Customer $customer;

    public string $activeTab = 'basic';

    // Basic Info
    public string $name = '';

    public ?string $org_number = '';

    public string $email = '';

    public ?string $phone = '';

    // Address
    public ?string $address = '';

    public ?string $city = '';

    public ?string $postal_code = '';

    public string $country = '';

    // Subscription
    public string $subscription_status = '';

    public ?string $trial_ends_at = null;

    public bool $is_enterprise = false;

    public bool $is_active = true;

    // Limits
    public ?int $max_facilities = null;

    public ?int $max_stations = null;

    public ?int $max_scans_per_month = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'org_number' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'subscription_status' => 'required|in:trial,active,suspended,cancelled',
            'trial_ends_at' => 'nullable|date',
            'is_enterprise' => 'boolean',
            'is_active' => 'boolean',
            'max_facilities' => 'nullable|integer|min:1',
            'max_stations' => 'nullable|integer|min:1',
            'max_scans_per_month' => 'nullable|integer|min:1',
        ];
    }

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->fill([
            'name' => $customer->name,
            'org_number' => $customer->org_number,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'city' => $customer->city,
            'postal_code' => $customer->postal_code,
            'country' => $customer->country ?? 'Sverige',
            'subscription_status' => $customer->subscription_status ?? 'trial',
            'trial_ends_at' => $customer->trial_ends_at?->format('Y-m-d'),
            'is_enterprise' => $customer->is_enterprise,
            'is_active' => $customer->is_active,
            'max_facilities' => $customer->max_facilities,
            'max_stations' => $customer->max_stations,
            'max_scans_per_month' => $customer->max_scans_per_month,
        ]);
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function save(): void
    {
        $this->validate();

        $this->customer->update([
            'name' => $this->name,
            'org_number' => $this->org_number ?: null,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
            'city' => $this->city ?: null,
            'postal_code' => $this->postal_code ?: null,
            'country' => $this->country,
            'subscription_status' => $this->subscription_status,
            'trial_ends_at' => $this->subscription_status === 'trial' ? $this->trial_ends_at : null,
            'is_enterprise' => $this->is_enterprise,
            'is_active' => $this->is_active,
            'max_facilities' => $this->max_facilities,
            'max_stations' => $this->max_stations,
            'max_scans_per_month' => $this->max_scans_per_month,
        ]);

        session()->flash('success', __('admin.customers.updated_success'));
    }

    public function extendTrial(int $days = 14): void
    {
        $currentEnd = $this->customer->trial_ends_at ?? now();
        $newEnd = $currentEnd->addDays($days);

        $this->customer->update([
            'trial_ends_at' => $newEnd,
            'subscription_status' => 'trial',
        ]);

        $this->trial_ends_at = $newEnd->format('Y-m-d');
        $this->subscription_status = 'trial';

        session()->flash('success', __('admin.customers.trial_extended', ['days' => $days]));
    }

    public function activate(): void
    {
        $this->customer->update([
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        $this->subscription_status = 'active';
        $this->is_active = true;

        session()->flash('success', __('admin.customers.activated_success'));
    }

    public function suspend(): void
    {
        $this->customer->update([
            'subscription_status' => 'suspended',
            'is_active' => false,
        ]);

        $this->subscription_status = 'suspended';
        $this->is_active = false;

        session()->flash('success', __('admin.customers.suspended_success'));
    }

    public function render()
    {
        $this->customer->loadCount(['facilities', 'users']);
        $this->customer->load(['facilities' => function ($query) {
            $query->withCount('stations');
        }]);

        $stationsCount = $this->customer->facilities->sum('stations_count');

        $usageStats = $this->customer->monthlyUsage()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        return view('livewire.admin.customers.edit', [
            'stationsCount' => $stationsCount,
            'usageStats' => $usageStats,
        ])->layout('components.layouts.admin', ['title' => __('admin.customers.edit_title')]);
    }
}
