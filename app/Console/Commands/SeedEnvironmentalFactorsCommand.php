<?php

namespace App\Console\Commands;

use Database\Seeders\EnvironmentalFactorsSeeder;
use Illuminate\Console\Command;

class SeedEnvironmentalFactorsCommand extends Command
{
    protected $signature = 'app:seed-environmental-factors
                            {--fresh : Delete all existing data before seeding}';

    protected $description = 'Seed the environmental factors database with verified data from official sources (IVL, Naturskyddsföreningen, etc)';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            if (!$this->confirm('This will delete ALL existing environmental data. Continue?')) {
                $this->info('Aborted.');

                return self::SUCCESS;
            }

            $this->info('Clearing existing environmental data...');

            \App\Models\EnvironmentalFactor::query()->delete();
            \App\Models\EnvironmentalCategory::query()->delete();
            \App\Models\EnvironmentalSource::query()->delete();

            $this->info('Cleared.');
        }

        $this->info('Seeding environmental factors from verified sources...');

        $seeder = new EnvironmentalFactorsSeeder();
        $seeder->run();

        // Clear cache
        $factorService = app(\App\Services\EnvironmentalFactorService::class);
        $factorService->clearCache();

        $categoryCount = \App\Models\EnvironmentalCategory::count();
        $factorCount = \App\Models\EnvironmentalFactor::count();
        $sourceCount = \App\Models\EnvironmentalSource::count();

        $this->info("Done! Seeded:");
        $this->line("  - {$sourceCount} verified sources");
        $this->line("  - {$categoryCount} product categories");
        $this->line("  - {$factorCount} environmental factors");

        $this->newLine();
        $this->info('Sources used:');
        foreach (\App\Models\EnvironmentalSource::all() as $source) {
            $this->line("  - {$source->organization}: {$source->report_title}");
        }

        return self::SUCCESS;
    }
}
