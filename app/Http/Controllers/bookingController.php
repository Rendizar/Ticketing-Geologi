<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facades\Pdf;

class BookingController extends Controller
{
    // INI YANG HARUS ADA — METHOD CREATE!
    public function create()
    {
        return view('visitor.create'); // atau 'tickets.create' kalau view-nya di folder tickets
    }
    public function store(Request $request)
    {
        // 1. VALIDASI (sama seperti sebelumnya)
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'email'             => 'required|email',
            'negara'            => 'required|string',
            'nomor_telepon'     => 'required|string|min:10|max:15',
            'jenis_pemesanan'   => 'required|in:individu,rombongan',
            'nama_rombongan'    => 'required_if:jenis_pemesanan,rombongan|nullable|string',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'kota_kabupaten'    => 'nullable|string',
            'provinsi'          => 'nullable|string',
        ]);

        // 2. HITUNG JUMLAH & HARGA (sama persis)
        $jumlah_pelajar = $jumlah_umum = $jumlah_asing = 0;
        $sub_tk = $sub_sd = $sub_smp = $sub_sma = $sub_kuliah = 0;

        if ($request->jenis_pemesanan === 'individu') {
            if ($request->kategori_individu === 'asing') {
                $jumlah_asing = 1;
            } elseif ($request->kategori_individu === 'umum') {
                if ($request->is_pelajar === 'pelajar' && $request->jenjang_pelajar) {
                    $jumlah_pelajar = 1;
                    ${$request->jenjang_pelajar} = 1;
                } else {
                    $jumlah_umum = 1;
                }
            }
        } else {
            $jumlah_pelajar = (int)($request->sub_tk ?? 0) + (int)($request->sub_sd ?? 0) +
                              (int)($request->sub_smp ?? 0) + (int)($request->sub_sma ?? 0) +
                              (int)($request->sub_kuliah ?? 0);
            $jumlah_umum  = (int)($request->jumlah_umum ?? 0);
            $jumlah_asing = (int)($request->jumlah_asing ?? 0);

            $sub_tk = (int)($request->sub_tk ?? 0);
            $sub_sd = (int)($request->sub_sd ?? 0);
            $sub_smp = (int)($request->sub_smp ?? 0);
            $sub_sma = (int)($request->sub_sma ?? 0);
            $sub_kuliah = (int)($request->sub_kuliah ?? 0);
        }

        $total_harga = ($jumlah_pelajar * 3000) + ($jumlah_umum * 5000) + ($jumlah_asing * 25000);

        if ($total_harga <= 0) {
            return back()->with('error', 'Minimal ada 1 pengunjung!');
        }

        // 3. SIMPAN SEMENTARA DI SESSION (INI YANG BARU!)
        session([
            'pending_booking' => [
                'form_data' => $request->except('_token'),
                'calculated' => [
                    'total_harga'     => $total_harga,
                    'jumlah_pelajar'  => $jumlah_pelajar,
                    'jumlah_umum'     => $jumlah_umum,
                    'jumlah_asing'    => $jumlah_asing,
                    'sub_tk'          => $sub_tk,
                    'sub_sd'          => $sub_sd,
                    'sub_smp'         => $sub_smp,
                    'sub_sma'         => $sub_sma,
                    'sub_kuliah'      => $sub_kuliah,
                ]
            ]
        ]);

        // 4. REDIRECT KE HALAMAN REVIEW PEMBAYARAN
        return redirect()->route('payment.review');
    }
}