<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Customer $customer
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
        $template = EmailTemplate::getByIdentifier('welcome_user');

        $data = [
            'name' => $notifiable->name,
            'email' => $notifiable->email,
            'customer_name' => $this->customer->name,
            'role' => $this->getRoleDisplayName($notifiable->role),
            'login_url' => route('login'),
        ];

        if ($template) {
            $htmlContent = $template->render($data);
            $subject = $template->renderSubject($data);

            return (new MailMessage)
                ->subject($subject)
                ->view('emails.welcome-user', [
                    'htmlContent' => $htmlContent,
                ]);
        }

        return (new MailMessage)
            ->subject('Välkommen till PreZero+ och Scanit!')
            ->greeting("Hej {$notifiable->name}!")
            ->line("Du har blivit tillagd som användare hos {$this->customer->name} i PreZero+ och Scanit-plattformen.")
            ->line("E-post: {$notifiable->email}")
            ->line("Roll: {$this->getRoleDisplayName($notifiable->role)}")
            ->action('Logga in', route('login'))
            ->line('Välkommen ombord!');
    }

    private function getRoleDisplayName(?string $role): string
    {
        return match ($role) {
            'admin' => 'Administratör',
            'editor' => 'Redaktör',
            'user' => 'Användare',
            default => 'Användare',
        };
    }
}
