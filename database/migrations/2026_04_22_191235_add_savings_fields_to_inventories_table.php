<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->decimal('water_savings', 10, 3)->nullable()->after('co2_savings');
            $table->decimal('energy_savings', 10, 3)->nullable()->after('water_savings');
        });
    }
};
