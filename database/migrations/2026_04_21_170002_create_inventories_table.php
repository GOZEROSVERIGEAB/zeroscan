<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('station_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scanning_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_path')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('materials')->nullable();
            $table->string('colors')->nullable();
            $table->decimal('weight', 10, 3)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('depth', 10, 2)->nullable();
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->string('currency', 3)->default('SEK');
            $table->integer('condition_rating')->nullable();
            $table->text('condition_description')->nullable();
            $table->decimal('co2_savings', 10, 3)->nullable();
            $table->string('co2_source')->nullable();
            $table->text('co2_calculation_notes')->nullable();
            $table->decimal('ai_confidence', 5, 2)->nullable();
            $table->json('ai_response')->nullable();
            $table->integer('status')->default(999);
            $table->string('ai_provider')->nullable();
            $table->string('ai_model')->nullable();
            $table->integer('ai_tokens_used')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['station_id', 'status']);
            $table->index('scanning_session_id');
        });
    }
};
