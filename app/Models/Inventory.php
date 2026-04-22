<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_QUEUED = 999;
    public const STATUS_PROCESSING = 998;
    public const STATUS_COMPLETED = 900;
    public const STATUS_ERROR = 800;

    protected $fillable = [
        'uuid',
        'station_id',
        'scanning_session_id',
        'image_path',
        'name',
        'description',
        'category',
        'subcategory',
        'brand',
        'model',
        'materials',
        'colors',
        'weight',
        'height',
        'width',
        'depth',
        'estimated_value',
        'currency',
        'condition_rating',
        'condition_description',
        'co2_savings',
        'water_savings',
        'energy_savings',
        'co2_source',
        'co2_calculation_notes',
        'ai_confidence',
        'ai_response',
        'status',
        'ai_provider',
        'ai_model',
        'ai_tokens_used',
        'processed_at',
    ];

    protected $casts = [
        'weight' => 'decimal:3',
        'height' => 'decimal:2',
        'width' => 'decimal:2',
        'depth' => 'decimal:2',
        'estimated_value' => 'decimal:2',
        'condition_rating' => 'integer',
        'co2_savings' => 'decimal:3',
        'water_savings' => 'decimal:3',
        'energy_savings' => 'decimal:3',
        'ai_confidence' => 'decimal:2',
        'ai_response' => 'array',
        'status' => 'integer',
        'ai_tokens_used' => 'integer',
        'processed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Inventory $inventory) {
            if (empty($inventory->uuid)) {
                $inventory->uuid = (string) Str::uuid();
            }
        });
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function scanningSession(): BelongsTo
    {
        return $this->belongsTo(ScanningSession::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function isQueued(): bool
    {
        return $this->status === self::STATUS_QUEUED;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function hasError(): bool
    {
        return $this->status === self::STATUS_ERROR;
    }

    public function markAsProcessing(): void
    {
        $this->update(['status' => self::STATUS_PROCESSING]);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }

    public function markAsError(): void
    {
        $this->update(['status' => self::STATUS_ERROR]);
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_QUEUED => 'I kö',
            self::STATUS_PROCESSING => 'Bearbetar',
            self::STATUS_COMPLETED => 'Klar',
            self::STATUS_ERROR => 'Fel',
            default => 'Okänd',
        };
    }

    public function getDimensions(): ?string
    {
        if ($this->height && $this->width && $this->depth) {
            return "{$this->height} x {$this->width} x {$this->depth} cm";
        }

        return null;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return asset('storage/' . $this->image_path);
    }
}
