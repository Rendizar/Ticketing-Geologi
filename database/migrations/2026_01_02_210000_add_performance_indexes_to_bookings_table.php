<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add indexes for better query performance and sustainability
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Index untuk kolom status (sering digunakan di WHERE clause)
            $table->index('status', 'idx_bookings_status');
            
            // Index untuk tanggal_kunjungan (sering digunakan untuk filter bulan/tahun dan GROUP BY)
            $table->index('tanggal_kunjungan', 'idx_bookings_tanggal_kunjungan');
            
            // Index untuk jumlah_tiket_khusus (digunakan di WHERE jumlah_tiket_khusus > 0)
            $table->index('jumlah_tiket_khusus', 'idx_bookings_jumlah_tiket_khusus');
            
            // Composite index untuk query yang filter status AND tanggal (paling sering digunakan)
            $table->index(['status', 'tanggal_kunjungan'], 'idx_bookings_status_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('idx_bookings_status');
            $table->dropIndex('idx_bookings_tanggal_kunjungan');
            $table->dropIndex('idx_bookings_jumlah_tiket_khusus');
            $table->dropIndex('idx_bookings_status_tanggal');
        });
    }
};
