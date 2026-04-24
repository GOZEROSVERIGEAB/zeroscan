<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnvironmentalFactor extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'source_id',
        'co2_new_kg',
        'co2_used_kg',
        'co2_savings_percent',
        'water_new_liters',
        'water_savings_percent',
        'energy_new_kwh',
        'energy_savings_percent',
        'waste_new_kg',
        'source_name',
        'source_report',
        'source_url',
        'source_publication_date',
        'source_methodology',
        'verified_by',
        'verified_at',
        'verification_notes',
        'valid_from',
        'valid_until',
        'is_active',
        'is_verified',
    ];

    protected $casts = [
        'co2_new_kg' => 'decimal:3',
        'co2_used_kg' => 'decimal:3',
        'co2_savings_percent' => 'decimal:2',
        'water_new_liters' => 'decimal:2',
        'water_savings_percent' => 'decimal:2',
        'energy_new_kwh' => 'decimal:2',
        'energy_savings_percent' => 'decimal:2',
        'waste_new_kg' => 'decimal:3',
        'source_publication_date' => 'date',
        'verified_at' => 'datetime',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalCategory::class, 'category_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalSource::class, 'source_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('valid_until')
                ->orWhere('valid_until', '>=', now());
        });
    }

    /**
     * Calculate CO2 savings in kg for a secondhand purchase.
     */
    public function calculateCo2Savings(): float
    {
        if ($this->co2_savings_percent !== null) {
            return round($this->co2_new_kg * ($this->co2_savings_percent / 100), 3);
        }

        if ($this->co2_used_kg !== null) {
            return round($this->co2_new_kg - $this->co2_used_kg, 3);
        }

        // Default: assume 90% savings (conservative estimate based on IVL data)
        return round($this->co2_new_kg * 0.90, 3);
    }

    /**
     * Calculate water savings in liters.
     */
    public function calculateWaterSavings(): ?float
    {
        if ($this->water_new_liters === null) {
            return null;
        }

        $percent = $this->water_savings_percent ?? 90;

        return round($this->water_new_liters * ($percent / 100), 2);
    }

    /**
     * Get formatted source citation.
     */
    public function getSourceCitationAttribute(): string
    {
        if ($this->source) {
            return $this->source->citation;
        }

        $parts = [$this->source_name];

        if ($this->source_publication_date) {
            $parts[] = '('.$this->source_publication_date->format('Y').')';
        }

        if ($this->source_report) {
            $parts[] = '"'.$this->source_report.'"';
        }

        return implode(' ', $parts);
    }

    /**
     * Check if this factor is currently valid.
     */
    public function isCurrentlyValid(): bool
    {
        if (! $this->is_active || ! $this->is_verified) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->isPast()) {
            return false;
        }

        return true;
    }
}
