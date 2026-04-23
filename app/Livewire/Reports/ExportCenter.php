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
#[Title('Exportcenter')]
class ExportCenter extends Component
{
    #[Url]
    public string $period = '30d';

    #[Url]
    public ?int $facilityId = null;

    public string $exportFormat = 'pdf';
    public string $exportType = 'executive';

    public array $exportTypes = [
        'executive' => [
            'label' => 'Sammanfattning',
            'description' => 'Översiktlig rapport med nyckeltal och trender',
            'formats' => ['pdf', 'excel'],
        ],
        'environmental' => [
            'label' => 'Miljörapport',
            'description' => 'Detaljerad miljöpåverkan och ekvivalenter',
            'formats' => ['pdf', 'excel'],
        ],
        'csrd' => [
            'label' => 'CSRD-rapport',
            'description' => 'ESRS E5 compliance-rapport',
            'formats' => ['pdf', 'excel'],
        ],
        'inventory' => [
            'label' => 'Inventarieexport',
            'description' => 'Full lista över registrerade föremål',
            'formats' => ['excel', 'csv'],
        ],
        'certificate' => [
            'label' => 'Påverkanscertifikat',
            'description' => 'Delbart certifikat för social media',
            'formats' => ['pdf'],
        ],
    ];

    public function setExportType(string $type): void
    {
        $this->exportType = $type;
        if (! in_array($this->exportFormat, $this->exportTypes[$type]['formats'])) {
            $this->exportFormat = $this->exportTypes[$type]['formats'][0];
        }
    }

    public function export(): void
    {
        $this->redirect(route('reports.export', [
            'type' => $this->exportType,
            'format' => $this->exportFormat,
            'period' => $this->period,
            'facility_id' => $this->facilityId,
        ]));
    }

    private function getDateRange(): array
    {
        return match ($this->period) {
            '7d' => [now()->subDays(7), now()],
            '30d' => [now()->subDays(30), now()],
            '90d' => [now()->subDays(90), now()],
            '365d' => [now()->subYear(), now()],
            'ytd' => [now()->startOfYear(), now()],
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
            null,
            $startDate,
            $endDate,
            $this->getCustomerId()
        );
    }

    #[Computed]
    public function facilities()
    {
        return $this->service->getAvailableFacilities($this->getCustomerId());
    }

    #[Computed]
    public function kpis(): array
    {
        $summary = $this->service->getKPISummary();

        return [
            'items' => $summary['total_items'] ?? 0,
        ];
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        return view('livewire.reports.export-center', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
