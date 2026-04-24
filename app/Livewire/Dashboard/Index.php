<?php

namespace App\Livewire\Dashboard;

use App\Models\Facility;
use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public string $period = '7';

    public function mount(): void
    {
        $this->period = '7';
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    protected function getTeamStationIds(): array
    {
        $user = Auth::user();

        // Use user's customer_id to find stations
        if ($user->customer_id) {
            return Station::whereHas('facility', function ($query) use ($user) {
                $query->where('customer_id', $user->customer_id);
            })->pluck('id')->toArray();
        }

        return [];
    }

    protected function getPeriodStart(): Carbon
    {
        return match ($this->period) {
            '7' => now()->subDays(7),
            '30' => now()->subDays(30),
            '90' => now()->subDays(90),
            '365' => now()->subYear(),
            default => now()->subDays(7),
        };
    }

    protected function getPreviousPeriodStart(): Carbon
    {
        $days = (int) $this->period;

        return $this->getPeriodStart()->subDays($days);
    }

    public function getStatsProperty(): array
    {
        $stationIds = $this->getTeamStationIds();
        $periodStart = $this->getPeriodStart();
        $previousStart = $this->getPreviousPeriodStart();

        // Current period stats
        $currentItems = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->where('created_at', '>=', $periodStart)
            ->count();

        $currentCo2 = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->where('created_at', '>=', $periodStart)
            ->sum('co2_savings');

        $currentValue = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->where('created_at', '>=', $periodStart)
            ->sum('estimated_value');

        $currentVisitors = ScanningSession::whereIn('station_id', $stationIds)
            ->where('created_at', '>=', $periodStart)
            ->count();

        // Previous period stats for comparison
        $previousItems = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereBetween('created_at', [$previousStart, $periodStart])
            ->count();

        $previousCo2 = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereBetween('created_at', [$previousStart, $periodStart])
            ->sum('co2_savings');

        $previousValue = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereBetween('created_at', [$previousStart, $periodStart])
            ->sum('estimated_value');

        $previousVisitors = ScanningSession::whereIn('station_id', $stationIds)
            ->whereBetween('created_at', [$previousStart, $periodStart])
            ->count();

        return [
            'items' => [
                'value' => $currentItems,
                'change' => $this->calculateChange($currentItems, $previousItems),
            ],
            'co2' => [
                'value' => $currentCo2 / 1000, // Convert to tons
                'change' => $this->calculateChange($currentCo2, $previousCo2),
            ],
            'value' => [
                'value' => $currentValue / 1000, // Convert to tkr
                'change' => $this->calculateChange($currentValue, $previousValue),
            ],
            'visitors' => [
                'value' => $currentVisitors,
                'change' => $this->calculateChange($currentVisitors, $previousVisitors),
            ],
        ];
    }

    protected function calculateChange(float $current, float $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function getChartDataProperty(): array
    {
        $stationIds = $this->getTeamStationIds();
        $days = min((int) $this->period, 30); // Max 30 days for chart

        $data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->locale('sv')->isoFormat('ddd');

            $count = Inventory::whereIn('station_id', $stationIds)
                ->where('status', Inventory::STATUS_COMPLETED)
                ->whereDate('created_at', $date->toDateString())
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function getCategoriesProperty(): array
    {
        $stationIds = $this->getTeamStationIds();
        $periodStart = $this->getPeriodStart();

        $categories = Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->where('created_at', '>=', $periodStart)
            ->whereNotNull('category')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $total = $categories->sum('count');

        return $categories->map(function ($cat) use ($total) {
            return [
                'name' => $cat->category,
                'count' => $cat->count,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100) : 0,
            ];
        })->toArray();
    }

    public function getStationsProperty(): array
    {
        $stationIds = $this->getTeamStationIds();
        $periodStart = $this->getPeriodStart();

        return Station::whereIn('id', $stationIds)
            ->withCount(['inventories' => function ($query) use ($periodStart) {
                $query->where('status', Inventory::STATUS_COMPLETED)
                    ->where('inventories.created_at', '>=', $periodStart);
            }])
            ->orderByDesc('inventories_count')
            ->limit(5)
            ->get()
            ->map(function ($station) {
                return [
                    'id' => $station->id,
                    'name' => $station->name,
                    'count' => $station->inventories_count,
                    'is_active' => $station->is_active,
                ];
            })
            ->toArray();
    }

    public function getFacilitiesProperty(): array
    {
        $user = Auth::user();
        $periodStart = $this->getPeriodStart();

        if (! $user->customer_id) {
            return [];
        }

        return Facility::where('customer_id', $user->customer_id)
            ->withCount(['inventories' => function ($q) use ($periodStart) {
                $q->where('status', Inventory::STATUS_COMPLETED)
                    ->where('inventories.created_at', '>=', $periodStart);
            }])
            ->orderByDesc('inventories_count')
            ->limit(5)
            ->get()
            ->map(function ($facility) {
                return [
                    'id' => $facility->id,
                    'name' => $facility->name,
                    'count' => $facility->inventories_count,
                ];
            })
            ->toArray();
    }

    public function getRecentActivityProperty(): array
    {
        $stationIds = $this->getTeamStationIds();

        return Inventory::whereIn('station_id', $stationIds)
            ->where('status', Inventory::STATUS_COMPLETED)
            ->with('station')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->name ?? 'Okänt föremål',
                    'station' => $item->station->name ?? '',
                    'co2_savings' => round($item->co2_savings ?? 0),
                    'category' => $item->category,
                    'image_url' => $item->image_url,
                    'time_ago' => $item->created_at->locale('sv')->diffForHumans(short: true),
                ];
            })
            ->toArray();
    }

    public function getActiveStationsCountProperty(): int
    {
        $stationIds = $this->getTeamStationIds();

        return Station::whereIn('id', $stationIds)
            ->where('is_active', true)
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.index')
            ->layout('layouts.app');
    }
}
