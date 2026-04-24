<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_TRIAL = 'trial';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_SUSPENDED = 'suspended';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'uuid',
        'name',
        'org_number',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'logo_path',
        'service_name',
        'settings',
        'is_active',
        'is_enterprise',
        'max_facilities',
        'max_stations',
        'max_scans_per_month',
        'trial_ends_at',
        'subscription_status',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo_path) {
            return asset('storage/'.$this->logo_path);
        }

        return null;
    }

    public function hasCustomBranding(): bool
    {
        return $this->logo_path || $this->service_name;
    }

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_enterprise' => 'boolean',
        'max_facilities' => 'integer',
        'max_stations' => 'integer',
        'max_scans_per_month' => 'integer',
        'trial_ends_at' => 'date',
    ];

    public function isOnTrial(): bool
    {
        return $this->subscription_status === self::STATUS_TRIAL;
    }

    public function isTrialExpired(): bool
    {
        if (! $this->isOnTrial()) {
            return false;
        }

        if (! $this->trial_ends_at) {
            return false;
        }

        return $this->trial_ends_at->isPast();
    }

    public function isActive(): bool
    {
        if ($this->subscription_status === self::STATUS_ACTIVE) {
            return true;
        }

        if ($this->isOnTrial() && ! $this->isTrialExpired()) {
            return true;
        }

        return false;
    }

    public function isSuspended(): bool
    {
        return $this->subscription_status === self::STATUS_SUSPENDED;
    }

    public function isCancelled(): bool
    {
        return $this->subscription_status === self::STATUS_CANCELLED;
    }

    public function getDaysUntilTrialEnds(): ?int
    {
        if (! $this->trial_ends_at) {
            return null;
        }

        $days = Carbon::now()->diffInDays($this->trial_ends_at, false);

        return $days > 0 ? $days : 0;
    }

    public function canCreateFacility(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        if ($this->max_facilities === null) {
            return true;
        }

        return $this->facilities()->count() < $this->max_facilities;
    }

    public function canCreateStation(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        if ($this->max_stations === null) {
            return true;
        }

        $totalStations = $this->facilities()
            ->withCount('stations')
            ->get()
            ->sum('stations_count');

        return $totalStations < $this->max_stations;
    }

    public function canScan(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        if ($this->max_scans_per_month === null) {
            return true;
        }

        return $this->getCurrentMonthScans() < $this->max_scans_per_month;
    }

    public function getCurrentMonthScans(): int
    {
        $usage = $this->currentMonthUsage;

        return $usage?->scan_count ?? 0;
    }

    public function getRemainingScans(): ?int
    {
        if ($this->max_scans_per_month === null) {
            return null;
        }

        return max(0, $this->max_scans_per_month - $this->getCurrentMonthScans());
    }

    public function currentMonthUsage(): HasOne
    {
        $year = (int) now()->format('Y');
        $month = (int) now()->format('n');

        return $this->hasOne(CustomerMonthlyUsage::class)
            ->where('year', $year)
            ->where('month', $month);
    }

    public function monthlyUsage(): HasMany
    {
        return $this->hasMany(CustomerMonthlyUsage::class)
            ->orderByDesc('year')
            ->orderByDesc('month');
    }

    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            if (empty($customer->uuid)) {
                $customer->uuid = (string) Str::uuid();
            }
        });
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(Facility::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
