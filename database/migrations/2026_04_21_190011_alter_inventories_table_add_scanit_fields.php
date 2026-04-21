<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Rename item_name to name
            if (! Schema::hasColumn('inventories', 'name') && Schema::hasColumn('inventories', 'item_name')) {
                $table->renameColumn('item_name', 'name');
            }

            // Rename item_description to description
            if (! Schema::hasColumn('inventories', 'description') && Schema::hasColumn('inventories', 'item_description')) {
                $table->renameColumn('item_description', 'description');
            }

            // Rename item_category to category
            if (! Schema::hasColumn('inventories', 'category') && Schema::hasColumn('inventories', 'item_category')) {
                $table->renameColumn('item_category', 'category');
            }
        });

        Schema::table('inventories', function (Blueprint $table) {
            if (! Schema::hasColumn('inventories', 'subcategory')) {
                $table->string('subcategory')->nullable()->after('category');
            }

            if (! Schema::hasColumn('inventories', 'brand')) {
                $table->string('brand')->nullable()->after('subcategory');
            }

            if (! Schema::hasColumn('inventories', 'model')) {
                $table->string('model')->nullable()->after('brand');
            }

            if (! Schema::hasColumn('inventories', 'materials')) {
                $table->string('materials')->nullable()->after('model');
            }

            if (! Schema::hasColumn('inventories', 'colors')) {
                $table->string('colors')->nullable()->after('materials');
            }

            if (! Schema::hasColumn('inventories', 'weight')) {
                $table->decimal('weight', 10, 3)->nullable()->after('colors');
            }

            if (! Schema::hasColumn('inventories', 'height')) {
                $table->decimal('height', 10, 2)->nullable()->after('weight');
            }

            if (! Schema::hasColumn('inventories', 'width')) {
                $table->decimal('width', 10, 2)->nullable()->after('height');
            }

            if (! Schema::hasColumn('inventories', 'depth')) {
                $table->decimal('depth', 10, 2)->nullable()->after('width');
            }

            if (! Schema::hasColumn('inventories', 'currency')) {
                $table->string('currency')->default('SEK')->after('estimated_value');
            }

            if (! Schema::hasColumn('inventories', 'condition_rating')) {
                $table->integer('condition_rating')->nullable()->after('currency');
            }

            if (! Schema::hasColumn('inventories', 'condition_description')) {
                $table->text('condition_description')->nullable()->after('condition_rating');
            }

            if (! Schema::hasColumn('inventories', 'co2_savings')) {
                $table->decimal('co2_savings', 12, 3)->nullable()->after('condition_description');
            }

            if (! Schema::hasColumn('inventories', 'co2_source')) {
                $table->string('co2_source')->nullable()->after('co2_savings');
            }

            if (! Schema::hasColumn('inventories', 'co2_calculation_notes')) {
                $table->text('co2_calculation_notes')->nullable()->after('co2_source');
            }

            if (! Schema::hasColumn('inventories', 'ai_model')) {
                $table->string('ai_model')->nullable()->after('ai_provider');
            }

            if (! Schema::hasColumn('inventories', 'ai_tokens_used')) {
                $table->integer('ai_tokens_used')->default(0)->after('ai_model');
            }

            if (! Schema::hasColumn('inventories', 'ai_confidence')) {
                $table->decimal('ai_confidence', 5, 2)->nullable()->after('ai_tokens_used');
            }

            if (! Schema::hasColumn('inventories', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add scanning_session_id + status index if it doesn't exist
        $indexExists = collect(DB::select("SHOW INDEX FROM inventories WHERE Key_name = 'inventories_scanning_session_id_status_index'"))->isNotEmpty();

        if (! $indexExists) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->index(['scanning_session_id', 'status']);
            });
        }
    }
};
