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
        // Drop existing table if has wrong foreign key
        Schema::dropIfExists('special_ticket_requests');
        
        Schema::create('special_ticket_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('negara');
            $table->string('provinsi')->nullable();
            $table->enum('kategori_khusus', ['lansia', 'disabilitas', 'panti_asuhan', 'peserta_diklat', 'tamu_negara', 'lainnya']);
            $table->integer('jumlah_pengunjung')->default(1);
            $table->date('tanggal_kunjungan');
            $table->text('keterangan')->nullable();
            $table->string('bukti_dokumen'); // PDF file path
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('booking_id')->nullable(); // Link to booking setelah approved
            $table->timestamps();
            
            // Foreign key ke admins.id_login
            $table->foreign('reviewed_by')->references('id_login')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_ticket_requests');
    }
};
