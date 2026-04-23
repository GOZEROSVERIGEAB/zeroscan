<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Services\EnvironmentalFactorService;
use Illuminate\Console\Command;

class UpdateInventoryEnvironmentalDataCommand extends Command
{
    protected $signature = 'app:update-inventory-environmental-data
                            {--all : Update all inventories, not just those with legacy data}
                            {--dry-run : Show what would be updated without making changes}';

    protected $description = 'Update existing inventories with verified environmental data from official sources (without re-running AI analysis)';

    public function handle(EnvironmentalFactorService $factorService): int
    {
        $query = Inventory::where('status', Inventory::STATUS_COMPLETED);

        if (!$this->option('all')) {
            $query->where(function ($q) {
                $q->whereNull('environmental_data_source')
                    ->orWhere('environmental_data_source', '!=', 'verified_database');
            });
        }

        $inventories = $query->get();
        $count = $inventories->count();

        if ($count === 0) {
            $this->info('No inventories need updating.');

            return self::SUCCESS;
        }

        $this->info("Found {$count} inventories to update with verified environmental data.");

        if ($this->option('dry-run')) {
            $this->warn('DRY RUN - No changes will be made.');
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $updated = 0;
        $noData = 0;
        $errors = 0;

        foreach ($inventories as $inventory) {
            try {
                // Build AI response-like array from existing data
                $aiData = [
                    'name' => $inventory->name,
                    'category' => $inventory->category,
                    'subcategory' => $inventory->subcategory,
                ];

                // Get verified metrics
                $envMetrics = $factorService->calculateMetrics($aiData);

                if ($this->option('dry-run')) {
                    if ($envMetrics['data_source'] === 'verified_database') {
                        $this->newLine();
                        $this->line(sprintf(
                            '  [%d] %s → %s: %.1f kg CO2 (was: %s)',
                            $inventory->id,
                            $inventory->name,
                            $envMetrics['matched_category']['name_sv'] ?? 'N/A',
                            $envMetrics['co2_savings_kg'] ?? 0,
                            $inventory->co2_savings ?? 'null'
                        ));
                    }
                } else {
                    // Build source citation
                    $sourceInfo = $envMetrics['source'] ?? [];
                    $co2Source = $sourceInfo['citation'] ?? $sourceInfo['name'] ?? null;
                    $co2Notes = null;

                    if ($envMetrics['data_source'] === 'verified_database') {
                        $co2Notes = sprintf(
                            'Källa: %s. Metod: %s. Publicerad: %s.',
                            $sourceInfo['report'] ?? $sourceInfo['name'] ?? 'Okänd',
                            $sourceInfo['methodology'] ?? 'LCA',
                            $sourceInfo['publication_date'] ?? 'Okänt datum'
                        );
                    }

                    $inventory->update([
                        'co2_savings' => $envMetrics['co2_savings_kg'],
                        'co2_source' => $co2Source,
                        'co2_calculation_notes' => $co2Notes,
                        'water_savings' => $envMetrics['water_savings_liters'],
                        'energy_savings' => $envMetrics['energy_savings_kwh'],
                        'environmental_category_id' => $envMetrics['category_id'] ?? null,
                        'environmental_factor_id' => $envMetrics['factor_id'] ?? null,
                        'environmental_data_verified' => $envMetrics['verification']['is_verified'] ?? false,
                        'environmental_data_source' => $envMetrics['data_source'],
                    ]);

                    if ($envMetrics['data_source'] === 'verified_database') {
                        $updated++;
                    } else {
                        $noData++;
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->error("Error updating inventory {$inventory->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if (!$this->option('dry-run')) {
            $this->info("Results:");
            $this->line("  - Updated with verified data: {$updated}");
            $this->line("  - No matching category found: {$noData}");
            if ($errors > 0) {
                $this->error("  - Errors: {$errors}");
            }
        }

        return self::SUCCESS;
    }
}
