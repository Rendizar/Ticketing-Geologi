<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Analitik sederhana dari studi kasus
        $kunjungan_hari_ini = Booking::whereDate('tanggal_kunjungan', today())->count();
        
        $total_per_kategori = Booking::select(
            DB::raw('SUM(jumlah_pelajar) as pelajar'),
            DB::raw('SUM(jumlah_umum) as umum'),
            DB::raw('SUM(jumlah_asing) as asing')
        )->first();

        $sub_pelajar = Booking::select(
            DB::raw('SUM(sub_tk) as tk')
        )->first();

        $per_propinsi = Booking::groupBy('kecamatan_provinsi')
            ->select('kecamatan_provinsi', 
                DB::raw('SUM(jumlah_pelajar + jumlah_umum + jumlah_asing) as total'))
            ->get();

        // Forecasting sederhana (average harian)
        $first_booking = Booking::min('created_at');
        $avg_daily = $first_booking ? 
            Booking::count() / (now()->diffInDays($first_booking) + 1) : 
            0;

        return view('admin.dashboard', compact(
            'kunjungan_hari_ini',
            'total_per_kategori',
            'sub_pelajar',
            'per_propinsi',
            'avg_daily'
        ));
    }
    public function login(Request $request) {
        if ($request->isMethod('get')) {
        return view('admin.login');  // Tampilkan form login (buat view di resources/views/admin/login.blade.php)
    }

        $admin = Admin::where('nama', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password) && $admin->status_aktif) {
            $admin->update(['terakhir_login' => now()]);
            // Set session atau token (asumsi session-based)
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['Invalid credentials']);
    }

    public function dashboard() 
    {
        return $this->index();
    }
}
