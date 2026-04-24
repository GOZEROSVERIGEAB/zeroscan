<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class CreateWizard extends Component
{
    public int $currentStep = 1;

    public int $totalSteps = 4;

    // Step 1: Basic Info
    public string $name = '';

    public string $org_number = '';

    public string $email = '';

    public string $phone = '';

    // Step 2: Address
    public string $address = '';

    public string $city = '';

    public string $postal_code = '';

    public string $country = 'Sverige';

    // Step 3: Subscription
    public string $subscription_status = 'trial';

    public ?string $trial_ends_at = null;

    public bool $is_enterprise = false;

    // Step 4: Limits
    public ?int $max_facilities = null;

    public ?int $max_stations = null;

    public ?int $max_scans_per_month = null;

    protected function rules(): array
    {
        return [
            // Step 1
            'name' => 'required|string|max:255',
            'org_number' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            // Step 2
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            // Step 3
            'subscription_status' => 'required|in:trial,active,suspended,cancelled',
            'trial_ends_at' => 'nullable|date',
            'is_enterprise' => 'boolean',
            // Step 4
            'max_facilities' => 'nullable|integer|min:1',
            'max_stations' => 'nullable|integer|min:1',
            'max_scans_per_month' => 'nullable|integer|min:1',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => __('admin.validation.name_required'),
            'email.required' => __('admin.validation.email_required'),
            'email.email' => __('admin.validation.email_invalid'),
        ];
    }

    public function mount(): void
    {
        $this->trial_ends_at = now()->addDays(30)->format('Y-m-d');
    }

    public function nextStep(): void
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    private function validateCurrentStep(): void
    {
        match ($this->currentStep) {
            1 => $this->validate([
                'name' => 'required|string|max:255',
                'org_number' => 'nullable|string|max:50',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:50',
            ]),
            2 => $this->validate([
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'country' => 'required|string|max:100',
            ]),
            3 => $this->validate([
                'subscription_status' => 'required|in:trial,active,suspended,cancelled',
                'trial_ends_at' => 'nullable|date',
                'is_enterprise' => 'boolean',
            ]),
            4 => $this->validate([
                'max_facilities' => 'nullable|integer|min:1',
                'max_stations' => 'nullable|integer|min:1',
                'max_scans_per_month' => 'nullable|integer|min:1',
            ]),
            default => null,
        };
    }

    public function save(): void
    {
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'org_number' => $this->org_number ?: null,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
            'city' => $this->city ?: null,
            'postal_code' => $this->postal_code ?: null,
            'country' => $this->country,
            'subscription_status' => $this->subscription_status,
            'trial_ends_at' => $this->subscription_status === 'trial' ? $this->trial_ends_at : null,
            'is_enterprise' => $this->is_enterprise,
            'is_active' => in_array($this->subscription_status, ['trial', 'active']),
            'max_facilities' => $this->max_facilities,
            'max_stations' => $this->max_stations,
            'max_scans_per_month' => $this->max_scans_per_month,
        ]);

        session()->flash('success', __('admin.customers.created_success'));

        $this->redirect(route('admin.customers.show', $customer), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.customers.create-wizard')
            ->layout('components.layouts.admin', ['title' => __('admin.customers.create_title')]);
    }
}
