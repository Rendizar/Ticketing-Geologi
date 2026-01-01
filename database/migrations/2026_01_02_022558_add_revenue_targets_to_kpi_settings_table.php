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
        Schema::table('kpi_settings', function (Blueprint $table) {
            $table->bigInteger('target_revenue_monthly')->default(0)->after('target_yearly');
            $table->bigInteger('target_revenue_yearly')->default(0)->after('target_revenue_monthly');
        });

        // Update existing record with default revenue targets
        DB::table('kpi_settings')->update([
            'target_revenue_monthly' => 50000000, // Default 50 juta per bulan
            'target_revenue_yearly' => 600000000,  // Default 600 juta per tahun
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpi_settings', function (Blueprint $table) {
            $table->dropColumn(['target_revenue_monthly', 'target_revenue_yearly']);
        });
    }
};
