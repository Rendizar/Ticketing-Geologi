<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum column untuk menambahkan 'lainnya'
        DB::statement("ALTER TABLE special_ticket_requests MODIFY COLUMN kategori_khusus ENUM('lansia', 'disabilitas', 'panti_asuhan', 'peserta_diklat', 'tamu_negara', 'lainnya') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback ke enum semula
        DB::statement("ALTER TABLE special_ticket_requests MODIFY COLUMN kategori_khusus ENUM('lansia', 'disabilitas', 'panti_asuhan', 'peserta_diklat', 'tamu_negara') NOT NULL");
    }
};
