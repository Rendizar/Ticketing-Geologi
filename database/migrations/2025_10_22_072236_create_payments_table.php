<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('booking_id');
            $table->string('transaction_id')->nullable();
            $table->unsignedInteger('jumlah_pembayaran');
            $table->enum('metode_pembayaran', ['credit_card', 'bank_transfer', 'ewallet', 'other'])->nullable();
            $table->enum('status_pembayaran', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->dateTime('dibayarkan_pada')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
