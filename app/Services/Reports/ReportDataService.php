<?php

namespace App\Services\Reports;

use App\Models\Facility;
use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportDataService
{
    // Environmental impact conversion factors
    private const CO2_PER_TREE_YEARLY = 21; // kg CO2 absorbed per tree per year

    private const CO2_PER_CAR_KM = 0.12; // kg CO2 per km driven

    private const WATER_PER_SHOWER = 65; // liters per shower

    private const ENERGY_PER_PHONE_CHARGE = 0.012; // kWh per phone charge

    private const CO2_PER_FLIGHT_NYC = 1000; // kg CO2 Stockholm-NYC round trip

    private const WATER_PER_HOUSEHOLD_DAY = 150; // liters per day

    public function __construct(
        public ?int $facilityId = null,
        public ?int $stationId = null,
        public ?Carbon $startDate = null,
        public ?Carbon $endDate = null,
        public ?int $customerId = null,
    ) {
        $this->startDate = $startDate ?? now()->subDays(30);
        $this->endDate = $endDate ?? now();
    }

    public function setFilters(
        ?int $facilityId = null,
        ?int $stationId = null,
        ?Carbon $startDate = null,
        ?Carbon $endDate = null,
        ?int $customerId = null
    ): self {
        $this->facilityId = $facilityId;
        $this->stationId = $stationId;
        $this->startDate = $startDate ?? $this->startDate;
        $this->endDate = $endDate ?? $this->endDate;
        $this->customerId = $customerId;

        return $this;
    }

    private function baseQuery()
    {
        return Inventory::query()
            ->where('status', Inventory::STATUS_COMPLETED)
            ->when($this->stationId, fn ($q) => $q->where('station_id', $this->stationId))
            ->when($this->facilityId && ! $this->stationId, function ($q) {
                $stationIds = Station::where('facility_id', $this->facilityId)->pluck('id');

                return $q->whereIn('station_id', $stationIds);
            })
            ->when($this->customerId, function ($q) {
                $stationIds = Station::whereHas('facility', function ($fq) {
                    $fq->where('customer_id', $this->customerId);
                })->pluck('id');

                return $q->whereIn('station_id', $stationIds);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    public function getKPISummary(): array
    {
        $query = $this->baseQuery();

        $totals = $query->selectRaw('
            COUNT(*) as total_items,
            COALESCE(SUM(co2_savings), 0) as co2_saved,
            COALESCE(SUM(water_savings), 0) as water_saved,
            COALESCE(SUM(energy_savings), 0) as energy_saved,
            COALESCE(SUM(estimated_value), 0) as estimated_value,
            COALESCE(AVG(condition_rating), 0) as avg_condition
        ')->first();

        $sessions = ScanningSession::query()
            ->where('status', ScanningSession::STATUS_COMPLETED)
            ->when($this->stationId, fn ($q) => $q->where('station_id', $this->stationId))
            ->when($this->facilityId && ! $this->stationId, function ($q) {
                $stationIds = Station::where('facility_id', $this->facilityId)->pluck('id');

                return $q->whereIn('station_id', $stationIds);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();

        return [
            'total_items' => $totals->total_items ?? 0,
            'co2_saved' => round($totals->co2_saved ?? 0, 2),
            'water_saved' => round($totals->water_saved ?? 0, 2),
            'energy_saved' => round($totals->energy_saved ?? 0, 2),
            'estimated_value' => round($totals->estimated_value ?? 0, 2),
            'avg_condition' => round($totals->avg_condition ?? 0, 1),
            'sessions' => $sessions,
            'items_per_session' => $sessions > 0 ? round(($totals->total_items ?? 0) / $sessions, 1) : 0,
        ];
    }

    public function getEnvironmentalImpact(): array
    {
        $totals = $this->baseQuery()
            ->selectRaw('
                COALESCE(SUM(co2_savings), 0) as total_co2,
                COALESCE(SUM(water_savings), 0) as total_water,
                COALESCE(SUM(energy_savings), 0) as total_energy,
                COALESCE(SUM(weight), 0) as total_weight
            ')
            ->first();

        $co2 = $totals->total_co2 ?? 0;
        $water = $totals->total_water ?? 0;
        $energy = $totals->total_energy ?? 0;

        return [
            'co2_kg' => round($co2, 2),
            'co2_ton' => round($co2 / 1000, 2),
            'water_liters' => round($water, 2),
            'water_m3' => round($water / 1000, 2),
            'energy_kwh' => round($energy, 2),
            'weight_kg' => round($totals->total_weight ?? 0, 2),
            'equivalents' => $this->calculateEquivalents($co2, $water, $energy),
        ];
    }

    public function calculateEquivalents(float $co2, float $water, float $energy): array
    {
        return [
            'trees' => round($co2 / self::CO2_PER_TREE_YEARLY, 1),
            'car_km' => round($co2 / self::CO2_PER_CAR_KM, 0),
            'showers' => round($water / self::WATER_PER_SHOWER, 0),
            'phone_charges' => round($energy / self::ENERGY_PER_PHONE_CHARGE, 0),
            'flights_nyc' => round($co2 / self::CO2_PER_FLIGHT_NYC, 1),
            'household_days' => round($water / self::WATER_PER_HOUSEHOLD_DAY, 1),
        ];
    }

    public function getCategoryBreakdown(): Collection
    {
        return $this->baseQuery()
            ->select('category')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COALESCE(SUM(co2_savings), 0) as co2_total')
            ->selectRaw('COALESCE(SUM(water_savings), 0) as water_total')
            ->selectRaw('COALESCE(SUM(energy_savings), 0) as energy_total')
            ->selectRaw('COALESCE(SUM(estimated_value), 0) as value_total')
            ->selectRaw('COALESCE(AVG(condition_rating), 0) as avg_condition')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get();
    }

    public function getTimeSeries(string $granularity = 'day'): Collection
    {
        $dateFormat = match ($granularity) {
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };

        return $this->baseQuery()
            ->selectRaw("DATE_FORMAT(created_at, '{$dateFormat}') as period")
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COALESCE(SUM(co2_savings), 0) as co2')
            ->selectRaw('COALESCE(SUM(water_savings), 0) as water')
            ->selectRaw('COALESCE(SUM(energy_savings), 0) as energy')
            ->selectRaw('COALESCE(SUM(estimated_value), 0) as value')
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }

    public function getFacilityComparison(): Collection
    {
        return Inventory::query()
            ->where('inventories.status', Inventory::STATUS_COMPLETED)
            ->whereBetween('inventories.created_at', [$this->startDate, $this->endDate])
            ->join('stations', 'inventories.station_id', '=', 'stations.id')
            ->join('facilities', 'stations.facility_id', '=', 'facilities.id')
            ->when($this->customerId, fn ($q) => $q->where('facilities.customer_id', $this->customerId))
            ->select('facilities.id', 'facilities.name')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COALESCE(SUM(inventories.co2_savings), 0) as co2')
            ->selectRaw('COALESCE(SUM(inventories.water_savings), 0) as water')
            ->selectRaw('COALESCE(SUM(inventories.energy_savings), 0) as energy')
            ->selectRaw('COALESCE(SUM(inventories.estimated_value), 0) as value')
            ->groupBy('facilities.id', 'facilities.name')
            ->orderByDesc('count')
            ->get();
    }

    public function getStationComparison(): Collection
    {
        return $this->baseQuery()
            ->join('stations', 'inventories.station_id', '=', 'stations.id')
            ->select('stations.id', 'stations.name')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COALESCE(SUM(inventories.co2_savings), 0) as co2')
            ->selectRaw('COALESCE(SUM(inventories.water_savings), 0) as water')
            ->selectRaw('COALESCE(SUM(inventories.energy_savings), 0) as energy')
            ->selectRaw('COALESCE(SUM(inventories.estimated_value), 0) as value')
            ->groupBy('stations.id', 'stations.name')
            ->orderByDesc('count')
            ->get();
    }

    public function getMaterialBreakdown(): Collection
    {
        // Parse materials from JSON column
        return $this->baseQuery()
            ->whereNotNull('materials')
            ->get()
            ->flatMap(function ($item) {
                $materials = is_array($item->materials) ? $item->materials : [];

                return collect($materials)->map(function ($material) use ($item) {
                    $materialName = is_array($material) ? ($material['name'] ?? $material['material'] ?? 'unknown') : $material;

                    return [
                        'material' => $materialName,
                        'weight' => $item->weight ?? 1,
                    ];
                });
            })
            ->groupBy('material')
            ->map(function ($items, $material) {
                return [
                    'material' => $material,
                    'total_weight' => $items->sum('weight'),
                    'count' => $items->count(),
                ];
            })
            ->values()
            ->sortByDesc('total_weight')
            ->values();
    }

    public function getPeriodComparison(): array
    {
        $periodLength = $this->startDate->diffInDays($this->endDate);

        $previousStart = $this->startDate->copy()->subDays($periodLength);
        $previousEnd = $this->startDate->copy()->subDay();

        $current = $this->getKPISummary();

        $previousService = new self(
            $this->facilityId,
            $this->stationId,
            $previousStart,
            $previousEnd,
            $this->customerId
        );
        $previous = $previousService->getKPISummary();

        return [
            'current' => $current,
            'previous' => $previous,
            'changes' => [
                'total_items' => $this->calculateChange($current['total_items'], $previous['total_items']),
                'co2_saved' => $this->calculateChange($current['co2_saved'], $previous['co2_saved']),
                'water_saved' => $this->calculateChange($current['water_saved'], $previous['water_saved']),
                'energy_saved' => $this->calculateChange($current['energy_saved'], $previous['energy_saved']),
                'estimated_value' => $this->calculateChange($current['estimated_value'], $previous['estimated_value']),
                'sessions' => $this->calculateChange($current['sessions'], $previous['sessions']),
            ],
        ];
    }

    private function calculateChange(float $current, float $previous): array
    {
        if ($previous == 0) {
            return [
                'value' => $current > 0 ? 100 : 0,
                'direction' => $current > 0 ? 'up' : 'none',
            ];
        }

        $change = (($current - $previous) / $previous) * 100;

        return [
            'value' => round(abs($change), 1),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'none'),
        ];
    }

    public function getConditionDistribution(): Collection
    {
        return $this->baseQuery()
            ->selectRaw('condition_rating, COUNT(*) as count')
            ->whereNotNull('condition_rating')
            ->groupBy('condition_rating')
            ->orderBy('condition_rating')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->condition_rating => $item->count];
            });
    }

    public function getBrandDistribution(int $limit = 10): Collection
    {
        return $this->baseQuery()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->select('brand')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('COALESCE(SUM(estimated_value), 0) as total_value')
            ->groupBy('brand')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }

    public function getHourlyDistribution(): Collection
    {
        return $this->baseQuery()
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour');
    }

    public function getWeekdayDistribution(): Collection
    {
        return $this->baseQuery()
            ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day');
    }

    public function getAiConfidenceDistribution(): Collection
    {
        return $this->baseQuery()
            ->whereNotNull('ai_confidence')
            ->selectRaw('
                CASE
                    WHEN ai_confidence >= 0.9 THEN "90-100%"
                    WHEN ai_confidence >= 0.8 THEN "80-90%"
                    WHEN ai_confidence >= 0.7 THEN "70-80%"
                    WHEN ai_confidence >= 0.6 THEN "60-70%"
                    ELSE "< 60%"
                END as confidence_range
            ')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('confidence_range')
            ->get();
    }

    public function getCsrdMetrics(): array
    {
        $items = $this->baseQuery();

        $totalWeight = $items->sum('weight') ?? 0;
        $totalItems = $items->count();
        $avgCondition = $items->avg('condition_rating') ?? 0;
        $totalValue = $items->sum('estimated_value') ?? 0;

        // Estimate waste prevented (weight * condition factor)
        $wastePrevented = $this->baseQuery()
            ->selectRaw('COALESCE(SUM(weight * (condition_rating / 5)), 0) as prevented')
            ->first()
            ->prevented ?? 0;

        return [
            'material_inflows' => [
                'value' => round($totalWeight, 2),
                'unit' => 'kg',
                'esrs_code' => 'E5-4',
            ],
            'reuse_rate' => [
                'value' => $totalWeight > 0 ? round(($wastePrevented / $totalWeight) * 100, 1) : 0,
                'unit' => '%',
                'esrs_code' => 'E5-2',
            ],
            'product_quality' => [
                'value' => round($avgCondition, 2),
                'unit' => '1-5',
                'esrs_code' => 'E5-3',
            ],
            'waste_prevented' => [
                'value' => round($wastePrevented, 2),
                'unit' => 'kg',
                'esrs_code' => 'E5-4',
            ],
            'circular_value' => [
                'value' => round($totalValue, 2),
                'unit' => 'SEK',
                'esrs_code' => 'E5-5',
            ],
            'items_processed' => [
                'value' => $totalItems,
                'unit' => 'st',
                'esrs_code' => 'E5-4',
            ],
        ];
    }

    public function getLifetimeImpact(): array
    {
        $totals = Inventory::query()
            ->where('status', Inventory::STATUS_COMPLETED)
            ->when($this->stationId, fn ($q) => $q->where('station_id', $this->stationId))
            ->when($this->facilityId && ! $this->stationId, function ($q) {
                $stationIds = Station::where('facility_id', $this->facilityId)->pluck('id');

                return $q->whereIn('station_id', $stationIds);
            })
            ->when($this->customerId, function ($q) {
                $stationIds = Station::whereHas('facility', function ($fq) {
                    $fq->where('customer_id', $this->customerId);
                })->pluck('id');

                return $q->whereIn('station_id', $stationIds);
            })
            ->selectRaw('
                COUNT(*) as total_items,
                COALESCE(SUM(co2_savings), 0) as total_co2,
                COALESCE(SUM(water_savings), 0) as total_water,
                COALESCE(SUM(energy_savings), 0) as total_energy,
                COALESCE(SUM(estimated_value), 0) as total_value,
                MIN(created_at) as first_scan,
                MAX(created_at) as last_scan
            ')
            ->first();

        return [
            'total_items' => $totals->total_items ?? 0,
            'co2_kg' => round($totals->total_co2 ?? 0, 2),
            'water_liters' => round($totals->total_water ?? 0, 2),
            'energy_kwh' => round($totals->total_energy ?? 0, 2),
            'value_sek' => round($totals->total_value ?? 0, 2),
            'first_scan' => $totals->first_scan,
            'last_scan' => $totals->last_scan,
            'equivalents' => $this->calculateEquivalents(
                $totals->total_co2 ?? 0,
                $totals->total_water ?? 0,
                $totals->total_energy ?? 0
            ),
        ];
    }

    public function getAvailableFacilities(?int $customerId = null): Collection
    {
        return Facility::query()
            ->where('is_active', true)
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->orderBy('name')
            ->get(['id', 'name', 'city']);
    }

    public function getAvailableStations(?int $facilityId = null): Collection
    {
        return Station::query()
            ->when($facilityId, fn ($q) => $q->where('facility_id', $facilityId))
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'facility_id']);
    }
}
