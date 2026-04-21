<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scanning_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_uuid')->unique();
            $table->foreignId('station_id')->constrained()->cascadeOnDelete();
            $table->string('email')->nullable();
            $table->json('inventory_uuids')->nullable();
            $table->boolean('report_sent')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('station_id');
            $table->index('email');
        });
    }
};
