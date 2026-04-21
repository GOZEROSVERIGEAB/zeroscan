<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ScanningSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_uuid',
        'station_id',
        'email',
        'inventory_uuids',
        'report_sent',
        'completed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'inventory_uuids' => 'array',
        'report_sent' => 'boolean',
        'completed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (ScanningSession $session) {
            if (empty($session->session_uuid)) {
                $session->session_uuid = (string) Str::uuid();
            }
        });
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function getRouteKeyName(): string
    {
        return 'session_uuid';
    }

    public function markCompleted(): void
    {
        $this->update([
            'completed_at' => now(),
            'inventory_uuids' => $this->inventories()->pluck('uuid')->toArray(),
        ]);
    }

    public function markReportSent(): void
    {
        $this->update(['report_sent' => true]);
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    public function getTotalCo2Savings(): float
    {
        return $this->inventories()->sum('co2_savings') ?? 0;
    }

    public function getCompletedInventoriesCount(): int
    {
        return $this->inventories()->where('status', 900)->count();
    }
}
