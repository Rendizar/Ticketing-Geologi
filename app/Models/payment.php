<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'event_booking_id', 'booking_type', 'transaction_id', 
        'jumlah_pembayaran', 'metode_pembayaran', 'status_pembayaran', 'dibayarkan_pada'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function eventBooking()
    {
        return $this->belongsTo(EventBooking::class, 'event_booking_id', 'booking_id');
    }
}