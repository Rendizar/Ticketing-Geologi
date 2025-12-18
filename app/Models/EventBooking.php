<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventBooking extends Model
{
    protected $fillable = [
        'booking_id',
        'event_id',
        'nama',
        'email',
        'nomor_telepon',
        'negara',
        'kota_kabupaten',
        'provinsi',
        'jenis_pemesanan',
        'nama_rombongan',
        'kategori',
        'jumlah_tiket',
        'total_harga',
        'payment_type',
        'transaction_id',
        'payment_status',
        'unique_key'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->booking_id) {
                $model->booking_id = 'EVT-' . strtoupper(Str::random(10));
            }
            if (!$model->unique_key) {
                $model->unique_key = Str::uuid();
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
