<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('public_uuid')->unique();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('location_description')->nullable();
            $table->string('logo_path')->nullable();
            $table->text('info_page_text')->nullable();
            $table->string('gdpr_url')->nullable();
            $table->text('thank_you_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('require_email')->default(false);
            $table->integer('max_images')->default(5);
            $table->string('primary_color', 7)->default('#65a30d');
            $table->integer('total_scans')->default(0);
            $table->integer('total_items')->default(0);
            $table->decimal('total_co2_savings', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['facility_id', 'is_active']);
        });
    }
};
