<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scanning_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('scanning_sessions', 'inventory_uuids')) {
                $table->json('inventory_uuids')->nullable()->after('email');
            }

            if (! Schema::hasColumn('scanning_sessions', 'report_sent')) {
                $table->boolean('report_sent')->default(false)->after('inventory_uuids');
            }

            if (! Schema::hasColumn('scanning_sessions', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('report_sent');
            }

            // Add indexes
            $table->index(['station_id', 'created_at']);
            $table->index(['report_sent', 'email']);
        });
    }
};
