<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedInteger('max_facilities')->nullable()->after('is_enterprise');
            $table->unsignedInteger('max_stations')->nullable()->after('max_facilities');
            $table->unsignedInteger('max_scans_per_month')->nullable()->after('max_stations');
            $table->date('trial_ends_at')->nullable()->after('max_scans_per_month');
            $table->string('subscription_status')->default('trial')->after('trial_ends_at');
        });
    }
};
