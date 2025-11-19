<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;

    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'nama', 'email', 'nomor_telepon', 'jenis_pemesanan', 'nama_rombongan',
        'jumlah_pelajar', 'sub_tk', 'sub_sd', 'sub_smp', 'sub_sma', 'sub_kuliah',
        'jumlah_umum', 'jumlah_asing', 'tanggal_kunjungan', 'kota_kabupaten',
        'kecamatan_provinsi', 'negara'
    ];

    public function payment() {
        return $this->hasOne(Payment::class, 'booking_id');
    }
}
