<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            // Make team_id nullable since we're moving to facility-based hierarchy
            if (Schema::hasColumn('stations', 'team_id')) {
                $table->bigInteger('team_id')->unsigned()->nullable()->change();
            }
        });
    }
};
