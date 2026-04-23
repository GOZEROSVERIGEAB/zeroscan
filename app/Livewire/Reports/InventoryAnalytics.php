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
#[Title('Inventarieanalys')]
class InventoryAnalytics extends Component
{
    #[Url]
    public string $period = '30d';

    #[Url]
    public ?int $facilityId = null;

    #[Url]
    public ?int $stationId = null;

    #[Url]
    public ?string $category = null;

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

    public function setCategory(?string $category): void
    {
        $this->category = $category;
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
            'avg_value' => $summary['total_items'] > 0
                ? round(($summary['estimated_value'] ?? 0) / $summary['total_items'], 0)
                : 0,
            'avg_condition' => $summary['avg_condition'] ?? 0,
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
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    #[Computed]
    public function brandDistribution(): array
    {
        $brands = $this->service->getBrandDistribution(10);
        $total = $brands->sum('count');

        return $brands->map(function ($brand) use ($total) {
            return [
                'name' => $brand->brand,
                'count' => $brand->count,
                'percentage' => $total > 0 ? round(($brand->count / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    #[Computed]
    public function conditionDistribution(): array
    {
        $conditions = $this->service->getConditionDistribution();
        $total = $conditions->sum();
        $result = [];

        for ($i = 1; $i <= 5; $i++) {
            $count = $conditions->get($i, 0);
            $result[] = [
                'rating' => $i,
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        }

        return $result;
    }

    #[Computed]
    public function hourlyDistribution(): array
    {
        $hourly = $this->service->getHourlyDistribution();

        return collect(range(0, 23))->map(function ($hour) use ($hourly) {
            return [
                'hour' => $hour,
                'count' => $hourly->get($hour, 0),
            ];
        })->toArray();
    }

    #[Computed]
    public function weekdayDistribution(): array
    {
        $weekday = $this->service->getWeekdayDistribution();

        return collect(range(1, 7))->map(function ($day) use ($weekday) {
            return [
                'day' => $day,
                'count' => $weekday->get($day, 0),
            ];
        })->toArray();
    }

    #[Computed]
    public function aiConfidenceDistribution(): array
    {
        $confidence = $this->service->getAiConfidenceDistribution();
        $total = $confidence->sum('count');

        return $confidence->map(function ($item) use ($total) {
            return [
                'range' => $item->confidence_range,
                'count' => $item->count,
                'percentage' => $total > 0 ? round(($item->count / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    #[Computed]
    public function facilityComparison(): array
    {
        return $this->service->getFacilityComparison()->map(function ($fac) {
            return [
                'name' => $fac->name,
                'items' => $fac->count,
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

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        return view('livewire.reports.inventory-analytics', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
