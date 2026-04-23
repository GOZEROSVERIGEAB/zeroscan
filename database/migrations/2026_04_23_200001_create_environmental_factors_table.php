<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('environmental_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('environmental_categories')->cascadeOnDelete();

            // CO2 data
            $table->decimal('co2_new_kg', 10, 3)->comment('CO2e in kg for new production');
            $table->decimal('co2_used_kg', 10, 3)->nullable()->comment('CO2e in kg for secondhand (transport etc)');
            $table->decimal('co2_savings_percent', 5, 2)->nullable()->comment('Percentage saved by buying used');

            // Water data
            $table->decimal('water_new_liters', 12, 2)->nullable()->comment('Water usage in liters for new production');
            $table->decimal('water_savings_percent', 5, 2)->nullable();

            // Energy data
            $table->decimal('energy_new_kwh', 10, 2)->nullable()->comment('Energy in kWh for new production');
            $table->decimal('energy_savings_percent', 5, 2)->nullable();

            // Waste data
            $table->decimal('waste_new_kg', 10, 3)->nullable()->comment('Waste in kg from new production');

            // Source and verification
            $table->string('source_name')->comment('Name of source (IVL, Naturskyddsföreningen, etc)');
            $table->string('source_report')->nullable()->comment('Report name/title');
            $table->string('source_url')->nullable();
            $table->date('source_publication_date')->nullable();
            $table->string('source_methodology')->nullable()->comment('LCA, ISO 14040, etc');

            // Verification
            $table->string('verified_by')->nullable()->comment('Who verified this data');
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();

            // Validity
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);

            $table->timestamps();

            $table->index(['category_id', 'is_active', 'is_verified']);
        });
    }
};
