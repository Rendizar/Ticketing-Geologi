<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // GANTI INI: JANGAN foreignId() → PAKAI string + foreign manual!
            $table->string('booking_id'); // ← string, bukan integer!

            // Relasi manual ke kolom booking_id di tabel bookings
            $table->foreign('booking_id')
                  ->references('booking_id')  // ← refer ke kolom booking_id (string)
                  ->on('bookings')
                  ->onDelete('cascade');

            $table->string('transaction_id')->nullable()->unique();
            $table->decimal('jumlah_pembayaran', 15, 2)->default(0);
            $table->string('metode_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['pending', 'success', 'failed', 'expired', 'refunded'])
                  ->default('pending');
            $table->timestamp('dibayarkan_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};