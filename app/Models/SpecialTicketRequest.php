<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTicketRequest extends Model
{
    protected $fillable = [
        'request_id',
        'nama',
        'email',
        'negara',
        'provinsi',
        'kategori_khusus',
        'jumlah_pengunjung',
        'tanggal_kunjungan',
        'keterangan',
        'bukti_dokumen',
        'status',
        'reviewed_by',
        'admin_note',
        'reviewed_at',
        'booking_id',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by', 'id_login');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public static function getKategoriLabel($code)
    {
        $labels = [
            'lansia' => 'Lansia (≥60 Tahun)',
            'disabilitas' => 'Penyandang Disabilitas',
            'panti_asuhan' => 'Panti Asuhan',
            'peserta_diklat' => 'Peserta Diklat',
            'tamu_negara' => 'Tamu Negara',
            'lainnya' => 'Lainnya',
        ];
        
        return $labels[$code] ?? $code;
    }
}

