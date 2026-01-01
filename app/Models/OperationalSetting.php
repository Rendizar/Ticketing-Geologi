<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalSetting extends Model
{
    protected $fillable = ['key', 'value', 'description'];

    /**
     * Get setting by key
     */
    public static function getSetting($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value
     */
    public static function setSetting($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'description' => $description]
        );
    }

    /**
     * Get operational days as array
     */
    public static function getOperationalDays()
    {
        $days = self::getSetting('operational_days', 'monday,tuesday,wednesday,thursday,saturday,sunday');
        return explode(',', $days);
    }

    /**
     * Get opening time
     */
    public static function getOpeningTime()
    {
        return self::getSetting('opening_time', '09:00');
    }

    /**
     * Get closing time
     */
    public static function getClosingTime()
    {
        return self::getSetting('closing_time', '16:00');
    }
}
