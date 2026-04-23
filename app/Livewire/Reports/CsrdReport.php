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
#[Title('CSRD-rapport')]
class CsrdReport extends Component
{
    #[Url]
    public string $period = '365d';

    #[Url]
    public ?int $facilityId = null;

    #[Url]
    public string $comparisonType = 'yoy';

    public ?string $customStartDate = null;
    public ?string $customEndDate = null;

    public function mount(): void
    {
        $this->customStartDate = now()->startOfYear()->format('Y-m-d');
        $this->customEndDate = now()->format('Y-m-d');
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    public function setComparisonType(string $type): void
    {
        $this->comparisonType = $type;
    }

    private function getDateRange(): array
    {
        return match ($this->period) {
            'q1' => [now()->startOfYear(), now()->startOfYear()->addMonths(3)->subDay()],
            'q2' => [now()->startOfYear()->addMonths(3), now()->startOfYear()->addMonths(6)->subDay()],
            'q3' => [now()->startOfYear()->addMonths(6), now()->startOfYear()->addMonths(9)->subDay()],
            'q4' => [now()->startOfYear()->addMonths(9), now()->endOfYear()],
            '365d', 'ytd' => [now()->startOfYear(), now()],
            'custom' => [
                Carbon::parse($this->customStartDate),
                Carbon::parse($this->customEndDate),
            ],
            default => [now()->startOfYear(), now()],
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
            null,
            $startDate,
            $endDate,
            $this->getCustomerId()
        );
    }

    #[Computed]
    public function csrdMetrics(): array
    {
        $metrics = $this->service->getCsrdMetrics();

        return [
            'material_inflows' => $metrics['material_inflows']['value'] ?? 0,
            'reuse_rate' => $metrics['reuse_rate']['value'] ?? 0,
            'avg_condition' => $metrics['product_quality']['value'] ?? 0,
            'waste_prevented' => $metrics['waste_prevented']['value'] ?? 0,
            'circular_value' => $metrics['circular_value']['value'] ?? 0,
            'items_count' => $metrics['items_processed']['value'] ?? 0,
        ];
    }

    #[Computed]
    public function materialBreakdown(): array
    {
        $materials = $this->service->getMaterialBreakdown();
        $total = $materials->sum('total_weight');

        return $materials->map(function ($mat) use ($total) {
            return [
                'name' => $mat['material'] ?? 'Okänt',
                'weight' => $mat['total_weight'] ?? 0,
                'percentage' => $total > 0 ? round(($mat['total_weight'] / $total) * 100, 1) : 0,
            ];
        })->take(10)->values()->toArray();
    }

    #[Computed]
    public function facilityComparison(): array
    {
        return $this->service->getFacilityComparison()->map(function ($fac) {
            return [
                'name' => $fac->name,
                'items' => $fac->count,
                'co2' => $fac->co2,
                'value' => $fac->value,
            ];
        })->toArray();
    }

    #[Computed]
    public function comparison(): array
    {
        $comp = $this->service->getPeriodComparison();
        $changes = $comp['changes'] ?? [];

        return [
            'items_change' => $changes['total_items']['value'] ?? 0,
            'co2_change' => $changes['co2_saved']['value'] ?? 0,
            'value_change' => $changes['estimated_value']['value'] ?? 0,
            'weight_change' => 0, // Weight comparison not implemented
        ];
    }

    #[Computed]
    public function facilities()
    {
        return $this->service->getAvailableFacilities($this->getCustomerId());
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
                'weight' => 0, // Weight per category not tracked
                'co2_savings' => $cat->co2_total,
                'value' => $cat->value_total,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        return view('livewire.reports.csrd-report', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
