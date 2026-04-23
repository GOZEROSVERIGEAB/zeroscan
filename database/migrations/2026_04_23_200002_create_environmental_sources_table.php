<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('environmental_sources', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('organization')->comment('IVL, Naturskyddsföreningen, Naturvårdsverket, etc');
            $table->string('report_title')->nullable();
            $table->string('report_url')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('methodology')->nullable()->comment('LCA ISO 14040-44, etc');
            $table->text('description')->nullable();
            $table->boolean('is_official')->default(false)->comment('Government or research institute');
            $table->boolean('is_peer_reviewed')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add source_id to environmental_factors
        Schema::table('environmental_factors', function (Blueprint $table) {
            $table->foreignId('source_id')->nullable()->after('category_id')->constrained('environmental_sources')->nullOnDelete();
        });
    }
};
