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
        Schema::create('daily_group_quotas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('slot_waktu'); // Format: "08:00-09:00", "09:00-10:00", dst
            $table->integer('quota')->default(100); // Batas kuota per slot
            $table->integer('used')->default(0); // Jumlah yang sudah terpakai
            $table->timestamps();
            
            // Unique constraint untuk kombinasi tanggal dan slot waktu
            $table->unique(['tanggal', 'slot_waktu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_group_quotas');
    }
};
