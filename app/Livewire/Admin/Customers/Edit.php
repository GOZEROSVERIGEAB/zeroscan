<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use App\Models\Team;
use App\Models\User;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public Customer $customer;

    public string $activeTab = 'basic';

    // Basic Info
    public string $name = '';

    public ?string $org_number = '';

    public string $email = '';

    public ?string $phone = '';

    // Address
    public ?string $address = '';

    public ?string $city = '';

    public ?string $postal_code = '';

    public string $country = '';

    // Subscription
    public string $subscription_status = '';

    public ?string $trial_ends_at = null;

    public bool $is_enterprise = false;

    public bool $is_active = true;

    // Limits
    public ?int $max_facilities = null;

    public ?int $max_stations = null;

    public ?int $max_scans_per_month = null;

    // New User Form
    public string $newUserName = '';

    public string $newUserEmail = '';

    public string $newUserRole = 'user';

    public bool $sendWelcomeEmail = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'org_number' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'subscription_status' => 'required|in:trial,active,suspended,cancelled',
            'trial_ends_at' => 'nullable|date',
            'is_enterprise' => 'boolean',
            'is_active' => 'boolean',
            'max_facilities' => 'nullable|integer|min:1',
            'max_stations' => 'nullable|integer|min:1',
            'max_scans_per_month' => 'nullable|integer|min:1',
        ];
    }

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->fill([
            'name' => $customer->name,
            'org_number' => $customer->org_number,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'city' => $customer->city,
            'postal_code' => $customer->postal_code,
            'country' => $customer->country ?? 'Sverige',
            'subscription_status' => $customer->subscription_status ?? 'trial',
            'trial_ends_at' => $customer->trial_ends_at?->format('Y-m-d'),
            'is_enterprise' => $customer->is_enterprise,
            'is_active' => $customer->is_active,
            'max_facilities' => $customer->max_facilities,
            'max_stations' => $customer->max_stations,
            'max_scans_per_month' => $customer->max_scans_per_month,
        ]);
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function save(): void
    {
        $this->validate();

        $this->customer->update([
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
            'is_active' => $this->is_active,
            'max_facilities' => $this->max_facilities,
            'max_stations' => $this->max_stations,
            'max_scans_per_month' => $this->max_scans_per_month,
        ]);

        session()->flash('success', __('admin.customers.updated_success'));
    }

    public function extendTrial(int $days = 14): void
    {
        $currentEnd = $this->customer->trial_ends_at ?? now();
        $newEnd = $currentEnd->addDays($days);

        $this->customer->update([
            'trial_ends_at' => $newEnd,
            'subscription_status' => 'trial',
        ]);

        $this->trial_ends_at = $newEnd->format('Y-m-d');
        $this->subscription_status = 'trial';

        session()->flash('success', __('admin.customers.trial_extended', ['days' => $days]));
    }

    public function activate(): void
    {
        $this->customer->update([
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        $this->subscription_status = 'active';
        $this->is_active = true;

        session()->flash('success', __('admin.customers.activated_success'));
    }

    public function suspend(): void
    {
        $this->customer->update([
            'subscription_status' => 'suspended',
            'is_active' => false,
        ]);

        $this->subscription_status = 'suspended';
        $this->is_active = false;

        session()->flash('success', __('admin.customers.suspended_success'));
    }

    public function addUser(): void
    {
        $this->validate([
            'newUserName' => 'required|string|max:255',
            'newUserEmail' => 'required|email|unique:users,email',
            'newUserRole' => 'required|in:admin,editor,user',
        ], [
            'newUserEmail.unique' => __('admin.users.email_exists'),
        ]);

        $user = User::create([
            'name' => $this->newUserName,
            'email' => $this->newUserEmail,
            'customer_id' => $this->customer->id,
            'role' => $this->newUserRole,
            'password' => bcrypt(Str::random(32)),
            'otp_enabled' => true,
        ]);

        $team = $this->getOrCreateCustomerTeam();
        $team->users()->attach($user, ['role' => $this->newUserRole]);
        $user->update(['current_team_id' => $team->id]);

        if ($this->sendWelcomeEmail) {
            $user->notify(new WelcomeUserNotification($this->customer));
        }

        $this->reset(['newUserName', 'newUserEmail', 'newUserRole']);
        $this->sendWelcomeEmail = true;

        session()->flash('success', __('admin.users.created_success'));
    }

    public function sendTestEmail(): void
    {
        auth()->user()->notify(new WelcomeUserNotification($this->customer));

        session()->flash('success', __('admin.users.test_email_sent'));
    }

    public function removeUser(int $userId): void
    {
        $user = User::find($userId);

        if (! $user || $user->customer_id !== $this->customer->id) {
            return;
        }

        if ($user->isSuperAdmin()) {
            session()->flash('error', __('admin.users.cannot_remove_super_admin'));

            return;
        }

        $user->teams()->detach();

        $user->delete();

        session()->flash('success', __('admin.users.removed_success'));
    }

    public function resendWelcomeEmail(int $userId): void
    {
        $user = User::find($userId);

        if (! $user || $user->customer_id !== $this->customer->id) {
            return;
        }

        $user->notify(new WelcomeUserNotification($this->customer));

        session()->flash('success', __('admin.users.welcome_email_resent'));
    }

    private function getOrCreateCustomerTeam(): Team
    {
        $team = Team::where('name', $this->customer->name)
            ->whereHas('users', function ($query) {
                $query->where('customer_id', $this->customer->id);
            })
            ->first();

        if (! $team) {
            $firstUser = $this->customer->users()->first();

            if ($firstUser) {
                $team = $firstUser->ownedTeams()->first();
            }

            if (! $team) {
                $owner = $this->customer->users()->first() ?? auth()->user();

                $team = Team::create([
                    'name' => $this->customer->name,
                    'user_id' => $owner->id,
                    'personal_team' => false,
                ]);
            }
        }

        return $team;
    }

    public function render()
    {
        $this->customer->loadCount(['facilities', 'users']);
        $this->customer->load([
            'facilities' => function ($query) {
                $query->withCount('stations');
            },
            'users',
        ]);

        $stationsCount = $this->customer->facilities->sum('stations_count');

        $usageStats = $this->customer->monthlyUsage()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        return view('livewire.admin.customers.edit', [
            'stationsCount' => $stationsCount,
            'usageStats' => $usageStats,
        ])->layout('components.layouts.admin', ['title' => __('admin.customers.edit_title')]);
    }
}
