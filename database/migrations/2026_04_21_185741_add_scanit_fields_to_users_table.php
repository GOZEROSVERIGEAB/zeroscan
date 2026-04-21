<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'customer_id')) {
                $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email');
            }

            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'otp_enabled')) {
                $table->boolean('otp_enabled')->default(true)->after('phone');
            }

            if (! Schema::hasColumn('users', 'otp_secret')) {
                $table->string('otp_secret')->nullable()->after('otp_enabled');
            }

            if (! Schema::hasColumn('users', 'otp_verified_at')) {
                $table->timestamp('otp_verified_at')->nullable()->after('otp_secret');
            }
        });
    }
};
