<?php

namespace App\Mail;

use App\Models\ScanningSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnvironmentalReportMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public ScanningSession $session;
    public array $branding;
    public float $totalCo2;
    public float $totalWater;
    public float $totalEnergy;
    public float $totalValue;
    public int $itemCount;
    public float $treesEquivalent;
    public float $carKmEquivalent;
    public float $showerEquivalent;
    public float $phoneChargesEquivalent;
    public string $visitorName;
    public string $stationName;
    public ?string $logoUrl;
    public array $aiSources;

    public function __construct(ScanningSession $session)
    {
        $this->session = $session->load(['inventories', 'station.facility']);

        $this->calculateTotals();
        $this->setupBranding();
        $this->calculateEnvironmentalComparisons();
        $this->collectAiSources();
    }

    protected function calculateTotals(): void
    {
        $inventories = $this->session->inventories;

        $this->totalCo2 = $inventories->sum('co2_savings') ?? 0;
        $this->totalWater = $inventories->sum('water_savings') ?? $this->estimateWaterSavings();
        $this->totalEnergy = $inventories->sum('energy_savings') ?? $this->estimateEnergySavings();
        $this->totalValue = $inventories->sum('estimated_value') ?? 0;
        $this->itemCount = $inventories->count();
    }

    protected function estimateWaterSavings(): float
    {
        // Estimate water savings based on CO2 savings
        // Average: 1 kg CO2 saved ~ 50 liters water saved in production
        return $this->totalCo2 * 50;
    }

    protected function estimateEnergySavings(): float
    {
        // Estimate energy savings based on CO2 savings
        // Average: 1 kg CO2 ~ 2.5 kWh energy
        return $this->totalCo2 * 2.5;
    }

    protected function setupBranding(): void
    {
        $station = $this->session->station;

        if ($station) {
            $this->branding = $station->getEffectiveBranding();
            $this->stationName = $this->branding['service_name']
                ?? $station->name
                ?? 'PreZero Scanit';
            $this->logoUrl = $this->branding['logo_url'];
        } else {
            $this->branding = [
                'logo_url' => null,
                'service_name' => 'PreZero Scanit',
                'has_custom' => false,
            ];
            $this->stationName = 'PreZero Scanit';
            $this->logoUrl = null;
        }

        // Get visitor name from session email if available
        $this->visitorName = $this->extractNameFromEmail($this->session->email);
    }

    protected function extractNameFromEmail(?string $email): string
    {
        if (!$email) {
            return '';
        }

        $localPart = explode('@', $email)[0];
        // Try to make a readable name from email local part
        $name = str_replace(['.', '_', '-'], ' ', $localPart);
        $name = ucwords($name);

        return $name;
    }

    protected function calculateEnvironmentalComparisons(): void
    {
        // A mature tree absorbs about 22 kg of CO2 per year
        $this->treesEquivalent = $this->totalCo2 / 22;

        // Average car emits about 120g CO2 per km
        $this->carKmEquivalent = ($this->totalCo2 * 1000) / 120;

        // Average shower uses about 65 liters of water
        $this->showerEquivalent = $this->totalWater / 65;

        // Charging a phone uses about 0.012 kWh
        $this->phoneChargesEquivalent = $this->totalEnergy / 0.012;
    }

    protected function collectAiSources(): void
    {
        $inventories = $this->session->inventories;

        // Get unique AI providers and models used
        $providers = $inventories->pluck('ai_provider')->filter()->unique()->values()->toArray();
        $models = $inventories->pluck('ai_model')->filter()->unique()->values()->toArray();

        // Calculate average confidence
        $avgConfidence = $inventories->avg('ai_confidence') ?? 0;

        $this->aiSources = [
            'providers' => $providers,
            'models' => $models,
            'avg_confidence' => round($avgConfidence * 100, 1),
            'analyzed_at' => now()->format('Y-m-d H:i'),
            'data_sources' => [
                'CO2-beräkningar baseras på livscykelanalyser (LCA) från EPA, DEFRA och vetenskapliga publikationer',
                'Vattenförbrukning baseras på Water Footprint Network data',
                'Energiförbrukning baseras på IEA och branschstandarder',
            ],
            'equivalents_sources' => [
                'trees' => 'EPA: 1 träd absorberar ~21 kg CO2/år',
                'car_km' => 'Naturvårdsverket: genomsnittlig bil ~120g CO2/km',
                'showers' => 'Svenskt Vatten: genomsnittlig dusch ~65 liter',
                'phone_charges' => 'IEA: mobilladdning ~0.012 kWh',
            ],
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('scanit.email.report_subject', ['station' => $this->stationName]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.environmental-report',
            with: [
                'session' => $this->session,
                'inventories' => $this->session->inventories,
                'branding' => $this->branding,
                'stationName' => $this->stationName,
                'logoUrl' => $this->logoUrl,
                'visitorName' => $this->visitorName,
                'totalCo2' => $this->totalCo2,
                'totalWater' => $this->totalWater,
                'totalEnergy' => $this->totalEnergy,
                'totalValue' => $this->totalValue,
                'itemCount' => $this->itemCount,
                'treesEquivalent' => $this->treesEquivalent,
                'carKmEquivalent' => $this->carKmEquivalent,
                'showerEquivalent' => $this->showerEquivalent,
                'phoneChargesEquivalent' => $this->phoneChargesEquivalent,
                'aiSources' => $this->aiSources,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
