<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('booking_id');
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_telepon');
            $table->enum('jenis_pemesanan', ['individu', 'rombongan'])->default('individu');
            $table->string('nama_rombongan')->nullable();
            $table->unsignedInteger('jumlah_pelajar')->default(0);
            $table->unsignedInteger('sub_tk')->default(0);
            $table->unsignedInteger('sub_sd')->default(0);
            $table->unsignedInteger('sub_smp')->default(0);
            $table->unsignedInteger('sub_sma')->default(0);
            $table->unsignedInteger('sub_kuliah')->default(0);
            $table->unsignedInteger('jumlah_umum')->default(0);
            $table->unsignedInteger('jumlah_asing')->default(0);
            $table->date('tanggal_kunjungan');
            $table->string('kota_kabupaten')->nullable();
            $table->string('kecamatan_provinsi')->nullable();
            $table->string('negara')->default('Indonesia');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
