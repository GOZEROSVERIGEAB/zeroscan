<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scanning_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('scanning_sessions', 'visitor_name')) {
                $table->string('visitor_name')->nullable()->after('station_id');
            }

            if (!Schema::hasColumn('scanning_sessions', 'status')) {
                $table->string('status')->default('pending')->after('session_uuid');
            }

            if (!Schema::hasColumn('scanning_sessions', 'ai_processing_started_at')) {
                $table->timestamp('ai_processing_started_at')->nullable()->after('completed_at');
            }

            if (!Schema::hasColumn('scanning_sessions', 'ai_processing_completed_at')) {
                $table->timestamp('ai_processing_completed_at')->nullable()->after('ai_processing_started_at');
            }

            if (!Schema::hasColumn('scanning_sessions', 'report_sent_at')) {
                $table->timestamp('report_sent_at')->nullable()->after('report_sent');
            }

            if (!Schema::hasColumn('scanning_sessions', 'total_items')) {
                $table->unsignedInteger('total_items')->default(0)->after('report_sent_at');
            }

            if (!Schema::hasColumn('scanning_sessions', 'total_co2_savings')) {
                $table->decimal('total_co2_savings', 10, 3)->default(0)->after('total_items');
            }

            if (!Schema::hasColumn('scanning_sessions', 'error_message')) {
                $table->text('error_message')->nullable()->after('total_co2_savings');
            }

            $table->index('status');
        });
    }
};
