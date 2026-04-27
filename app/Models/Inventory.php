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
        'environmental_category_id',
        'environmental_factor_id',
        'environmental_data_verified',
        'environmental_data_source',
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
        'environmental_data_verified' => 'boolean',
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

    public function environmentalCategory(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalCategory::class);
    }

    public function environmentalFactor(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalFactor::class);
    }

    /**
     * Check if this inventory has verified environmental data.
     */
    public function hasVerifiedEnvironmentalData(): bool
    {
        return $this->environmental_data_verified && $this->environmental_data_source === 'verified_database';
    }

    /**
     * Get the environmental data source badge/label.
     */
    public function getEnvironmentalSourceLabel(): string
    {
        return match ($this->environmental_data_source) {
            'verified_database' => 'Verifierad källa',
            'no_data' => 'Data saknas',
            'manual' => 'Manuellt angiven',
            'legacy_ai' => 'AI-estimerad (ej verifierad)',
            default => 'Okänd',
        };
    }

    /**
     * Check if this inventory needs manual environmental data review.
     */
    public function requiresEnvironmentalReview(): bool
    {
        return $this->status === self::STATUS_COMPLETED
            && ($this->co2_savings === null || $this->co2_savings == 0)
            && $this->environmental_data_source !== 'manual';
    }

    /**
     * Scope for inventories that need manual environmental data review.
     */
    public function scopeNeedsEnvironmentalReview($query)
    {
        return $query->where('status', self::STATUS_COMPLETED)
            ->where(function ($q) {
                $q->whereNull('co2_savings')
                    ->orWhere('co2_savings', 0);
            })
            ->where(function ($q) {
                $q->whereNull('environmental_data_source')
                    ->orWhere('environmental_data_source', '!=', 'manual');
            });
    }

    /**
     * Manually set environmental data.
     */
    public function setManualEnvironmentalData(float $co2Kg, ?float $waterLiters = null, ?float $energyKwh = null, ?string $notes = null): void
    {
        $this->update([
            'co2_savings' => $co2Kg,
            'water_savings' => $waterLiters,
            'energy_savings' => $energyKwh,
            'environmental_data_source' => 'manual',
            'environmental_data_verified' => false,
            'co2_source' => 'Manuellt angiven',
            'co2_calculation_notes' => $notes ?? 'Manuellt inmatad av administratör.',
        ]);
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
        if (! $this->image_path) {
            return null;
        }

        return asset('storage/'.$this->image_path);
    }
}
