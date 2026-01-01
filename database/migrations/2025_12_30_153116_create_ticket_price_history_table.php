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
        Schema::create('ticket_price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_category_id')->constrained()->onDelete('cascade');
            $table->decimal('old_price', 10, 2);
            $table->decimal('new_price', 10, 2);
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->text('reason')->nullable(); // Alasan perubahan harga
            $table->timestamps();

            // Foreign key dengan kolom id_login dari tabel admins
            $table->foreign('changed_by')->references('id_login')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_price_history');
    }
};
