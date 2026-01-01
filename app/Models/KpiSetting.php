<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSetting extends Model
{
    protected $fillable = [
        'target_daily',
        'target_monthly',
        'target_yearly',
        'target_revenue_monthly',
        'target_revenue_yearly',
    ];

    protected $casts = [
        'target_daily' => 'integer',
        'target_monthly' => 'integer',
        'target_yearly' => 'integer',
        'target_revenue_monthly' => 'integer',
        'target_revenue_yearly' => 'integer',
    ];
}
