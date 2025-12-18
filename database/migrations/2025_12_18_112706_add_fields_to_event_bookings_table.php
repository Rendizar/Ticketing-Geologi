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
        Schema::table('event_bookings', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('event_bookings', 'jenis_pemesanan')) {
                $table->enum('jenis_pemesanan', ['individu', 'rombongan'])->default('individu')->after('provinsi');
            }
            if (!Schema::hasColumn('event_bookings', 'nama_rombongan')) {
                $table->string('nama_rombongan')->nullable()->after('jenis_pemesanan');
            }
            if (!Schema::hasColumn('event_bookings', 'kategori')) {
                $table->enum('kategori', ['pelajar', 'umum', 'asing'])->nullable()->after('nama_rombongan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['jenis_pemesanan', 'nama_rombongan', 'kategori']);
        });
    }
};
