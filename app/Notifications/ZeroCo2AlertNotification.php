<?php

namespace App\Notifications;

use App\Models\ScanningSession;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ZeroCo2AlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ScanningSession $session,
        public int $zeroCo2Count
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
        $station = $this->session->station;
        $stationName = $station?->name ?? 'Okänd station';
        $facilityName = $station?->facility?->name ?? 'Okänd anläggning';
        $reviewUrl = url('/admin/environmental-review');

        return (new MailMessage)
            ->subject("⚠️ Skannade objekt saknar CO2-data - Session #{$this->session->id}")
            ->greeting('Hej!')
            ->line('En skanningssession har slutförts med objekt som saknar CO2-data och behöver granskning.')
            ->line('**Detaljer:**')
            ->line("- **Session ID:** {$this->session->id}")
            ->line("- **Station:** {$stationName}")
            ->line("- **Anläggning:** {$facilityName}")
            ->line("- **Kundens e-post:** {$this->session->email}")
            ->line("- **Antal objekt utan CO2:** {$this->zeroCo2Count}")
            ->line("- **Totalt antal objekt:** {$this->session->inventories()->count()}")
            ->line('')
            ->line('Miljörapporten har **blockerats** och kommer inte skickas till kunden förrän CO2-data har fyllts i.')
            ->action('Granska och åtgärda', $reviewUrl)
            ->line('Efter att du korrigerat CO2-värdena kan du manuellt skicka rapporten från granskningssidan.')
            ->salutation('Med vänlig hälsning, ScanIT');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'session_id' => $this->session->id,
            'zero_co2_count' => $this->zeroCo2Count,
            'customer_email' => $this->session->email,
        ];
    }
}
