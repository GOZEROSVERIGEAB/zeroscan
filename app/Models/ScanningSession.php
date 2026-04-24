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

    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'session_uuid',
        'station_id',
        'visitor_name',
        'email',
        'gdpr_consent',
        'gdpr_consent_at',
        'inventory_uuids',
        'status',
        'report_sent',
        'completed_at',
        'ip_address',
        'user_agent',
        'ai_processing_started_at',
        'ai_processing_completed_at',
        'total_items',
        'total_co2_savings',
        'report_sent_at',
        'error_message',
    ];

    protected $casts = [
        'inventory_uuids' => 'array',
        'report_sent' => 'boolean',
        'gdpr_consent' => 'boolean',
        'gdpr_consent_at' => 'datetime',
        'completed_at' => 'datetime',
        'ai_processing_started_at' => 'datetime',
        'ai_processing_completed_at' => 'datetime',
        'report_sent_at' => 'datetime',
        'total_items' => 'integer',
        'total_co2_savings' => 'decimal:3',
    ];

    protected static function booted(): void
    {
        static::creating(function (ScanningSession $session) {
            if (empty($session->session_uuid)) {
                $session->session_uuid = (string) Str::uuid();
            }
            if (empty($session->status)) {
                $session->status = self::STATUS_PENDING;
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

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function markAsProcessing(): void
    {
        $this->update([
            'status' => self::STATUS_PROCESSING,
            'ai_processing_started_at' => now(),
        ]);
    }

    public function markAsCompleted(): void
    {
        $totalItems = $this->inventories()->count();
        $totalCo2 = $this->inventories()->sum('co2_savings');

        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
            'ai_processing_completed_at' => now(),
            'inventory_uuids' => $this->inventories()->pluck('uuid')->toArray(),
            'total_items' => $totalItems,
            'total_co2_savings' => $totalCo2,
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'ai_processing_completed_at' => now(),
        ]);
    }

    public function markReportSentAt(): void
    {
        $this->update([
            'report_sent' => true,
            'report_sent_at' => now(),
        ]);
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Väntar',
            self::STATUS_PROCESSING => 'Bearbetar',
            self::STATUS_COMPLETED => 'Klar',
            self::STATUS_FAILED => 'Misslyckades',
            default => 'Okänd',
        };
    }
}
