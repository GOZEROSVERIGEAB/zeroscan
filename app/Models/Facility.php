<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'customer_id',
        'name',
        'description',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'contact_name',
        'contact_email',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Facility $facility) {
            if (empty($facility->uuid)) {
                $facility->uuid = (string) Str::uuid();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
