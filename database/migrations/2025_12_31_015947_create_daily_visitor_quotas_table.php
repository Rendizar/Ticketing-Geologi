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
        Schema::create('daily_visitor_quotas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->integer('max_capacity')->default(2500); // Kapasitas maksimal per hari
            $table->integer('total_booked')->default(0); // Total yang sudah dibooking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_visitor_quotas');
    }
};
