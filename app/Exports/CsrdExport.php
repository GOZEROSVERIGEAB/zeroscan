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

class CsrdExport implements WithMultipleSheets
{
    public function __construct(
        protected ReportDataService $service,
        protected Carbon $startDate,
        protected Carbon $endDate
    ) {}

    public function sheets(): array
    {
        return [
            new CsrdMetricsSheet($this->service, $this->startDate, $this->endDate),
            new CsrdCategoriesSheet($this->service),
            new CsrdMaterialsSheet($this->service),
            new CsrdFacilitiesSheet($this->service),
        ];
    }
}

class CsrdMetricsSheet implements FromArray, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
{
    public function __construct(
        protected ReportDataService $service,
        protected Carbon $startDate,
        protected Carbon $endDate
    ) {}

    public function array(): array
    {
        $metrics = $this->service->getCsrdMetrics();

        return [
            ['Rapportperiod', $this->startDate->format('Y-m-d').' - '.$this->endDate->format('Y-m-d')],
            ['Standard', 'ESRS E5 - Resource Use & Circular Economy'],
            [''],
            ['ESRS Kod', 'Metrik', 'Värde', 'Enhet'],
            ['E5-4', 'Materialinflöden', $metrics['material_inflows'] ?? 0, 'kg'],
            ['E5-2', 'Återbruksgrad', number_format($metrics['reuse_rate'] ?? 0, 1), '%'],
            ['E5-3', 'Genomsnittligt skick', number_format($metrics['avg_condition'] ?? 0, 2), '1-5'],
            ['E5-4', 'Avfall förhindrat', $metrics['waste_prevented'] ?? 0, 'kg'],
            ['E5-5', 'Cirkulärt värde', $metrics['circular_value'] ?? 0, 'SEK'],
            ['KPI', 'Antal föremål', $metrics['items_count'] ?? 0, 'st'],
        ];
    }

    public function headings(): array
    {
        return ['CSRD ESRS E5 Rapport', '', '', ''];
    }

    public function title(): string
    {
        return 'ESRS E5 Metrics';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true]],
        ];
    }
}

class CsrdCategoriesSheet implements FromArray, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(protected ReportDataService $service) {}

    public function array(): array
    {
        $categories = $this->service->getCategoryBreakdown();

        return collect($categories)->map(fn ($cat) => [
            $cat['name'],
            $cat['count'],
            number_format($cat['percentage'], 1),
            number_format($cat['weight'] ?? 0, 2),
            number_format($cat['co2_savings'], 2),
            number_format($cat['value'], 0),
        ])->toArray();
    }

    public function headings(): array
    {
        return ['Kategori', 'Antal', 'Andel (%)', 'Vikt (kg)', 'CO2 (kg)', 'Värde (kr)'];
    }

    public function title(): string
    {
        return 'Kategorier';
    }
}

class CsrdMaterialsSheet implements FromArray, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(protected ReportDataService $service) {}

    public function array(): array
    {
        $materials = $this->service->getMaterialBreakdown();

        return collect($materials)->map(fn ($mat) => [
            $mat['name'],
            number_format($mat['weight'], 2),
            number_format($mat['percentage'], 1),
        ])->toArray();
    }

    public function headings(): array
    {
        return ['Material', 'Vikt (kg)', 'Andel (%)'];
    }

    public function title(): string
    {
        return 'Materialflöde';
    }
}

class CsrdFacilitiesSheet implements FromArray, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(protected ReportDataService $service) {}

    public function array(): array
    {
        $facilities = $this->service->getFacilityComparison();

        return collect($facilities)->map(fn ($fac) => [
            $fac['name'],
            $fac['items'],
            number_format($fac['co2'], 2),
            number_format($fac['value'], 0),
        ])->toArray();
    }

    public function headings(): array
    {
        return ['Anläggning', 'Föremål', 'CO2 (kg)', 'Värde (kr)'];
    }

    public function title(): string
    {
        return 'Per anläggning';
    }
}
