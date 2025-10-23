<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function login(Request $request) {
        if ($request->isMethod('get')) {
        return view('admin.login');  // Tampilkan form login (buat view di resources/views/admin/login.blade.php)
    }

        $admin = Admin::where('nama', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password) && $admin->status_aktif) {
            $admin->update(['terakhir_login' => now()]);
            // Set session atau token (asumsi session-based)
            session(['admin_logged_in' => true]);
            return redirect('/admin/dashboard');
        }

        return back()->withErrors(['Invalid credentials']);
    }

    public function dashboard() {
        if (!session('admin_logged_in')) abort(403);

        // Analitik sederhana dari studi kasus
        $kunjungan_hari_ini = Booking::whereDate('tanggal_kunjungan', today())->count();
        // Lainnya: Minggu, bulan, total
        $total_per_kategori = Booking::select(
            DB::raw('SUM(jumlah_pelajar) as pelajar'),
            DB::raw('SUM(jumlah_umum) as umum'),
            DB::raw('SUM(jumlah_asing) as asing')
        )->first();

        $sub_pelajar = Booking::select(
            DB::raw('SUM(sub_tk) as tk'),
            // Lainnya...
        )->first();

        $per_propinsi = Booking::groupBy('kecamatan_provinsi')->select('kecamatan_provinsi', DB::raw('SUM(total_pengunjung) as total'))->get();  // Asumsi total_pengunjung di-calculate di query

        // Forecasting sederhana (average harian)
        $avg_daily = Booking::count() / (now()->diffInDays(Booking::min('created_at')) + 1);

        return response()->json([
            'hari_ini' => $kunjungan_hari_ini,
            'kategori' => $total_per_kategori,
            'sub_pelajar' => $sub_pelajar,
            'per_propinsi' => $per_propinsi,
            'forecast_avg_daily' => $avg_daily,
        ]);
    }
}
