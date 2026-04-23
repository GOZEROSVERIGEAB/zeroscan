<?php

namespace App\Console\Commands;

use App\Jobs\ProcessScannedInventory;
use App\Models\Inventory;
use Illuminate\Console\Command;

class ReprocessInventoriesCommand extends Command
{
    protected $signature = 'inventories:reprocess {--limit= : Limit number of items to reprocess}';

    protected $description = 'Reprocess all completed inventories through AI to update water and energy savings';

    public function handle(): int
    {
        $query = Inventory::query()
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereNotNull('image_path');

        $limit = $this->option('limit');
        if ($limit) {
            $query->limit((int) $limit);
        }

        $count = $query->count();

        if ($count === 0) {
            $this->warn('No inventories found to reprocess.');
            return Command::SUCCESS;
        }

        $this->info("Found {$count} inventories to reprocess.");

        if (!$this->confirm('Do you want to dispatch all these jobs to the queue?')) {
            $this->info('Cancelled.');
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $dispatched = 0;

        $query->each(function (Inventory $inventory) use (&$dispatched, $bar) {
            $inventory->update(['status' => Inventory::STATUS_QUEUED]);
            ProcessScannedInventory::dispatch($inventory);
            $dispatched++;
            $bar->advance();
        });

        $bar->finish();
        $this->newLine();

        $this->info("Dispatched {$dispatched} jobs to the queue.");
        $this->comment('Run `php artisan queue:work` to process the jobs.');

        return Command::SUCCESS;
    }
}
