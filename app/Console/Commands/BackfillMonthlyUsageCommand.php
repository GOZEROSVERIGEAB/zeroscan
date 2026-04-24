<?php

namespace App\Console\Commands;

use App\Models\CustomerMonthlyUsage;
use App\Models\Inventory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillMonthlyUsageCommand extends Command
{
    protected $signature = 'app:backfill-monthly-usage';

    protected $description = 'Backfill customer monthly usage data from existing inventories';

    public function handle(): int
    {
        $this->info('Backfilling monthly usage data...');

        // Clear existing data
        CustomerMonthlyUsage::truncate();
        $this->info('Cleared existing usage data.');

        // Get completed inventories grouped by customer, year, and month
        $usageData = Inventory::query()
            ->where('status', Inventory::STATUS_COMPLETED)
            ->whereNotNull('processed_at')
            ->join('stations', 'inventories.station_id', '=', 'stations.id')
            ->join('facilities', 'stations.facility_id', '=', 'facilities.id')
            ->whereNotNull('facilities.customer_id')
            ->selectRaw('
                facilities.customer_id,
                YEAR(inventories.processed_at) as year,
                MONTH(inventories.processed_at) as month,
                COUNT(*) as scan_count
            ')
            ->groupBy('facilities.customer_id', DB::raw('YEAR(inventories.processed_at)'), DB::raw('MONTH(inventories.processed_at)'))
            ->get();

        $count = 0;
        foreach ($usageData as $data) {
            CustomerMonthlyUsage::create([
                'customer_id' => $data->customer_id,
                'year' => $data->year,
                'month' => $data->month,
                'scan_count' => $data->scan_count,
            ]);
            $count++;
        }

        $this->info("Created {$count} monthly usage records.");

        return Command::SUCCESS;
    }
}
