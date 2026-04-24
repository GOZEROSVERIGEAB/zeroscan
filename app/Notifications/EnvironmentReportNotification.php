<?php

namespace App\Notifications;

use App\Models\Inventory;
use App\Models\ScanningSession;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnvironmentReportNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ScanningSession $session
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $inventories = $this->session->inventories()
            ->where('status', Inventory::STATUS_COMPLETED)
            ->get();

        $totalCo2 = $inventories->sum('co2_savings') ?? 0;
        $totalWater = $inventories->sum('water_savings') ?? 0;
        $totalEnergy = $inventories->sum('energy_savings') ?? 0;
        $totalValue = $inventories->sum('estimated_value') ?? 0;
        $itemCount = $inventories->count();

        // Get AI sources from inventories
        $providers = $inventories->pluck('ai_provider')->filter()->unique()->values()->toArray();
        $models = $inventories->pluck('ai_model')->filter()->unique()->values()->toArray();
        $avgConfidence = $inventories->avg('ai_confidence') ?? 0;

        $station = $this->session->station;
        $stationName = $station?->name ?? 'ScanIT';
        $logoUrl = $station?->logo_path
            ? asset('storage/'.$station->logo_path)
            : null;

        return (new MailMessage)
            ->subject(__('scanit.email.report_subject', ['station' => $stationName]))
            ->view('emails.environment-report', [
                'session' => $this->session,
                'station' => $station,
                'stationName' => $stationName,
                'logoUrl' => $logoUrl,
                'inventories' => $inventories,
                'totalCo2' => $totalCo2,
                'totalWater' => $totalWater,
                'totalEnergy' => $totalEnergy,
                'totalValue' => $totalValue,
                'itemCount' => $itemCount,
                'treesEquivalent' => $this->calculateTreesEquivalent($totalCo2),
                'carKmEquivalent' => $this->calculateCarKmEquivalent($totalCo2),
                'showerEquivalent' => $this->calculateShowerEquivalent($totalWater),
                'phoneChargesEquivalent' => $this->calculatePhoneChargesEquivalent($totalEnergy),
                'aiSources' => [
                    'providers' => $providers,
                    'models' => $models,
                    'avg_confidence' => round($avgConfidence * 100, 1),
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
                ],
            ]);
    }

    /**
     * Calculate equivalent number of trees needed to absorb CO2.
     * Average tree absorbs about 21 kg CO2 per year.
     */
    protected function calculateTreesEquivalent(float $co2Kg): float
    {
        return round($co2Kg / 21, 1);
    }

    /**
     * Calculate equivalent car kilometers.
     * Average car emits about 0.12 kg CO2 per km.
     */
    protected function calculateCarKmEquivalent(float $co2Kg): float
    {
        return round($co2Kg / 0.12, 0);
    }

    /**
     * Calculate equivalent showers.
     * Average shower uses about 65 liters of water.
     */
    protected function calculateShowerEquivalent(float $waterLiters): float
    {
        return round($waterLiters / 65, 0);
    }

    /**
     * Calculate equivalent phone charges.
     * Charging a phone uses about 0.012 kWh.
     */
    protected function calculatePhoneChargesEquivalent(float $energyKwh): float
    {
        return round($energyKwh / 0.012, 0);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'session_id' => $this->session->id,
            'email' => $this->session->email,
        ];
    }
}
