<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Station extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'public_uuid',
        'facility_id',
        'name',
        'description',
        'location_description',
        'logo_path',
        'info_page_text',
        'gdpr_url',
        'thank_you_text',
        'is_active',
        'require_email',
        'max_images',
        'primary_color',
        'total_scans',
        'total_items',
        'total_co2_savings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'require_email' => 'boolean',
        'max_images' => 'integer',
        'total_scans' => 'integer',
        'total_items' => 'integer',
        'total_co2_savings' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Station $station) {
            if (empty($station->uuid)) {
                $station->uuid = (string) Str::uuid();
            }

            if (empty($station->public_uuid)) {
                $station->public_uuid = (string) Str::uuid();
            }
        });
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function scanningSessions(): HasMany
    {
        return $this->hasMany(ScanningSession::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function customer(): BelongsTo
    {
        return $this->facility->customer();
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getPublicUrl(): string
    {
        return route('scan.start', ['station' => $this->public_uuid]);
    }

    public function incrementStats(int $items = 0, float $co2Savings = 0): void
    {
        $this->increment('total_scans');
        $this->increment('total_items', $items);
        $this->increment('total_co2_savings', $co2Savings);
    }
}
