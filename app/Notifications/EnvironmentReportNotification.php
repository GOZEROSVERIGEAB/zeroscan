<?php

namespace App\Notifications;

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
            ->where('status', \App\Models\Inventory::STATUS_COMPLETED)
            ->get();

        $totalCo2 = $inventories->sum('co2_savings') ?? 0;
        $totalValue = $inventories->sum('estimated_value') ?? 0;
        $itemCount = $inventories->count();

        $station = $this->session->station;
        $stationName = $station?->name ?? 'ScanIT';
        $logoUrl = $station?->logo_path
            ? asset('storage/' . $station->logo_path)
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
                'totalValue' => $totalValue,
                'itemCount' => $itemCount,
                'treesEquivalent' => $this->calculateTreesEquivalent($totalCo2),
                'carKmEquivalent' => $this->calculateCarKmEquivalent($totalCo2),
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
