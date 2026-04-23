<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('environmental_category_id')
                ->nullable()
                ->after('co2_calculation_notes')
                ->constrained('environmental_categories')
                ->nullOnDelete();

            $table->foreignId('environmental_factor_id')
                ->nullable()
                ->after('environmental_category_id')
                ->constrained('environmental_factors')
                ->nullOnDelete();

            $table->boolean('environmental_data_verified')
                ->default(false)
                ->after('environmental_factor_id')
                ->comment('True if environmental data comes from verified database');

            $table->string('environmental_data_source')
                ->nullable()
                ->after('environmental_data_verified')
                ->comment('verified_database, no_data, or legacy_ai');
        });
    }
};
