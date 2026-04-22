<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scanning_sessions', function (Blueprint $table) {
            $table->boolean('gdpr_consent')->default(false)->after('email');
            $table->timestamp('gdpr_consent_at')->nullable()->after('gdpr_consent');
        });
    }
};
