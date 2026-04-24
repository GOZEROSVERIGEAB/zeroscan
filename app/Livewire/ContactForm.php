<?php

namespace App\Livewire;

use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $company = '';

    public string $phone = '';

    public string $message = '';

    public string $cfTurnstileResponse = '';

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'cfTurnstileResponse' => ['required', new TurnstileCheck],
        ];
    }

    protected array $messages = [
        'name.required' => 'Vänligen ange ditt namn.',
        'name.min' => 'Namnet måste vara minst 2 tecken.',
        'email.required' => 'Vänligen ange din e-postadress.',
        'email.email' => 'Vänligen ange en giltig e-postadress.',
        'company.required' => 'Vänligen ange ditt företag/organisation.',
        'message.required' => 'Vänligen skriv ett meddelande.',
        'message.min' => 'Meddelandet måste vara minst 10 tecken.',
        'cfTurnstileResponse.required' => 'Vänligen verifiera att du inte är en robot.',
    ];

    public function submit(): void
    {
        $this->validate();

        Mail::raw(
            "Nytt kontaktformulär från Scanit\n\n".
            "Namn: {$this->name}\n".
            "E-post: {$this->email}\n".
            "Företag: {$this->company}\n".
            "Telefon: {$this->phone}\n\n".
            "Meddelande:\n{$this->message}",
            function ($mail) {
                $mail->to('emilia.mastad@prezero.com')
                    ->subject('Kontaktförfrågan från Scanit - '.$this->company)
                    ->replyTo($this->email, $this->name);
            }
        );

        $this->submitted = true;
        $this->reset(['name', 'email', 'company', 'phone', 'message', 'cfTurnstileResponse']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
