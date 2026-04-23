<?php

namespace App\Exports;

use App\Services\Reports\ReportDataService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnvironmentalReportExport implements WithMultipleSheets
{
    public function __construct(
        protected ReportDataService $service,
        protected Carbon $startDate,
        protected Carbon $endDate
    ) {}

    public function sheets(): array
    {
        return [
            new SummarySheet($this->service, $this->startDate, $this->endDate),
            new CategoriesSheet($this->service),
            new TimeSeriesSheet($this->service),
        ];
    }
}

class SummarySheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    public function __construct(
        protected ReportDataService $service,
        protected Carbon $startDate,
        protected Carbon $endDate
    ) {}

    public function array(): array
    {
        $kpis = $this->service->getKPISummary();
        $impact = $this->service->getEnvironmentalImpact();

        return [
            ['Period', $this->startDate->format('Y-m-d') . ' - ' . $this->endDate->format('Y-m-d')],
            [''],
            ['Nyckeltal', ''],
            ['Antal föremål', $kpis['items'] ?? 0],
            ['Antal sessioner', $kpis['sessions'] ?? 0],
            ['Uppskattat värde (kr)', $kpis['estimated_value'] ?? 0],
            ['Genomsnittligt skick', number_format($kpis['avg_condition'] ?? 0, 2)],
            [''],
            ['Miljöpåverkan', ''],
            ['CO2 besparat (kg)', $impact['co2_savings'] ?? 0],
            ['Vatten besparat (liter)', $impact['water_savings'] ?? 0],
            ['Energi besparat (kWh)', $impact['energy_savings'] ?? 0],
            [''],
            ['Ekvivalenter', ''],
            ['Träds årliga CO2-upptag', $impact['equivalents']['trees'] ?? 0],
            ['Bilkilometer undvikna', $impact['equivalents']['car_km'] ?? 0],
            ['Duschar sparade', $impact['equivalents']['showers'] ?? 0],
            ['Mobilladdningar', $impact['equivalents']['phone_charges'] ?? 0],
        ];
    }

    public function headings(): array
    {
        return ['Miljörapport - Sammanfattning', ''];
    }

    public function title(): string
    {
        return 'Sammanfattning';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true]],
            9 => ['font' => ['bold' => true]],
            14 => ['font' => ['bold' => true]],
        ];
    }
}

class CategoriesSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(protected ReportDataService $service) {}

    public function array(): array
    {
        $categories = $this->service->getCategoryBreakdown();

        return collect($categories)->map(fn ($cat) => [
            $cat['name'],
            $cat['count'],
            number_format($cat['percentage'], 1) . '%',
            number_format($cat['co2_savings'], 2),
            number_format($cat['value'], 0),
        ])->toArray();
    }

    public function headings(): array
    {
        return ['Kategori', 'Antal', 'Andel', 'CO2 (kg)', 'Värde (kr)'];
    }

    public function title(): string
    {
        return 'Per kategori';
    }
}

class TimeSeriesSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(protected ReportDataService $service) {}

    public function array(): array
    {
        $timeSeries = $this->service->getTimeSeries('day');

        $data = [];
        foreach ($timeSeries['labels'] ?? [] as $index => $label) {
            $data[] = [
                $label,
                $timeSeries['data'][$index] ?? 0,
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Datum', 'CO2 besparat (kg)'];
    }

    public function title(): string
    {
        return 'Daglig data';
    }
}
