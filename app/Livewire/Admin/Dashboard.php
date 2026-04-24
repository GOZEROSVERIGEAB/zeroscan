<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Facility;
use App\Models\Inventory;
use App\Models\Station;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = $this->getStats();
        $recentCustomers = $this->getRecentCustomers();
        $expiringTrials = $this->getExpiringTrials();
        $topCustomers = $this->getTopCustomers();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentCustomers' => $recentCustomers,
            'expiringTrials' => $expiringTrials,
            'topCustomers' => $topCustomers,
        ])->layout('components.layouts.admin', ['title' => __('admin.dashboard.title')]);
    }

    private function getStats(): array
    {
        return [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('is_active', true)
                ->where(function ($query) {
                    $query->where('subscription_status', 'active')
                        ->orWhere(function ($q) {
                            $q->where('subscription_status', 'trial')
                                ->where(function ($q2) {
                                    $q2->whereNull('trial_ends_at')
                                        ->orWhere('trial_ends_at', '>=', now());
                                });
                        });
                })
                ->count(),
            'trial_customers' => Customer::where('subscription_status', 'trial')->count(),
            'total_facilities' => Facility::count(),
            'total_stations' => Station::count(),
            'total_scans' => Inventory::count(),
            'scans_this_month' => Inventory::where('created_at', '>=', now()->startOfMonth())->count(),
            'scans_today' => Inventory::where('created_at', '>=', now()->startOfDay())->count(),
        ];
    }

    private function getRecentCustomers()
    {
        return Customer::with(['facilities' => function ($query) {
            $query->withCount('stations');
        }])
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    private function getExpiringTrials()
    {
        return Customer::where('subscription_status', 'trial')
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '<=', now()->addDays(7))
            ->where('trial_ends_at', '>=', now())
            ->orderBy('trial_ends_at')
            ->limit(5)
            ->get();
    }

    private function getTopCustomers()
    {
        return Customer::withCount(['facilities', 'users'])
            ->with(['facilities' => function ($query) {
                $query->withCount('stations');
            }])
            ->orderByDesc('facilities_count')
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                $customer->stations_count = $customer->facilities->sum('stations_count');

                return $customer;
            });
    }
}
