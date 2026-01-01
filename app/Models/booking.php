<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $incrementing = false;           // karena booking_id bukan auto-increment
    protected $keyType = 'string';          // tipe string
    protected $primaryKey = 'booking_id';   // primary key custom

    protected $fillable = [
        'booking_id', 'nama', 'email', 'nomor_telepon', 'negara',
        'jenis_pemesanan', 'nama_rombongan', 'tanggal_kunjungan', 'slot_waktu',
        'provinsi', 'jumlah_pelajar', 'jumlah_umum',
        'jumlah_asing', 'sub_tk', 'sub_sd', 'sub_smp', 'sub_sma', 'sub_kuliah',
        'harga_pelajar_saat_booking', 'harga_umum_saat_booking', 'harga_asing_saat_booking',
        'total_pembayaran', 'status', 'unique_key', 'kategori_khusus', 'jumlah_tiket_khusus'
    ];

    protected $casts = [
        'harga_pelajar_saat_booking' => 'decimal:2',
        'harga_umum_saat_booking' => 'decimal:2',
        'harga_asing_saat_booking' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'booking_id');
        // karena nanti Payment pakai booking_id string, bukan id integer
    }
}