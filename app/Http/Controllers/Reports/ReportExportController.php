<?php

namespace App\Http\Controllers\Reports;

use App\Exports\CsrdExport;
use App\Exports\EnvironmentalReportExport;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Services\Reports\ReportDataService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportExportController extends Controller
{
    public function export(Request $request, string $type, string $format)
    {
        $period = $request->get('period', '30d');
        $facilityId = $request->get('facility_id');
        $customerId = Auth::user()?->customer_id;

        [$startDate, $endDate] = $this->getDateRange($period);

        $service = new ReportDataService(
            $facilityId ? (int) $facilityId : null,
            null,
            $startDate,
            $endDate,
            $customerId
        );

        return match ($type) {
            'executive' => $this->exportExecutive($service, $format, $startDate, $endDate),
            'environmental' => $this->exportEnvironmental($service, $format, $startDate, $endDate),
            'csrd' => $this->exportCsrd($service, $format, $startDate, $endDate),
            'inventory' => $this->exportInventory($service, $format, $startDate, $endDate),
            'certificate' => $this->exportCertificate($service, $startDate, $endDate),
            default => abort(404, 'Unknown export type'),
        };
    }

    private function getDateRange(string $period): array
    {
        return match ($period) {
            '7d' => [now()->subDays(7), now()],
            '30d' => [now()->subDays(30), now()],
            '90d' => [now()->subDays(90), now()],
            '365d' => [now()->subYear(), now()],
            'ytd' => [now()->startOfYear(), now()],
            'q1' => [now()->startOfYear(), now()->startOfYear()->addMonths(3)->subDay()],
            'q2' => [now()->startOfYear()->addMonths(3), now()->startOfYear()->addMonths(6)->subDay()],
            'q3' => [now()->startOfYear()->addMonths(6), now()->startOfYear()->addMonths(9)->subDay()],
            'q4' => [now()->startOfYear()->addMonths(9), now()->endOfYear()],
            default => [now()->subDays(30), now()],
        };
    }

    private function exportExecutive(ReportDataService $service, string $format, Carbon $startDate, Carbon $endDate)
    {
        $categoryData = $service->getCategoryBreakdown();
        $total = $categoryData->sum('count');

        $categories = $categoryData->map(function ($cat) use ($total) {
            return [
                'name' => $cat->category,
                'count' => $cat->count,
                'co2_savings' => $cat->co2_total,
                'value' => $cat->value_total,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();

        $data = [
            'kpis' => $service->getKPISummary(),
            'impact' => $service->getEnvironmentalImpact(),
            'categories' => $categories,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.reports.executive-summary', $data);
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download("sammanfattning-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.pdf");
        }

        return Excel::download(
            new EnvironmentalReportExport($service, $startDate, $endDate),
            "sammanfattning-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.xlsx"
        );
    }

    private function exportEnvironmental(ReportDataService $service, string $format, Carbon $startDate, Carbon $endDate)
    {
        $categoryData = $service->getCategoryBreakdown();
        $total = $categoryData->sum('count');

        $categories = $categoryData->map(function ($cat) use ($total) {
            return [
                'name' => $cat->category,
                'count' => $cat->count,
                'co2_savings' => $cat->co2_total,
                'value' => $cat->value_total,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();

        $data = [
            'impact' => $service->getEnvironmentalImpact(),
            'categories' => $categories,
            'timeSeries' => $service->getTimeSeries('day'),
            'lifetime' => $service->getLifetimeImpact(),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.reports.environmental-report', $data);
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download("miljorapport-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.pdf");
        }

        return Excel::download(
            new EnvironmentalReportExport($service, $startDate, $endDate),
            "miljorapport-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.xlsx"
        );
    }

    private function exportCsrd(ReportDataService $service, string $format, Carbon $startDate, Carbon $endDate)
    {
        $categoryData = $service->getCategoryBreakdown();
        $total = $categoryData->sum('count');

        $categories = $categoryData->map(function ($cat) use ($total) {
            return [
                'name' => $cat->category,
                'count' => $cat->count,
                'weight' => 0,
                'co2_savings' => $cat->co2_total,
                'value' => $cat->value_total,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })->toArray();

        $materialData = $service->getMaterialBreakdown();
        $materialTotal = $materialData->sum('total_weight');

        $materials = $materialData->map(function ($mat) use ($materialTotal) {
            return [
                'name' => $mat['material'] ?? 'Okänt',
                'weight' => $mat['total_weight'] ?? 0,
                'percentage' => $materialTotal > 0 ? round(($mat['total_weight'] / $materialTotal) * 100, 1) : 0,
            ];
        })->take(10)->values()->toArray();

        $facilities = $service->getFacilityComparison()->map(function ($fac) {
            return [
                'name' => $fac->name,
                'items' => $fac->count,
                'co2' => $fac->co2,
                'value' => $fac->value,
            ];
        })->toArray();

        $csrdMetrics = $service->getCsrdMetrics();
        $metrics = [
            'material_inflows' => $csrdMetrics['material_inflows']['value'] ?? 0,
            'reuse_rate' => $csrdMetrics['reuse_rate']['value'] ?? 0,
            'avg_condition' => $csrdMetrics['product_quality']['value'] ?? 0,
            'waste_prevented' => $csrdMetrics['waste_prevented']['value'] ?? 0,
            'circular_value' => $csrdMetrics['circular_value']['value'] ?? 0,
            'items_count' => $csrdMetrics['items_processed']['value'] ?? 0,
        ];

        $comp = $service->getPeriodComparison();
        $changes = $comp['changes'] ?? [];
        $comparison = [
            'items_change' => $changes['total_items']['value'] ?? 0,
            'co2_change' => $changes['co2_saved']['value'] ?? 0,
            'value_change' => $changes['estimated_value']['value'] ?? 0,
            'weight_change' => 0,
        ];

        $data = [
            'metrics' => $metrics,
            'categories' => $categories,
            'materials' => $materials,
            'comparison' => $comparison,
            'facilities' => $facilities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('pdf.reports.csrd-report', $data);
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download("csrd-rapport-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.pdf");
        }

        return Excel::download(
            new CsrdExport($service, $startDate, $endDate),
            "csrd-rapport-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.xlsx"
        );
    }

    private function exportInventory(ReportDataService $service, string $format, Carbon $startDate, Carbon $endDate)
    {
        if ($format === 'csv') {
            return Excel::download(
                new InventoryExport($service, $startDate, $endDate),
                "inventarie-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.csv",
                \Maatwebsite\Excel\Excel::CSV
            );
        }

        return Excel::download(
            new InventoryExport($service, $startDate, $endDate),
            "inventarie-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.xlsx"
        );
    }

    private function exportCertificate(ReportDataService $service, Carbon $startDate, Carbon $endDate)
    {
        $data = [
            'impact' => $service->getEnvironmentalImpact(),
            'kpis' => $service->getKPISummary(),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('pdf.reports.impact-certificate', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("miljo-certifikat-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.pdf");
    }
}
