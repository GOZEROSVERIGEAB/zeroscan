<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->string('branding_logo_path')->nullable()->after('primary_color');
            $table->string('branding_service_name')->nullable()->after('branding_logo_path');
            $table->boolean('use_custom_branding')->default(false)->after('branding_service_name');
        });
    }
};
