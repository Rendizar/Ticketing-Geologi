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
        'is_active'
    ];
}
