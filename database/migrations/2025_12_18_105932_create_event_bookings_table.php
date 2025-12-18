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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('booking_id')->unique(); // Kode booking unik
            
            // Event reference
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            
            // Customer info
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_telepon');
            $table->string('negara');
            $table->string('kota_kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            
            // Booking details
            $table->unsignedInteger('jumlah_tiket')->default(1);
            $table->decimal('total_harga', 10, 2);
            
            // Payment info
            $table->string('payment_type')->nullable(); // Midtrans payment type
            $table->string('transaction_id')->nullable(); // Midtrans transaction ID
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'cancelled'])->default('pending');
            
            // Unique key untuk akses tiket
            $table->uuid('unique_key')->nullable()->unique();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_bookings');
    }
};
