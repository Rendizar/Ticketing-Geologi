<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyGroupQuota extends Model
{
    protected $fillable = [
        'tanggal',
        'slot_waktu',
        'quota',
        'used',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'quota' => 'integer',
        'used' => 'integer',
    ];

    /**
     * Check if slot is available
     */
    public function isAvailable($requiredSlots = 1)
    {
        return ($this->quota - $this->used) >= $requiredSlots;
    }

    /**
     * Get available slots
     */
    public function getAvailableSlots()
    {
        return $this->quota - $this->used;
    }

    /**
     * Get or create quota record
     */
    public static function getOrCreate($tanggal, $slot_waktu, $defaultQuota = 100)
    {
        return self::firstOrCreate(
            [
                'tanggal' => $tanggal,
                'slot_waktu' => $slot_waktu,
            ],
            [
                'quota' => $defaultQuota,
                'used' => 0,
            ]
        );
    }
}
