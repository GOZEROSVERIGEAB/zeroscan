<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnvironmentalSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'organization',
        'report_title',
        'report_url',
        'publication_date',
        'methodology',
        'description',
        'is_official',
        'is_peer_reviewed',
        'is_active',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_official' => 'boolean',
        'is_peer_reviewed' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function factors(): HasMany
    {
        return $this->hasMany(EnvironmentalFactor::class, 'source_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfficial($query)
    {
        return $query->where('is_official', true);
    }

    public function getCitationAttribute(): string
    {
        $parts = [$this->organization];

        if ($this->publication_date) {
            $parts[] = '(' . $this->publication_date->format('Y') . ')';
        }

        if ($this->report_title) {
            $parts[] = '"' . $this->report_title . '"';
        }

        return implode(' ', $parts);
    }
}
