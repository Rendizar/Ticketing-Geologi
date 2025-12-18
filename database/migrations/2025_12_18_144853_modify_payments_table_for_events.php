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
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['booking_id']);
            
            // Make booking_id nullable so we can have either booking_id OR event_booking_id
            $table->string('booking_id')->nullable()->change();
            
            // Add event_booking_id column
            $table->string('event_booking_id')->nullable()->after('booking_id');
            
            // Add booking_type to identify which type of booking this payment is for
            $table->enum('booking_type', ['regular', 'event'])->default('regular')->after('event_booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['event_booking_id', 'booking_type']);
            
            // Restore booking_id to not nullable
            $table->string('booking_id')->nullable(false)->change();
            
            // Re-add foreign key
            $table->foreign('booking_id')
                  ->references('booking_id')
                  ->on('bookings')
                  ->onDelete('cascade');
        });
    }
};
