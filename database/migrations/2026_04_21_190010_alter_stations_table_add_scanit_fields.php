<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            // Add uuid column
            if (! Schema::hasColumn('stations', 'uuid')) {
                $table->uuid('uuid')->unique()->after('id');
            }

            // Add facility_id and remove team_id
            if (! Schema::hasColumn('stations', 'facility_id')) {
                $table->foreignId('facility_id')->nullable()->after('public_uuid')->constrained()->cascadeOnDelete();
            }

            // Add new fields
            if (! Schema::hasColumn('stations', 'location_description')) {
                $table->string('location_description')->nullable()->after('description');
            }

            if (! Schema::hasColumn('stations', 'info_page_text')) {
                $table->text('info_page_text')->nullable()->after('logo_path');
            }

            if (! Schema::hasColumn('stations', 'gdpr_url')) {
                $table->string('gdpr_url')->nullable()->after('info_page_text');
            }

            if (! Schema::hasColumn('stations', 'thank_you_text')) {
                $table->text('thank_you_text')->nullable()->after('gdpr_url');
            }

            if (! Schema::hasColumn('stations', 'require_email')) {
                $table->boolean('require_email')->default(false)->after('is_active');
            }

            if (! Schema::hasColumn('stations', 'max_images')) {
                $table->integer('max_images')->default(5)->after('require_email');
            }

            if (! Schema::hasColumn('stations', 'primary_color')) {
                $table->string('primary_color')->default('#65a30d')->after('max_images');
            }

            if (! Schema::hasColumn('stations', 'total_scans')) {
                $table->integer('total_scans')->default(0)->after('primary_color');
            }

            if (! Schema::hasColumn('stations', 'total_items')) {
                $table->integer('total_items')->default(0)->after('total_scans');
            }

            if (! Schema::hasColumn('stations', 'total_co2_savings')) {
                $table->decimal('total_co2_savings', 12, 2)->default(0)->after('total_items');
            }

            if (! Schema::hasColumn('stations', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }
};
