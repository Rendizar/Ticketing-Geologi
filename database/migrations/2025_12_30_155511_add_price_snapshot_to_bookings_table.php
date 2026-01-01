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
        Schema::table('bookings', function (Blueprint $table) {
            // Snapshot harga saat booking dibuat (tidak berubah walau harga di ticket_categories berubah)
            $table->decimal('harga_pelajar_saat_booking', 10, 2)->nullable()->after('sub_kuliah');
            $table->decimal('harga_umum_saat_booking', 10, 2)->nullable()->after('harga_pelajar_saat_booking');
            $table->decimal('harga_asing_saat_booking', 10, 2)->nullable()->after('harga_umum_saat_booking');
            
            // Total pembayaran (dihitung dari qty * harga snapshot)
            $table->decimal('total_pembayaran', 15, 2)->default(0)->after('harga_asing_saat_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'harga_pelajar_saat_booking',
                'harga_umum_saat_booking', 
                'harga_asing_saat_booking',
                'total_pembayaran'
            ]);
        });
    }
};
