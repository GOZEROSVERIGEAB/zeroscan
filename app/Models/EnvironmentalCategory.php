<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnvironmentalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_sv',
        'name_en',
        'parent_id',
        'description_sv',
        'description_en',
        'keywords',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EnvironmentalCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(EnvironmentalCategory::class, 'parent_id');
    }

    public function factors(): HasMany
    {
        return $this->hasMany(EnvironmentalFactor::class, 'category_id');
    }

    public function activeFactor(): HasOne
    {
        return $this->hasOne(EnvironmentalFactor::class, 'category_id')
            ->where('is_active', true)
            ->where('is_verified', true)
            ->latest('verified_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getFullPath(): string
    {
        $path = [$this->name_sv];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name_sv);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }
}
