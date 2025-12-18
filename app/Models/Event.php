<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'event_date',
        'event_time',
        'capacity',
        'available_slots',
        'is_active'
    ];

    /**
     * Reduce available slots when booking is made
     */
    public function reduceSlots($quantity)
    {
        if ($this->available_slots >= $quantity) {
            $this->decrement('available_slots', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Check if event has available slots
     */
    public function hasAvailableSlots($quantity = 1)
    {
        return $this->available_slots >= $quantity;
    }

    /**
     * Get booked percentage
     */
    public function getBookedPercentageAttribute()
    {
        if ($this->capacity == 0) return 0;
        $booked = $this->capacity - $this->available_slots;
        return round(($booked / $this->capacity) * 100, 1);
    }
}
