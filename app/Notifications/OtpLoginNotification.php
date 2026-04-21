<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpLoginNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $otp
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
        return (new MailMessage)
            ->subject(__('scanit.email.otp_subject'))
            ->greeting(__('scanit.email.otp_greeting'))
            ->line(__('scanit.email.otp_body'))
            ->line("**{$this->otp}**")
            ->line(__('scanit.email.otp_expiry'))
            ->line(__('scanit.email.otp_ignore'));
    }
}
