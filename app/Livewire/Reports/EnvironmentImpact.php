<?php

namespace App\Livewire\Reports;

use App\Services\Reports\ReportDataService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Miljöpåverkan')]
class EnvironmentImpact extends Component
{
    #[Url]
    public string $period = '30d';

    #[Url]
    public ?int $facilityId = null;

    #[Url]
    public ?int $stationId = null;

    public ?string $customStartDate = null;
    public ?string $customEndDate = null;

    public function mount(): void
    {
        $this->customStartDate = now()->subDays(30)->format('Y-m-d');
        $this->customEndDate = now()->format('Y-m-d');
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    private function getDateRange(): array
    {
        return match ($this->period) {
            '7d' => [now()->subDays(7), now()],
            '30d' => [now()->subDays(30), now()],
            '90d' => [now()->subDays(90), now()],
            '365d' => [now()->subYear(), now()],
            'ytd' => [now()->startOfYear(), now()],
            'all_time' => [Carbon::createFromDate(2020, 1, 1), now()],
            'custom' => [
                Carbon::parse($this->customStartDate),
                Carbon::parse($this->customEndDate),
            ],
            default => [now()->subDays(30), now()],
        };
    }

    private function getCustomerId(): ?int
    {
        return Auth::user()?->customer_id;
    }

    #[Computed]
    public function service(): ReportDataService
    {
        [$startDate, $endDate] = $this->getDateRange();

        return new ReportDataService(
            $this->facilityId,
            $this->stationId,
            $startDate,
            $endDate,
            $this->getCustomerId()
        );
    }

    #[Computed]
    public function impact(): array
    {
        $env = $this->service->getEnvironmentalImpact();

        return [
            'co2_savings' => $env['co2_kg'] ?? 0,
            'water_savings' => $env['water_liters'] ?? 0,
            'energy_savings' => $env['energy_kwh'] ?? 0,
            'equivalents' => $env['equivalents'] ?? [
                'trees' => 0,
                'car_km' => 0,
                'showers' => 0,
                'phone_charges' => 0,
                'flights' => $env['equivalents']['flights_nyc'] ?? 0,
            ],
        ];
    }

    #[Computed]
    public function timeSeries(): array
    {
        $series = $this->service->getTimeSeries('day');

        return [
            'labels' => $series->pluck('period')->toArray(),
            'data' => $series->pluck('co2')->toArray(),
        ];
    }

    #[Computed]
    public function categoryBreakdown(): array
    {
        $categories = $this->service->getCategoryBreakdown();
        $total = $categories->sum('count');

        return $categories->map(function ($cat) use ($total) {
            return [
                'name' => $cat->category,
                'count' => $cat->count,
                'co2_savings' => $cat->co2_total,
                'value' => $cat->value_total,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    #[Computed]
    public function facilities()
    {
        return $this->service->getAvailableFacilities($this->getCustomerId());
    }

    #[Computed]
    public function stations()
    {
        return $this->service->getAvailableStations($this->facilityId);
    }

    #[Computed]
    public function lifetime(): array
    {
        $lifetime = $this->service->getLifetimeImpact();

        return [
            'items' => $lifetime['total_items'] ?? 0,
            'co2' => $lifetime['co2_kg'] ?? 0,
            'water' => $lifetime['water_liters'] ?? 0,
            'value' => $lifetime['value_sek'] ?? 0,
        ];
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        return view('livewire.reports.environment-impact', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
