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
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama kategori: Pelajar, Umum, Asing, dll
            $table->string('code')->unique(); // Kode kategori: pelajar, umum, asing
            $table->decimal('price', 10, 2); // Harga tiket
            $table->text('description')->nullable(); // Deskripsi kategori
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->integer('sort_order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_categories');
    }
};
