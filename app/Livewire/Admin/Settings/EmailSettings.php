<?php

namespace App\Livewire\Admin\Settings;

use App\Models\EmailTemplate;
use Database\Seeders\EmailTemplateSeeder;
use Illuminate\View\View;
use Livewire\Component;

class EmailSettings extends Component
{
    public ?EmailTemplate $template = null;

    public string $subject = '';

    public string $body = '';

    public string $activeTab = 'email';

    public function mount(): void
    {
        $this->template = EmailTemplate::getByIdentifier('welcome_user');

        if ($this->template) {
            $this->subject = $this->template->subject;
            $this->body = $this->template->body;
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function save(): void
    {
        $this->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($this->template) {
            $this->template->update([
                'subject' => $this->subject,
                'body' => $this->body,
            ]);
        } else {
            $this->template = EmailTemplate::create([
                'identifier' => 'welcome_user',
                'name' => 'Välkomstmail till nya användare',
                'subject' => $this->subject,
                'body' => $this->body,
                'variables' => ['name', 'email', 'customer_name', 'role', 'login_url'],
            ]);
        }

        session()->flash('success', __('admin.settings.email_saved'));
    }

    public function resetToDefault(): void
    {
        $seeder = new EmailTemplateSeeder;
        $seeder->run();

        $this->template = EmailTemplate::getByIdentifier('welcome_user');

        if ($this->template) {
            $this->subject = $this->template->subject;
            $this->body = $this->template->body;
        }

        session()->flash('success', __('admin.settings.email_reset'));
    }

    public function render(): View
    {
        return view('livewire.admin.settings.email-settings')
            ->layout('components.layouts.admin', ['title' => __('admin.nav.settings')]);
    }
}
