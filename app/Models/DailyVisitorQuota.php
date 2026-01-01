<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyVisitorQuota extends Model
{
    protected $fillable = [
        'tanggal',
        'max_capacity',
        'total_booked',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'max_capacity' => 'integer',
        'total_booked' => 'integer',
    ];

    /**
     * Check if there's available capacity for the given number of visitors
     */
    public function hasAvailableCapacity($requestedSlots)
    {
        return ($this->max_capacity - $this->total_booked) >= $requestedSlots;
    }

    /**
     * Get available slots
     */
    public function getAvailableSlots()
    {
        return max(0, $this->max_capacity - $this->total_booked);
    }

    /**
     * Get or create quota record for a specific date
     */
    public static function getOrCreate($tanggal, $maxCapacity = 2500)
    {
        return self::firstOrCreate(
            ['tanggal' => $tanggal],
            [
                'max_capacity' => $maxCapacity,
                'total_booked' => 0,
            ]
        );
    }

    /**
     * Get booking percentage
     */
    public function getBookingPercentage()
    {
        if ($this->max_capacity == 0) return 0;
        return round(($this->total_booked / $this->max_capacity) * 100, 2);
    }
}
