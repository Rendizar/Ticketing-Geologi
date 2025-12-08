<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            // Primary key pakai UUID atau bigIncrements boleh, tapi kalau pakai bigIncrements,
            // pastikan juga dipakai sebagai order_id Midtrans (bisa, karena unik)
            $table->bigIncrements('id');                    // ganti jadi id biasa (lebih standar)
            $table->string('booking_id')->unique();          // ini yang dipakai sebagai kode booking & order_id Midtrans

            $table->string('nama');
            $table->string('email');
            $table->string('nomor_telepon');

            $table->enum('jenis_pemesanan', ['individu', 'rombongan'])->default('individu');
            $table->string('nama_rombongan')->nullable();

            // Jumlah pengunjung
            $table->unsignedInteger('jumlah_pelajar')->default(0);
            $table->unsignedInteger('jumlah_umum')->default(0);
            $table->unsignedInteger('jumlah_asing')->default(0);

            // Sub-jenjang hanya untuk pelajar (individu atau rombongan)
            $table->unsignedInteger('sub_tk')->default(0);
            $table->unsignedInteger('sub_sd')->default(0);
            $table->unsignedInteger('sub_smp')->default(0);
            $table->unsignedInteger('sub_sma')->default(0);
            $table->unsignedInteger('sub_kuliah')->default(0);

            $table->date('tanggal_kunjungan');

            // Lokasi (khusus Indonesia)
            $table->string('kota_kabupaten')->nullable();
            $table->string('provinsi')->nullable();         // PERBAIKAN: ganti dari kecamatan_provinsi → provinsi

            $table->string('negara');

            // Status booking (opsional, sangat membantu nanti)
            $table->enum('status', ['pending', 'paid', 'expired', 'cancelled'])
                  ->default('pending');

            // Unique key untuk akses tiket tanpa login (opsional tapi sangat berguna)
            $table->uuid('unique_key')->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};