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
        Schema::table('events', function (Blueprint $table) {
            // Add available_slots column after capacity
            // Initially set to same as capacity for existing events
            $table->integer('available_slots')->default(0)->after('capacity');
        });

        // Update existing events to have available_slots = capacity
        DB::statement('UPDATE events SET available_slots = capacity WHERE available_slots = 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('available_slots');
        });
    }
};
