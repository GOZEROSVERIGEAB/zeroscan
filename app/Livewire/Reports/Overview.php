<?php

namespace App\Livewire\Reports;

use App\Models\Station;
use App\Services\Reports\ReportDataService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Rapporter')]
class Overview extends Component
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
    public function kpis(): array
    {
        $summary = $this->service->getKPISummary();

        return [
            'items' => $summary['total_items'] ?? 0,
            'co2_savings' => $summary['co2_saved'] ?? 0,
            'water_savings' => $summary['water_saved'] ?? 0,
            'energy_savings' => $summary['energy_saved'] ?? 0,
            'estimated_value' => $summary['estimated_value'] ?? 0,
            'avg_condition' => $summary['avg_condition'] ?? 0,
            'sessions' => $summary['sessions'] ?? 0,
        ];
    }

    #[Computed]
    public function comparison(): array
    {
        return $this->service->getPeriodComparison();
    }

    #[Computed]
    public function timeSeries()
    {
        return $this->service->getTimeSeries('day');
    }

    #[Computed]
    public function categoryBreakdown()
    {
        return $this->service->getCategoryBreakdown();
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
        return $this->service->getLifetimeImpact();
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        return view('livewire.reports.overview', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
