<?php

namespace App\Exports;

use App\Models\Inventory;
use App\Services\Reports\ReportDataService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(
        protected ReportDataService $service,
        protected Carbon $startDate,
        protected Carbon $endDate
    ) {}

    public function query()
    {
        return Inventory::query()
            ->with(['station.facility', 'scanningSession'])
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->when($this->service->facilityId, function ($query) {
                $query->whereHas('station', function ($q) {
                    $q->where('facility_id', $this->service->facilityId);
                });
            })
            ->when($this->service->customerId, function ($query) {
                $query->whereHas('station.facility', function ($q) {
                    $q->where('customer_id', $this->service->customerId);
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Namn',
            'Kategori',
            'Varumärke',
            'Skick (1-5)',
            'Uppskattat värde (kr)',
            'CO2 besparat (kg)',
            'Vatten besparat (l)',
            'Energi besparat (kWh)',
            'Anläggning',
            'Station',
            'Registrerad',
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->id,
            $inventory->name ?? 'Okänt föremål',
            $inventory->category ?? '-',
            $inventory->brand ?? '-',
            $inventory->condition_rating ?? '-',
            $inventory->estimated_value ?? 0,
            number_format($inventory->co2_savings ?? 0, 2),
            number_format($inventory->water_savings ?? 0, 2),
            number_format($inventory->energy_savings ?? 0, 2),
            $inventory->station?->facility?->name ?? '-',
            $inventory->station?->name ?? '-',
            $inventory->created_at?->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
