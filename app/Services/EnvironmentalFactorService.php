<?php

namespace App\Services;

use App\Models\EnvironmentalCategory;
use App\Models\EnvironmentalFactor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EnvironmentalFactorService
{
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Find the best matching category for an AI-identified item.
     */
    public function matchCategory(string $category, ?string $subcategory = null, ?string $name = null): ?EnvironmentalCategory
    {
        // Normalize inputs
        $category = Str::lower(trim($category));
        $subcategory = $subcategory ? Str::lower(trim($subcategory)) : null;
        $name = $name ? Str::lower(trim($name)) : null;

        // Try exact subcategory match first
        if ($subcategory) {
            $match = $this->findByKeywords($subcategory);
            if ($match) {
                return $match;
            }
        }

        // Try name-based matching
        if ($name) {
            $match = $this->findByKeywords($name);
            if ($match) {
                return $match;
            }
        }

        // Fall back to main category
        return $this->findByKeywords($category);
    }

    /**
     * Find category by searching keywords.
     * Prioritizes categories that have an associated factor.
     */
    private function findByKeywords(string $searchTerm): ?EnvironmentalCategory
    {
        $categories = $this->getAllCategories();
        $categoriesWithFactors = $this->getCategoriesWithFactors();

        // First: exact slug match in categories with factors
        $exactMatch = $categoriesWithFactors->first(function ($cat) use ($searchTerm) {
            return Str::contains($cat->slug, Str::slug($searchTerm));
        });

        if ($exactMatch) {
            return $exactMatch;
        }

        // Second: keyword match - prioritize categories WITH factors
        $words = preg_split('/[\s,\/\-]+/', $searchTerm);
        $words = array_filter($words, fn ($w) => strlen($w) >= 2);

        $bestMatch = null;
        $bestScore = 0;

        // First pass: only categories with factors
        foreach ($categoriesWithFactors as $category) {
            $score = $this->calculateMatchScore($category, $words);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $category;
            }
        }

        // If we found a good match in categories with factors, return it
        if ($bestMatch && $bestScore >= 1) {
            return $bestMatch;
        }

        // Second pass: all categories (for fallback)
        foreach ($categories as $category) {
            $score = $this->calculateMatchScore($category, $words);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $category;
            }
        }

        return $bestMatch;
    }

    /**
     * Calculate match score for a category against search words.
     */
    private function calculateMatchScore(EnvironmentalCategory $category, array $words): int
    {
        $keywords = $category->keywords ?? [];
        $score = 0;

        foreach ($words as $word) {
            $word = Str::lower($word);

            foreach ($keywords as $keyword) {
                $keyword = Str::lower($keyword);

                // Exact match gets highest score
                if ($keyword === $word) {
                    $score += 10;
                }
                // Keyword contains word
                elseif (Str::contains($keyword, $word)) {
                    $score += 3;
                }
                // Word contains keyword
                elseif (Str::contains($word, $keyword)) {
                    $score += 2;
                }
            }

            // Also check category name
            $nameSv = Str::lower($category->name_sv);
            if (Str::contains($nameSv, $word)) {
                $score += 5;
            }
        }

        return $score;
    }

    /**
     * Get categories that have an associated factor.
     */
    private function getCategoriesWithFactors(): Collection
    {
        return Cache::remember('environmental_categories_with_factors', self::CACHE_TTL, function () {
            $factorCategoryIds = EnvironmentalFactor::where('is_active', true)
                ->where('is_verified', true)
                ->pluck('category_id');

            return EnvironmentalCategory::whereIn('id', $factorCategoryIds)
                ->where('is_active', true)
                ->get();
        });
    }

    /**
     * LEGACY - kept for compatibility but now uses calculateMatchScore
     */
    private function findByKeywordsLegacy(string $searchTerm): ?EnvironmentalCategory
    {
        $categories = $this->getAllCategories();
        $words = preg_split('/[\s,\/]+/', $searchTerm);

        $bestMatch = null;
        $bestScore = 0;

        foreach ($categories as $category) {
            $keywords = $category->keywords ?? [];
            $score = 0;

            foreach ($words as $word) {
                if (strlen($word) < 2) {
                    continue;
                }

                foreach ($keywords as $keyword) {
                    if (Str::contains(Str::lower($keyword), $word) || Str::contains($word, Str::lower($keyword))) {
                        $score++;
                    }
                }

                // Also check name
                if (Str::contains(Str::lower($category->name_sv), $word)) {
                    $score += 2;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $category;
            }
        }

        return $bestMatch;
    }

    /**
     * Get all active categories (cached).
     */
    private function getAllCategories(): Collection
    {
        return Cache::remember('environmental_categories_all', self::CACHE_TTL, function () {
            return EnvironmentalCategory::where('is_active', true)->get();
        });
    }

    /**
     * Get the verified factor for a category.
     */
    public function getFactorForCategory(EnvironmentalCategory $category): ?EnvironmentalFactor
    {
        return Cache::remember("env_factor_{$category->id}", self::CACHE_TTL, function () use ($category) {
            // Try this category first
            $factor = EnvironmentalFactor::where('category_id', $category->id)
                ->where('is_active', true)
                ->where('is_verified', true)
                ->first();

            if ($factor) {
                return $factor;
            }

            // Try parent category
            if ($category->parent_id) {
                return EnvironmentalFactor::where('category_id', $category->parent_id)
                    ->where('is_active', true)
                    ->where('is_verified', true)
                    ->first();
            }

            return null;
        });
    }

    /**
     * Calculate environmental metrics for an inventory item.
     * Returns verified data with source citations.
     */
    public function calculateMetrics(array $aiResponse): array
    {
        $category = $this->matchCategory(
            $aiResponse['category'] ?? 'Övrigt',
            $aiResponse['subcategory'] ?? null,
            $aiResponse['name'] ?? null
        );

        if (! $category) {
            Log::warning('EnvironmentalFactorService: No category match found', [
                'ai_category' => $aiResponse['category'] ?? null,
                'ai_subcategory' => $aiResponse['subcategory'] ?? null,
                'ai_name' => $aiResponse['name'] ?? null,
            ]);

            return $this->getDefaultMetrics();
        }

        $factor = $this->getFactorForCategory($category);

        if (! $factor) {
            Log::warning('EnvironmentalFactorService: No verified factor found for category', [
                'category_id' => $category->id,
                'category_slug' => $category->slug,
            ]);

            return $this->getDefaultMetrics($category);
        }

        return [
            'co2_savings_kg' => $factor->calculateCo2Savings(),
            'co2_new_kg' => (float) $factor->co2_new_kg,
            'co2_savings_percent' => (float) ($factor->co2_savings_percent ?? 90),
            'water_savings_liters' => $factor->calculateWaterSavings(),
            'water_new_liters' => $factor->water_new_liters ? (float) $factor->water_new_liters : null,
            'energy_savings_kwh' => $factor->energy_new_kwh ? round($factor->energy_new_kwh * 0.9, 2) : null,
            'waste_avoided_kg' => $factor->waste_new_kg ? (float) $factor->waste_new_kg : null,

            // Source information - CRITICAL for legal/CSR compliance
            'source' => [
                'name' => $factor->source_name,
                'report' => $factor->source_report,
                'url' => $factor->source_url,
                'publication_date' => $factor->source_publication_date?->format('Y-m-d'),
                'methodology' => $factor->source_methodology,
                'citation' => $factor->source_citation,
            ],

            // Verification information
            'verification' => [
                'is_verified' => $factor->is_verified,
                'verified_by' => $factor->verified_by,
                'verified_at' => $factor->verified_at?->format('Y-m-d'),
                'notes' => $factor->verification_notes,
            ],

            // Category information
            'matched_category' => [
                'id' => $category->id,
                'slug' => $category->slug,
                'name_sv' => $category->name_sv,
                'name_en' => $category->name_en,
                'path' => $category->getFullPath(),
            ],

            // Meta
            'data_source' => 'verified_database',
            'ai_estimated' => false,

            // IDs for database relations
            'category_id' => $category->id,
            'factor_id' => $factor->id,
        ];
    }

    /**
     * Get default metrics when no verified data is available.
     */
    private function getDefaultMetrics(?EnvironmentalCategory $category = null): array
    {
        return [
            'co2_savings_kg' => null,
            'co2_new_kg' => null,
            'co2_savings_percent' => null,
            'water_savings_liters' => null,
            'water_new_liters' => null,
            'energy_savings_kwh' => null,
            'waste_avoided_kg' => null,

            'source' => [
                'name' => null,
                'report' => null,
                'url' => null,
                'publication_date' => null,
                'methodology' => null,
                'citation' => null,
            ],

            'verification' => [
                'is_verified' => false,
                'verified_by' => null,
                'verified_at' => null,
                'notes' => 'Ingen verifierad data tillgänglig för denna kategori.',
            ],

            'matched_category' => $category ? [
                'id' => $category->id,
                'slug' => $category->slug,
                'name_sv' => $category->name_sv,
                'name_en' => $category->name_en,
                'path' => $category->getFullPath(),
            ] : null,

            'data_source' => 'no_data',
            'ai_estimated' => false,
        ];
    }

    /**
     * Clear cached data.
     */
    public function clearCache(): void
    {
        Cache::forget('environmental_categories_all');

        // Clear individual factor caches
        $categories = EnvironmentalCategory::all();
        foreach ($categories as $category) {
            Cache::forget("env_factor_{$category->id}");
        }
    }
}
