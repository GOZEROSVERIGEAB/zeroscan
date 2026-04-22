<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

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
    ];

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
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
    ];

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
