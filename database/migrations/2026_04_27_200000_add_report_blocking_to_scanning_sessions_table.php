<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scanning_sessions', function (Blueprint $table) {
            $table->boolean('report_blocked')->default(false)->after('report_sent_at');
            $table->string('report_blocked_reason')->nullable()->after('report_blocked');
            $table->timestamp('admin_notified_at')->nullable()->after('report_blocked_reason');
        });
    }
};
