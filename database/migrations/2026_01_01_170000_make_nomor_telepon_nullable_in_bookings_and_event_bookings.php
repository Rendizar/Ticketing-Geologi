<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make nomor_telepon nullable in bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->change();
        });

        // Make nomor_telepon nullable in event_bookings table
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert nomor_telepon to not nullable in bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable(false)->change();
        });

        // Revert nomor_telepon to not nullable in event_bookings table
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable(false)->change();
        });
    }
};
