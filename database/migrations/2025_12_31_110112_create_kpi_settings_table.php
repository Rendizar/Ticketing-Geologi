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
        Schema::create('kpi_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('target_daily')->default(100);
            $table->integer('target_monthly')->default(3000);
            $table->integer('target_yearly')->default(36000);
            $table->timestamps();
        });

        // Insert default values
        DB::table('kpi_settings')->insert([
            'target_daily' => 100,
            'target_monthly' => 3000,
            'target_yearly' => 36000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_settings');
    }
};
