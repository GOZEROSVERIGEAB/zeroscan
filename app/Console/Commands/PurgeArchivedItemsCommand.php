<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Models\Station;
use Illuminate\Console\Command;

class PurgeArchivedItemsCommand extends Command
{
    protected $signature = 'archive:purge {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Permanently delete facilities and stations that have been archived for more than 7 days';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $cutoffDate = now()->subDays(7);

        $this->info('Purging archived items older than ' . $cutoffDate->toDateTimeString());

        // Find stations to purge
        $stationsToDelete = Station::onlyTrashed()
            ->where('deleted_at', '<', $cutoffDate)
            ->get();

        // Find facilities to purge (will cascade delete related stations)
        $facilitiesToDelete = Facility::onlyTrashed()
            ->where('deleted_at', '<', $cutoffDate)
            ->get();

        if ($stationsToDelete->isEmpty() && $facilitiesToDelete->isEmpty()) {
            $this->info('No archived items to purge.');

            return Command::SUCCESS;
        }

        $this->info("Found {$facilitiesToDelete->count()} facilities to purge.");
        $this->info("Found {$stationsToDelete->count()} stations to purge.");

        if ($dryRun) {
            $this->warn('Dry run mode - no items will be deleted.');

            foreach ($facilitiesToDelete as $facility) {
                $this->line("  Would delete facility: {$facility->name} (archived {$facility->deleted_at->diffForHumans()})");
            }

            foreach ($stationsToDelete as $station) {
                $this->line("  Would delete station: {$station->name} (archived {$station->deleted_at->diffForHumans()})");
            }

            return Command::SUCCESS;
        }

        // Purge stations first (they might belong to facilities not being deleted)
        foreach ($stationsToDelete as $station) {
            $this->line("Purging station: {$station->name}");
            $station->forceDelete();
        }

        // Purge facilities (related stations will be handled by cascade or already deleted)
        foreach ($facilitiesToDelete as $facility) {
            $this->line("Purging facility: {$facility->name}");
            // Force delete related stations first
            $facility->stations()->withTrashed()->forceDelete();
            $facility->forceDelete();
        }

        $this->info('Purge completed successfully.');

        return Command::SUCCESS;
    }
}
