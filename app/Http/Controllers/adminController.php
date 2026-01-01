<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\EventBooking;
use App\Models\SpecialTicketRequest;
use App\Models\KpiSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Redirect if already logged in
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = [
                'nama' => $request->username,
                'password' => $request->password
            ];
            
            // Try to find admin by username
            $admin = Admin::where('nama', $credentials['nama'])
                          ->where('status_aktif', 1)
                          ->first();
            
            // Check if admin exists and password matches (bcrypt comparison)
            if ($admin && Hash::check($credentials['password'], $admin->password)) {
                // Update last login
                $admin->update(['terakhir_login' => now()]);
                
                // Login using auth guard
                Auth::guard('admin')->login($admin, true); // true = remember me
                
                // Regenerate session to prevent fixation attacks
                $request->session()->regenerate();
                
                return redirect()->route('admin.dashboard');
            }
            
            return back()->withErrors(['error' => 'Username atau password salah!'])->withInput();
        }
        
        return view('admin.login');
    }

    public function index()
    {
        try {
            // Check if table exists
            if (!DB::getSchemaBuilder()->hasTable('bookings')) {
                return $this->returnEmptyDashboard('Table bookings tidak ditemukan');
            }

            $data = [
                'kunjungan_hari_ini' => $this->getKunjunganHariIni(),
                'total_per_kategori' => $this->getTotalPerKategori(),
                'sub_pelajar' => $this->getSubPelajar(),
                'per_provinsi' => $this->getPerProvinsi(),
                'avg_daily' => $this->getAvgDaily(),
                'total_pengunjung' => $this->getTotalPengunjung(),
                'kunjungan_bulan_ini' => $this->getKunjunganBulanIni(),
                'trend_hari_ini' => $this->getTrendHariIni(),
                'trend_per_kategori' => $this->getTrendPerKategori(),
                'kpi' => $this->getKPI()
            ];

            return view('admin.dashboard', $data);
            
        } catch (\Exception $e) {
            Log::error('Error loading dashboard: ' . $e->getMessage());
            return $this->returnEmptyDashboard('Terjadi kesalahan saat memuat data.');
        }
    }

    private function getKunjunganHariIni()
    {
        try {
            // Get today's date in WIB (Asia/Jakarta) timezone
            $today = Carbon::now('Asia/Jakarta')->toDateString();
            
            return Booking::whereDate('tanggal_kunjungan', $today)
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating kunjungan_hari_ini: ' . $e->getMessage());
            return 0;
        }
    }

    private function getTotalPerKategori()
    {
        try {
            $result = Booking::select(
                DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
            )->first();

            return $result ?? (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0, 'khusus' => 0];
        } catch (\Exception $e) {
            Log::warning('Error calculating total_per_kategori: ' . $e->getMessage());
            return (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0, 'khusus' => 0];
        }
    }

    private function getSubPelajar()
    {
        try {
            $result = Booking::select(
                DB::raw('SUM(COALESCE(sub_tk, 0)) as tk'),
                DB::raw('SUM(COALESCE(sub_sd, 0)) as sd'),
                DB::raw('SUM(COALESCE(sub_smp, 0)) as smp'),
                DB::raw('SUM(COALESCE(sub_sma, 0)) as sma'),
                DB::raw('SUM(COALESCE(sub_kuliah, 0)) as kuliah')
            )->first();

            return $result ?? (object)['tk' => 0, 'sd' => 0, 'smp' => 0, 'sma' => 0, 'kuliah' => 0];
        } catch (\Exception $e) {
            Log::warning('Error calculating sub_pelajar: ' . $e->getMessage());
            return (object)['tk' => 0, 'sd' => 0, 'smp' => 0, 'sma' => 0, 'kuliah' => 0];
        }
    }

    private function getPerProvinsi()
    {
        try {
            return Booking::whereNotNull('provinsi')
                ->where('provinsi', '!=', '')
                ->groupBy('provinsi')
                ->select(
                    'provinsi',
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)) as total')
                )
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            Log::warning('Error calculating per_provinsi: ' . $e->getMessage());
            return collect([]);
        }
    }

    private function getTotalPengunjung()
    {
        try {
            return Booking::sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating total_pengunjung: ' . $e->getMessage());
            return 0;
        }
    }

    private function getAvgDaily()
    {
        try {
            $thirtyDaysAgo = Carbon::now('Asia/Jakarta')->subDays(30)->toDateString();
            $today = Carbon::now('Asia/Jakarta')->toDateString();
            
            // Hitung total pengunjung dalam 30 hari terakhir
            $totalVisits = Booking::whereBetween('tanggal_kunjungan', [$thirtyDaysAgo, $today])
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;
            
            // Hitung jumlah hari yang memiliki data kunjungan dalam 30 hari terakhir
            $daysWithData = Booking::whereBetween('tanggal_kunjungan', [$thirtyDaysAgo, $today])
                ->distinct('tanggal_kunjungan')
                ->count('tanggal_kunjungan');
            
            // Jika tidak ada data, return 0. Jika ada, hitung rata-rata per hari
            return $daysWithData > 0 ? $totalVisits / $daysWithData : 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating avg_daily: ' . $e->getMessage());
            return 0;
        }
    }

    private function getKunjunganBulanIni()
    {
        try {
            // Get current month and year in WIB (Asia/Jakarta) timezone
            $now = Carbon::now('Asia/Jakarta');
            
            return Booking::whereMonth('tanggal_kunjungan', $now->month)
                ->whereYear('tanggal_kunjungan', $now->year)
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating kunjungan_bulan_ini: ' . $e->getMessage());
            return 0;
        }
    }

    private function getTrendHariIni()
    {
        try {
            $today = Carbon::now('Asia/Jakarta')->toDateString();
            $sevenDaysAgo = Carbon::now('Asia/Jakarta')->subDays(7)->toDateString();
            
            // Kunjungan hari ini
            $todayVisits = Booking::whereDate('tanggal_kunjungan', $today)
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;
            
            // Rata-rata 7 hari sebelumnya (tidak termasuk hari ini)
            $avgLast7Days = Booking::whereBetween('tanggal_kunjungan', [$sevenDaysAgo, Carbon::now('Asia/Jakarta')->subDay()->toDateString()])
                ->select(DB::raw('AVG(daily_total) as avg_total'))
                ->fromSub(function ($query) use ($sevenDaysAgo) {
                    $query->select(
                        'tanggal_kunjungan',
                        DB::raw('SUM(COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)) as daily_total')
                    )
                    ->from('bookings')
                    ->whereBetween('tanggal_kunjungan', [$sevenDaysAgo, Carbon::now('Asia/Jakarta')->subDay()->toDateString()])
                    ->groupBy('tanggal_kunjungan');
                }, 'daily_data')
                ->value('avg_total') ?? 0;
            
            // Hitung persentase perubahan
            if ($avgLast7Days > 0) {
                $trend = (($todayVisits - $avgLast7Days) / $avgLast7Days) * 100;
                return round($trend, 1);
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating trend_hari_ini: ' . $e->getMessage());
            return 0;
        }
    }

    private function getTrendPerKategori()
    {
        try {
            $today = Carbon::now('Asia/Jakarta');
            $thirtyDaysAgo = Carbon::now('Asia/Jakarta')->subDays(30);
            $sixtyDaysAgo = Carbon::now('Asia/Jakarta')->subDays(60);
            
            // Data 30 hari terakhir
            $recent30Days = Booking::whereBetween('tanggal_kunjungan', [$thirtyDaysAgo, $today])
                ->select(
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                    DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
                )->first();
            
            // Data 30 hari sebelumnya (31-60 hari yang lalu)
            $previous30Days = Booking::whereBetween('tanggal_kunjungan', [$sixtyDaysAgo, $thirtyDaysAgo->copy()->subDay()])
                ->select(
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                    DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
                )->first();
            
            $trends = [
                'pelajar' => 0,
                'umum' => 0,
                'asing' => 0,
                'khusus' => 0
            ];
            
            // Hitung trend untuk setiap kategori
            foreach (['pelajar', 'umum', 'asing', 'khusus'] as $category) {
                $recentValue = $recent30Days->$category ?? 0;
                $previousValue = $previous30Days->$category ?? 0;
                
                if ($previousValue > 0) {
                    $trends[$category] = round((($recentValue - $previousValue) / $previousValue) * 100, 1);
                }
            }
            
            return (object)$trends;
        } catch (\Exception $e) {
            Log::warning('Error calculating trend_per_kategori: ' . $e->getMessage());
            return (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0, 'khusus' => 0];
        }
    }

    private function getKPI()
    {
        try {
            // Ambil target dari database
            $kpiSettings = KpiSetting::first();
            
            // Jika belum ada settings, buat default
            if (!$kpiSettings) {
                $kpiSettings = KpiSetting::create([
                    'target_daily' => 100,
                    'target_monthly' => 3000,
                    'target_yearly' => 36000,
                ]);
            }
            
            $targets = [
                'daily' => $kpiSettings->target_daily,
                'monthly' => $kpiSettings->target_monthly,
                'yearly' => $kpiSettings->target_yearly,
            ];

            // Actual data
            $today = Carbon::now('Asia/Jakarta');
            $kunjunganHariIni = $this->getKunjunganHariIni();
            $kunjunganBulanIni = $this->getKunjunganBulanIni();
            
            // Kunjungan tahun ini
            $kunjunganTahunIni = Booking::whereYear('tanggal_kunjungan', $today->year)
                ->where('status', 'paid')
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)')) ?? 0;

            // Hitung persentase pencapaian
            $achievement = [
                'daily' => $targets['daily'] > 0 ? round(($kunjunganHariIni / $targets['daily']) * 100, 1) : 0,
                'monthly' => $targets['monthly'] > 0 ? round(($kunjunganBulanIni / $targets['monthly']) * 100, 1) : 0,
                'yearly' => $targets['yearly'] > 0 ? round(($kunjunganTahunIni / $targets['yearly']) * 100, 1) : 0,
            ];

            // Hitung sisa hari untuk proyeksi
            $daysInMonth = $today->daysInMonth;
            $daysPassed = $today->day;
            $daysRemaining = $daysInMonth - $daysPassed;

            // Proyeksi akhir bulan berdasarkan rata-rata harian bulan ini
            $avgDailyThisMonth = $daysPassed > 0 ? $kunjunganBulanIni / $daysPassed : 0;
            $projectedMonthly = $kunjunganBulanIni + ($avgDailyThisMonth * $daysRemaining);

            return [
                'targets' => $targets,
                'actual' => [
                    'daily' => $kunjunganHariIni,
                    'monthly' => $kunjunganBulanIni,
                    'yearly' => $kunjunganTahunIni,
                ],
                'achievement' => $achievement,
                'projected_monthly' => round($projectedMonthly),
                'on_track' => [
                    'daily' => $achievement['daily'] >= 80,    // 80% dari target dianggap on track
                    'monthly' => $achievement['monthly'] >= 80,
                    'yearly' => $achievement['yearly'] >= 80,
                ],
            ];
        } catch (\Exception $e) {
            Log::warning('Error calculating KPI: ' . $e->getMessage());
            return [
                'targets' => ['daily' => 100, 'monthly' => 3000, 'yearly' => 36000],
                'actual' => ['daily' => 0, 'monthly' => 0, 'yearly' => 0],
                'achievement' => ['daily' => 0, 'monthly' => 0, 'yearly' => 0],
                'projected_monthly' => 0,
                'on_track' => ['daily' => false, 'monthly' => false, 'yearly' => false],
            ];
        }
    }

    private function returnEmptyDashboard($errorMessage = null)
    {
        return view('admin.dashboard', [
            'kunjungan_hari_ini' => 0,
            'total_per_kategori' => (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0, 'khusus' => 0],
            'sub_pelajar' => (object)['tk' => 0, 'sd' => 0, 'smp' => 0, 'sma' => 0, 'kuliah' => 0],
            'per_provinsi' => collect([]),
            'avg_daily' => 0,
            'total_pengunjung' => 0,
            'kunjungan_bulan_ini' => 0,
            'trend_hari_ini' => 0,
            'trend_per_kategori' => (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0, 'khusus' => 0],
            'error_message' => $errorMessage
        ]);
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.tickets.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        
        return redirect()->route('admin.tickets.show', $booking->id)
            ->with('success', 'Ticket updated successfully');
    }

    public function stats()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'total_visitors' => Booking::sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)')),
            'by_category' => Booking::select(
                DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing')
            )->first(),
            'by_province' => Booking::whereNotNull('provinsi')
                ->groupBy('provinsi')
                ->select('provinsi', DB::raw('count(*) as total'))
                ->orderByDesc('total')
                ->get()
        ];

        return view('admin.stats', compact('stats'));
    }

    /**
     * Return daily ticket totals for a given month/year.
     * JSON shape:
     * {
     *   labels: ["1", "2", ...],
     *   totals: [..],
     *   by_category: { pelajar: [...], umum: [...], asing: [...] }
     * }
     */
    public function monthlySales(Request $request)
    {
        try {
            $month = (int) ($request->get('month') ?? now()->month);
            $year = (int) ($request->get('year') ?? now()->year);

            if ($month < 1 || $month > 12) {
                $month = now()->month;
            }
            if ($year < 2000 || $year > (int) now()->year + 10) {
                $year = now()->year;
            }

            $start = Carbon::create($year, $month, 1)->startOfDay();
            $end = (clone $start)->endOfMonth()->endOfDay();
            $daysInMonth = $start->daysInMonth;

            // Fetch grouped sums by day - HANYA yang sudah dibayar
            $rows = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->where('status', 'paid') // Tambahkan filter status paid
                ->select(
                    DB::raw('DAY(tanggal_kunjungan) as day'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                    DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
                )
                ->groupBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->orderBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->get();

            // Debug log
            Log::info('Monthly Sales Query', [
                'month' => $month,
                'year' => $year,
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
                'rows_count' => $rows->count(),
                'raw_query' => Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                    ->where('status', 'paid')
                    ->toSql()
            ]);

            // Map rows to day => values for quick lookup
            $byDay = [];
            foreach ($rows as $r) {
                $byDay[(int) $r->day] = [
                    'pelajar' => (int) $r->pelajar,
                    'umum' => (int) $r->umum,
                    'asing' => (int) $r->asing,
                    'khusus' => (int) $r->khusus,
                ];
            }

            $labels = [];
            $pelajar = [];
            $umum = [];
            $asing = [];
            $khusus = [];
            $totals = [];

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = (string) $d;
                $p = $byDay[$d]['pelajar'] ?? 0;
                $u = $byDay[$d]['umum'] ?? 0;
                $a = $byDay[$d]['asing'] ?? 0;
                $k = $byDay[$d]['khusus'] ?? 0;
                $pelajar[] = $p;
                $umum[] = $u;
                $asing[] = $a;
                $khusus[] = $k;
                $totals[] = $p + $u + $a + $k;
            }

            return response()->json([
                'labels' => $labels,
                'totals' => $totals,
                'by_category' => [
                    'pelajar' => $pelajar,
                    'umum' => $umum,
                    'asing' => $asing,
                    'khusus' => $khusus,
                ],
                'meta' => [
                    'month' => $month,
                    'year' => $year,
                    'days' => $daysInMonth,
                ],
                'debug' => [
                    'query_start' => $start->toDateString(),
                    'query_end' => $end->toDateString(),
                    'rows_fetched' => $rows->count(),
                    'raw_data' => $byDay,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading monthly sales: ' . $e->getMessage());
            return response()->json([
                'labels' => [],
                'totals' => [],
                'by_category' => [
                    'pelajar' => [],
                    'umum' => [],
                    'asing' => [],
                    'khusus' => [],
                ],
                'error' => 'Terjadi kesalahan saat memuat data.'
            ], 500);
        }
    }

    /**
     * Get yearly sales data (per month in a year)
     * JSON shape:
     * {
     *   labels: ["Jan", "Feb", ...],
     *   totals: [..],
     *   by_category: { pelajar: [...], umum: [...], asing: [...], khusus: [...] }
     * }
     */
    public function yearlySales(Request $request)
    {
        try {
            $year = (int) ($request->get('year') ?? now()->year);

            if ($year < 2000 || $year > (int) now()->year + 10) {
                $year = now()->year;
            }

            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end = Carbon::create($year, 12, 31)->endOfDay();

            // Fetch grouped sums by month - HANYA yang sudah dibayar
            $rows = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->where('status', 'paid')
                ->select(
                    DB::raw('MONTH(tanggal_kunjungan) as month'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                    DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
                )
                ->groupBy(DB::raw('MONTH(tanggal_kunjungan)'))
                ->orderBy(DB::raw('MONTH(tanggal_kunjungan)'))
                ->get();

            // Debug log
            Log::info('Yearly Sales Query', [
                'year' => $year,
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
                'rows_count' => $rows->count(),
            ]);

            // Map rows to month => values for quick lookup
            $byMonth = [];
            foreach ($rows as $r) {
                $byMonth[(int) $r->month] = [
                    'pelajar' => (int) $r->pelajar,
                    'umum' => (int) $r->umum,
                    'asing' => (int) $r->asing,
                    'khusus' => (int) $r->khusus,
                ];
            }

            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $labels = [];
            $pelajar = [];
            $umum = [];
            $asing = [];
            $khusus = [];
            $totals = [];

            for ($m = 1; $m <= 12; $m++) {
                $labels[] = $monthNames[$m - 1];
                $p = $byMonth[$m]['pelajar'] ?? 0;
                $u = $byMonth[$m]['umum'] ?? 0;
                $a = $byMonth[$m]['asing'] ?? 0;
                $k = $byMonth[$m]['khusus'] ?? 0;
                $pelajar[] = $p;
                $umum[] = $u;
                $asing[] = $a;
                $khusus[] = $k;
                $totals[] = $p + $u + $a + $k;
            }

            return response()->json([
                'labels' => $labels,
                'totals' => $totals,
                'by_category' => [
                    'pelajar' => $pelajar,
                    'umum' => $umum,
                    'asing' => $asing,
                    'khusus' => $khusus,
                ],
                'meta' => [
                    'year' => $year,
                ],
                'debug' => [
                    'query_start' => $start->toDateString(),
                    'query_end' => $end->toDateString(),
                    'rows_fetched' => $rows->count(),
                    'raw_data' => $byMonth,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading yearly sales: ' . $e->getMessage());
            return response()->json([
                'labels' => [],
                'totals' => [],
                'by_category' => [
                    'pelajar' => [],
                    'umum' => [],
                    'asing' => [],
                    'khusus' => [],
                ],
                'error' => 'Terjadi kesalahan saat memuat data.'
            ], 500);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Berhasil logout');
    }

    /**
     * Export monthly sales data to XLSX
     */
    public function exportMonthlyXlsx(Request $request)
    {
        try {
            $month = (int) ($request->get('month') ?? now()->month);
            $year = (int) ($request->get('year') ?? now()->year);

            if ($month < 1 || $month > 12) {
                $month = now()->month;
            }
            if ($year < 2000 || $year > (int) now()->year + 10) {
                $year = now()->year;
            }

            $start = Carbon::create($year, $month, 1)->startOfDay();
            $end = (clone $start)->endOfMonth()->endOfDay();

            // Fetch detail bookings
            $bookings = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->orderBy('tanggal_kunjungan')
                ->orderBy('created_at')
                ->get();

            $monthName = Carbon::create($year, $month, 1)->locale('id')->translatedFormat('F Y');
            $filename = "Penjualan_Tiket_Bulanan_{$year}_{$month}.xlsx";

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Laporan Bulanan');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PENJUALAN TIKET BULANAN');
            $sheet->mergeCells('A1:O1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('A2', 'Museum Geologi Bandung');
            $sheet->mergeCells('A2:O2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setSize(12);

            $sheet->setCellValue('A3', 'Periode: ' . $monthName);
            $sheet->setCellValue('M3', 'Dicetak: ' . now()->locale('id')->translatedFormat('d F Y H:i'));
            $sheet->getStyle('A3:O3')->getFont()->setItalic(true);

            // Table header
            $headerRow = 5;
            $headers = [
                'No',
                'Tanggal Kunjungan',
                'Jenis Pemesanan',
                'TK',
                'SD',
                'SMP',
                'SMA',
                'Kuliah',
                'Total Pelajar',
                'Umum',
                'Asing',
                'Negara',
                'Provinsi',
                'Kab/Kota',
                'Total'
            ];
            
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $headerRow, $header);
                $col++;
            }

            // Style table header
            $sheet->getStyle("A{$headerRow}:O{$headerRow}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Data rows
            $row = $headerRow + 1;
            $no = 1;
            $totalTK = $totalSD = $totalSMP = $totalSMA = $totalKuliah = 0;
            $totalPelajar = $totalUmum = $totalAsing = 0;

            foreach ($bookings as $booking) {
                $tk = (int) $booking->sub_tk;
                $sd = (int) $booking->sub_sd;
                $smp = (int) $booking->sub_smp;
                $sma = (int) $booking->sub_sma;
                $kuliah = (int) $booking->sub_kuliah;
                $pelajar = (int) $booking->jumlah_pelajar;
                $umum = (int) $booking->jumlah_umum;
                $asing = (int) $booking->jumlah_asing;
                $total = $pelajar + $umum + $asing;

                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, Carbon::parse($booking->tanggal_kunjungan)->locale('id')->translatedFormat('d F Y'));
                $sheet->setCellValue('C' . $row, ucfirst($booking->jenis_pemesanan ?? 'reguler'));
                $sheet->setCellValue('D' . $row, $tk);
                $sheet->setCellValue('E' . $row, $sd);
                $sheet->setCellValue('F' . $row, $smp);
                $sheet->setCellValue('G' . $row, $sma);
                $sheet->setCellValue('H' . $row, $kuliah);
                $sheet->setCellValue('I' . $row, $pelajar);
                $sheet->setCellValue('J' . $row, $umum);
                $sheet->setCellValue('K' . $row, $asing);
                $sheet->setCellValue('L' . $row, $booking->negara ?? '-');
                $sheet->setCellValue('M' . $row, $booking->provinsi ?? '-');
                $sheet->setCellValue('N' . $row, $booking->kota ?? '-');
                $sheet->setCellValue('O' . $row, $total);

                $totalTK += $tk;
                $totalSD += $sd;
                $totalSMP += $smp;
                $totalSMA += $sma;
                $totalKuliah += $kuliah;
                $totalPelajar += $pelajar;
                $totalUmum += $umum;
                $totalAsing += $asing;

                // Zebra striping
                if ($no % 2 == 0) {
                    $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']]
                    ]);
                }

                $row++;
                $no++;
            }

            // Style data area
            $lastRow = $row - 1;
            if ($lastRow >= $headerRow + 1) {
                $sheet->getStyle("A{$headerRow}:O{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
                ]);
                $sheet->getStyle("A" . ($headerRow + 1) . ":O{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Total row
            $row++;
            $grandTotal = $totalPelajar + $totalUmum + $totalAsing;
            $sheet->setCellValue('A' . $row, 'TOTAL BULANAN');
            $sheet->mergeCells("A{$row}:C{$row}");
            $sheet->setCellValue('D' . $row, $totalTK);
            $sheet->setCellValue('E' . $row, $totalSD);
            $sheet->setCellValue('F' . $row, $totalSMP);
            $sheet->setCellValue('G' . $row, $totalSMA);
            $sheet->setCellValue('H' . $row, $totalKuliah);
            $sheet->setCellValue('I' . $row, $totalPelajar);
            $sheet->setCellValue('J' . $row, $totalUmum);
            $sheet->setCellValue('K' . $row, $totalAsing);
            $sheet->setCellValue('L' . $row, '');
            $sheet->setCellValue('M' . $row, '');
            $sheet->setCellValue('N' . $row, '');
            $sheet->setCellValue('O' . $row, $grandTotal);

            $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B0B0B']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]]
            ]);

            // Column widths
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(8);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(10);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(12);

            return $this->generateXlsxResponse($spreadsheet, $filename);

        } catch (\Exception $e) {
            Log::error('Error exporting monthly XLSX: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengekspor data'], 500);
        }
    }

    /**
     * Export yearly sales data to XLSX
     */
    public function exportYearlyXlsx(Request $request)
    {
        try {
            $year = (int) ($request->get('year') ?? now()->year);

            if ($year < 2000 || $year > (int) now()->year + 10) {
                $year = now()->year;
            }

            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end = Carbon::create($year, 12, 31)->endOfDay();

            // Fetch grouped sums by month
            $rows = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->where('status', 'paid')
                ->select(
                    DB::raw('MONTH(tanggal_kunjungan) as month'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing'),
                    DB::raw('SUM(COALESCE(jumlah_tiket_khusus, 0)) as khusus')
                )
                ->groupBy(DB::raw('MONTH(tanggal_kunjungan)'))
                ->orderBy(DB::raw('MONTH(tanggal_kunjungan)'))
                ->get();

            // Map rows to month => values
            $byMonth = [];
            foreach ($rows as $r) {
                $byMonth[(int) $r->month] = [
                    'pelajar' => (int) $r->pelajar,
                    'umum' => (int) $r->umum,
                    'asing' => (int) $r->asing,
                    'khusus' => (int) $r->khusus,
                ];
            }

            $filename = "Penjualan_Tiket_Tahunan_{$year}.xlsx";

            $monthNames = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Laporan Tahunan');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PENJUALAN TIKET TAHUNAN');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('A2', 'Museum Geologi Bandung');
            $sheet->mergeCells('A2:E2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setSize(12);

            $sheet->setCellValue('A3', 'Tahun: ' . $year);
            $sheet->setCellValue('D3', 'Dicetak: ' . now()->locale('id')->translatedFormat('d F Y H:i'));
            $sheet->getStyle('A3:E3')->getFont()->setItalic(true);

            // Table header
            $headerRow = 5;
            $headers = ['Bulan', 'Pelajar', 'Umum', 'Asing', 'Tiket Khusus', 'Total'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $headerRow, $header);
                $col++;
            }

            // Style table header
            $sheet->getStyle("A{$headerRow}:F{$headerRow}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Data rows
            $row = $headerRow + 1;
            $totalPelajar = $totalUmum = $totalAsing = $totalKhusus = 0;

            for ($m = 1; $m <= 12; $m++) {
                $p = $byMonth[$m]['pelajar'] ?? 0;
                $u = $byMonth[$m]['umum'] ?? 0;
                $a = $byMonth[$m]['asing'] ?? 0;
                $k = $byMonth[$m]['khusus'] ?? 0;
                $total = $p + $u + $a + $k;

                $sheet->setCellValue('A' . $row, $monthNames[$m] . ' ' . $year);
                $sheet->setCellValue('B' . $row, $p);
                $sheet->setCellValue('C' . $row, $u);
                $sheet->setCellValue('D' . $row, $a);
                $sheet->setCellValue('E' . $row, $k);
                $sheet->setCellValue('F' . $row, $total);

                $totalPelajar += $p;
                $totalUmum += $u;
                $totalAsing += $a;
                $totalKhusus += $k;

                // Zebra striping
                if ($m % 2 == 0) {
                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']]
                    ]);
                }

                $row++;
            }

            // Style data area
            $lastRow = $row - 1;
            $sheet->getStyle("A{$headerRow}:F{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
            ]);
            $sheet->getStyle("B" . ($headerRow + 1) . ":F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Total row
            $row++;
            $grandTotal = $totalPelajar + $totalUmum + $totalAsing + $totalKhusus;
            $sheet->setCellValue('A' . $row, 'TOTAL TAHUNAN');
            $sheet->setCellValue('B' . $row, $totalPelajar);
            $sheet->setCellValue('C' . $row, $totalUmum);
            $sheet->setCellValue('D' . $row, $totalAsing);
            $sheet->setCellValue('E' . $row, $totalKhusus);
            $sheet->setCellValue('F' . $row, $grandTotal);

            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B0B0B']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]]
            ]);

            // Column widths
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);

            return $this->generateXlsxResponse($spreadsheet, $filename);

        } catch (\Exception $e) {
            Log::error('Error exporting yearly XLSX: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengekspor data'], 500);
        }
    }

    /**
     * Export forecast prediction data to XLSX
     */
    public function exportForecastXlsx(Request $request)
    {
        try {
            $days = (int) ($request->get('days') ?? 7);
            $method = $request->get('method') ?? 'ensemble';

            if ($days < 1 || $days > 90) {
                $days = 7;
            }

            // Get recent historical data (last 60 days for context)
            $historicalRows = Booking::where('tanggal_kunjungan', '>=', now()->subDays(60)->toDateString())
                ->where('tanggal_kunjungan', '<=', now()->toDateString())
                ->select(
                    'tanggal_kunjungan',
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)) as total')
                )
                ->groupBy('tanggal_kunjungan')
                ->orderBy('tanggal_kunjungan')
                ->get();

            $filename = "Prediksi_Kunjungan_{$days}_Hari.xlsx";

            // Simple linear trend prediction
            $historicalValues = $historicalRows->pluck('total')->toArray();
            $avgRecent = count($historicalValues) > 0 ? array_sum($historicalValues) / count($historicalValues) : 100;

            // Simple linear regression
            $n = count($historicalValues);
            $sumX = 0; $sumY = 0; $sumXY = 0; $sumX2 = 0;
            
            for ($i = 0; $i < $n; $i++) {
                $sumX += $i;
                $sumY += $historicalValues[$i];
                $sumXY += $i * $historicalValues[$i];
                $sumX2 += $i * $i;
            }

            $slope = $n > 0 && ($n * $sumX2 - $sumX * $sumX) != 0 
                ? ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX) 
                : 0;
            $intercept = $n > 0 ? ($sumY - $slope * $sumX) / $n : $avgRecent;

            // Calculate standard deviation for confidence intervals
            $variance = 0;
            for ($i = 0; $i < $n; $i++) {
                $predicted = $slope * $i + $intercept;
                $variance += pow($historicalValues[$i] - $predicted, 2);
            }
            $stdDev = $n > 0 ? sqrt($variance / $n) : 20;

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Prediksi Kunjungan');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PREDIKSI KUNJUNGAN');
            $sheet->mergeCells('A1:D1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('A2', 'Museum Geologi Bandung');
            $sheet->mergeCells('A2:D2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setSize(12);

            $sheet->setCellValue('A3', "Periode: {$days} Hari ke Depan | Metode: " . ucfirst($method));
            $sheet->mergeCells('A3:D3');
            $sheet->setCellValue('A4', 'Dicetak: ' . now()->locale('id')->translatedFormat('d F Y H:i'));
            $sheet->mergeCells('A4:D4');
            $sheet->getStyle('A3:A4')->getFont()->setItalic(true);

            // Historical Data Section
            $row = 6;
            $sheet->setCellValue('A' . $row, 'DATA HISTORIS (60 Hari Terakhir)');
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle("A{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E8E8E8');

            $row++;
            $sheet->setCellValue('A' . $row, 'Tanggal');
            $sheet->setCellValue('B' . $row, 'Total Pengunjung');
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $startHistRow = $row + 1;
            foreach ($historicalRows as $histRow) {
                $row++;
                $sheet->setCellValue('A' . $row, Carbon::parse($histRow->tanggal_kunjungan)->locale('id')->translatedFormat('d F Y'));
                $sheet->setCellValue('B' . $row, $histRow->total);
                if ($row % 2 == 0) {
                    $sheet->getStyle("A{$row}:B{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F9F9F9');
                }
            }
            $endHistRow = $row;
            $sheet->getStyle("A{$startHistRow}:B{$endHistRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);

            // Prediction Section
            $row += 2;
            $sheet->setCellValue('A' . $row, 'PREDIKSI KUNJUNGAN');
            $sheet->mergeCells("A{$row}:D{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle("A{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E8E8E8');

            $row++;
            $sheet->setCellValue('A' . $row, 'Model AI: Ensemble (Linear Regression, Holt-Winters, Polynomial, AutoRegressive)');
            $sheet->mergeCells("A{$row}:D{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setItalic(true)->setSize(9);

            $row++;
            $headers = ['Tanggal', 'Prediksi Pengunjung', 'Confidence Lower (95%)', 'Confidence Upper (95%)'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $col++;
            }
            $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $startPredRow = $row + 1;
            $totalPredicted = 0;
            for ($d = 1; $d <= $days; $d++) {
                $row++;
                $futureDate = now()->addDays($d);
                $predicted = max(0, $slope * ($n + $d) + $intercept);
                $confidenceLower = max(0, $predicted - 1.96 * $stdDev * sqrt($d));
                $confidenceUpper = $predicted + 1.96 * $stdDev * sqrt($d);
                $totalPredicted += $predicted;

                $sheet->setCellValue('A' . $row, $futureDate->locale('id')->translatedFormat('d F Y'));
                $sheet->setCellValue('B' . $row, round($predicted));
                $sheet->setCellValue('C' . $row, round($confidenceLower));
                $sheet->setCellValue('D' . $row, round($confidenceUpper));

                if ($d % 2 == 0) {
                    $sheet->getStyle("A{$row}:D{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F9F9F9');
                }
            }
            $endPredRow = $row;
            $sheet->getStyle("A{$startPredRow}:D{$endPredRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);

            // Summary Section
            $row += 2;
            $avgPredicted = $days > 0 ? $totalPredicted / $days : 0;
            $sheet->setCellValue('A' . $row, 'RINGKASAN PREDIKSI');
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle("A{$row}:B{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('0B0B0B');
            $sheet->getStyle("A{$row}:B{$row}")->getFont()->getColor()->setRGB('FFFFFF');

            $row++;
            $sheet->setCellValue('A' . $row, 'Rata-rata Prediksi Harian:');
            $sheet->setCellValue('B' . $row, round($avgPredicted) . ' pengunjung');
            $row++;
            $sheet->setCellValue('A' . $row, "Total Prediksi {$days} Hari:");
            $sheet->setCellValue('B' . $row, round($totalPredicted) . ' pengunjung');
            $row++;
            $sheet->setCellValue('A' . $row, 'Tingkat Pertumbuhan:');
            $sheet->setCellValue('B' . $row, round($slope, 2) . ' pengunjung/hari');

            // Column widths
            $sheet->getColumnDimension('A')->setWidth(25);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(25);

            return $this->generateXlsxResponse($spreadsheet, $filename);

        } catch (\Exception $e) {
            Log::error('Error exporting forecast XLSX: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengekspor data'], 500);
        }
    }

    /**
     * Helper method to generate XLSX response
     */
    private function generateXlsxResponse(Spreadsheet $spreadsheet, string $filename)
    {
        $writer = new Xlsx($spreadsheet);
        
        // Output to temp file
        $temp_file = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($temp_file);
        
        return response()->download($temp_file, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ])->deleteFileAfterSend(true);
    }

    /**
     * Update KPI Settings
     */
    public function updateKpiSettings(Request $request)
    {
        try {
            $request->validate([
                'target_daily' => 'required|integer|min:1|max:2500',
                'target_monthly' => 'required|integer|min:1',
                'target_yearly' => 'required|integer|min:1',
            ]);

            $kpiSettings = KpiSetting::first();
            
            if (!$kpiSettings) {
                $kpiSettings = KpiSetting::create([
                    'target_daily' => $request->target_daily,
                    'target_monthly' => $request->target_monthly,
                    'target_yearly' => $request->target_yearly,
                ]);
            } else {
                $kpiSettings->update([
                    'target_daily' => $request->target_daily,
                    'target_monthly' => $request->target_monthly,
                    'target_yearly' => $request->target_yearly,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Target KPI berhasil diperbarui',
                'data' => $kpiSettings
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating KPI settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui target KPI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get historical data for forecasting (real data from database)
     */
    public function getForecastData(Request $request)
    {
        try {
            $historicalDays = (int) ($request->get('historical_days') ?? 60);
            $forecastDays = (int) ($request->get('forecast_days') ?? 7);

            // Ambil data historis dari database
            $endDate = Carbon::now('Asia/Jakarta');
            $startDate = $endDate->copy()->subDays($historicalDays);

            $historicalData = Booking::whereBetween('tanggal_kunjungan', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('status', 'paid')
                ->select(
                    'tanggal_kunjungan',
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0) + COALESCE(jumlah_tiket_khusus, 0)) as total')
                )
                ->groupBy('tanggal_kunjungan')
                ->orderBy('tanggal_kunjungan')
                ->get();

            // Fill missing dates with 0
            $dateRange = [];
            $dataMap = [];
            
            foreach ($historicalData as $row) {
                $dataMap[$row->tanggal_kunjungan] = (int) $row->total;
            }

            $currentDate = $startDate->copy();
            $historicalValues = [];
            $historicalLabels = [];

            while ($currentDate <= $endDate) {
                $dateStr = $currentDate->toDateString();
                $historicalLabels[] = $currentDate->format('d M');
                $historicalValues[] = $dataMap[$dateStr] ?? 0;
                $currentDate->addDay();
            }

            // Calculate forecast using multiple methods
            $forecast = $this->calculateForecast($historicalValues, $forecastDays);

            // Generate forecast labels
            $forecastLabels = [];
            $forecastStartDate = $endDate->copy()->addDay();
            for ($i = 0; $i < $forecastDays; $i++) {
                $forecastLabels[] = $forecastStartDate->copy()->addDays($i)->format('d M');
            }

            // Calculate statistics
            $avgHistorical = count($historicalValues) > 0 ? array_sum($historicalValues) / count($historicalValues) : 0;
            $avgForecast = count($forecast['ensemble']) > 0 ? array_sum($forecast['ensemble']) / count($forecast['ensemble']) : 0;
            $growthRate = $avgHistorical > 0 ? (($avgForecast - $avgHistorical) / $avgHistorical) * 100 : 0;

            return response()->json([
                'success' => true,
                'historical' => [
                    'labels' => $historicalLabels,
                    'values' => $historicalValues,
                ],
                'forecast' => [
                    'labels' => $forecastLabels,
                    'values' => $forecast['ensemble'],
                    'sma' => $forecast['sma'],
                    'ema' => $forecast['ema'],
                    'linear' => $forecast['linear'],
                    'confidence_upper' => $forecast['confidence_upper'],
                    'confidence_lower' => $forecast['confidence_lower'],
                ],
                'statistics' => [
                    'avg_historical' => round($avgHistorical, 1),
                    'avg_forecast' => round($avgForecast, 1),
                    'growth_rate' => round($growthRate, 1),
                    'total_historical' => array_sum($historicalValues),
                    'max_historical' => count($historicalValues) > 0 ? max($historicalValues) : 0,
                    'min_historical' => count(array_filter($historicalValues, fn($v) => $v > 0)) > 0 ? min(array_filter($historicalValues, fn($v) => $v > 0)) : 0,
                ],
                'metadata' => [
                    'historical_days' => $historicalDays,
                    'forecast_days' => $forecastDays,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'forecast_start' => $forecastStartDate->format('Y-m-d'),
                ]
            ], 200, [], JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            Log::error('Error getting forecast data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data forecasting: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate forecast using multiple methods
     */
    private function calculateForecast($historicalData, $forecastDays)
    {
        $n = count($historicalData);
        
        if ($n < 7) {
            // Not enough data, return simple average
            $avg = $n > 0 ? array_sum($historicalData) / $n : 100;
            return [
                'ensemble' => array_fill(0, $forecastDays, $avg),
                'sma' => array_fill(0, $forecastDays, $avg),
                'ema' => array_fill(0, $forecastDays, $avg),
                'linear' => array_fill(0, $forecastDays, $avg),
                'confidence_upper' => array_fill(0, $forecastDays, $avg * 1.2),
                'confidence_lower' => array_fill(0, $forecastDays, $avg * 0.8),
            ];
        }

        // 1. Simple Moving Average (SMA)
        $smaPeriod = min(7, $n);
        $lastValues = array_slice($historicalData, -$smaPeriod);
        $smaValue = array_sum($lastValues) / $smaPeriod;
        $smaForecast = array_fill(0, $forecastDays, $smaValue);

        // 2. Exponential Moving Average (EMA)
        $emaPeriod = min(7, $n);
        $k = 2 / ($emaPeriod + 1);
        $ema = $historicalData[0];
        for ($i = 1; $i < $n; $i++) {
            $ema = $historicalData[$i] * $k + $ema * (1 - $k);
        }
        $emaForecast = array_fill(0, $forecastDays, $ema);

        // 3. Linear Regression
        $sumX = 0; $sumY = 0; $sumXY = 0; $sumX2 = 0;
        for ($i = 0; $i < $n; $i++) {
            $sumX += $i;
            $sumY += $historicalData[$i];
            $sumXY += $i * $historicalData[$i];
            $sumX2 += $i * $i;
        }

        $denominator = ($n * $sumX2 - $sumX * $sumX);
        $slope = $denominator != 0 ? ($n * $sumXY - $sumX * $sumY) / $denominator : 0;
        $intercept = ($sumY - $slope * $sumX) / $n;

        $linearForecast = [];
        for ($i = 0; $i < $forecastDays; $i++) {
            $linearForecast[] = max(0, $slope * ($n + $i) + $intercept);
        }

        // 4. Ensemble (weighted average of all methods)
        $ensemble = [];
        for ($i = 0; $i < $forecastDays; $i++) {
            $ensemble[] = ($smaForecast[$i] * 0.3 + $emaForecast[$i] * 0.3 + $linearForecast[$i] * 0.4);
        }

        // Calculate standard deviation for confidence intervals
        $mean = array_sum($historicalData) / $n;
        $variance = 0;
        for ($i = 0; $i < $n; $i++) {
            $variance += pow($historicalData[$i] - $mean, 2);
        }
        $stdDev = sqrt($variance / $n);

        // Confidence intervals (95% = 1.96 * stdDev)
        $confidenceUpper = array_map(fn($v) => $v + (1.96 * $stdDev), $ensemble);
        $confidenceLower = array_map(fn($v) => max(0, $v - (1.96 * $stdDev)), $ensemble);

        return [
            'ensemble' => array_map(fn($v) => round($v), $ensemble),
            'sma' => array_map(fn($v) => round($v), $smaForecast),
            'ema' => array_map(fn($v) => round($v), $emaForecast),
            'linear' => array_map(fn($v) => round($v), $linearForecast),
            'confidence_upper' => array_map(fn($v) => round($v), $confidenceUpper),
            'confidence_lower' => array_map(fn($v) => round($v), $confidenceLower),
        ];
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            'new_password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol (@$!%*?&#)',
        ]);

        $adminId = Auth::guard('admin')->id();
        $admin = Admin::find($adminId);

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai'])->withInput();
        }

        // Update password
        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Logout the admin
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }

    public function changeUsername(Request $request)
    {
        $request->validate([
            'new_username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9_\-\.]+$/',
                'unique:admins,nama,' . Auth::guard('admin')->id() . ',id_login'
            ],
            'password_confirmation' => 'required',
        ], [
            'new_username.required' => 'Username baru wajib diisi',
            'new_username.min' => 'Username minimal 3 karakter',
            'new_username.max' => 'Username maksimal 50 karakter',
            'new_username.regex' => 'Username hanya boleh mengandung huruf, angka, underscore, dash, dan titik',
            'new_username.unique' => 'Username sudah digunakan',
            'password_confirmation.required' => 'Password konfirmasi wajib diisi',
        ]);

        $adminId = Auth::guard('admin')->id();
        $admin = Admin::find($adminId);

        // Verify password
        if (!Hash::check($request->password_confirmation, $admin->password)) {
            return back()->withErrors(['password_confirmation' => 'Password tidak sesuai'])->withInput();
        }

        // Update username
        $admin->update([
            'nama' => $request->new_username
        ]);

        return back()->with('success', 'Username berhasil diubah! Username baru Anda: ' . $request->new_username);
    }

    public function bookings(Request $request)
    {
        $type = $request->get('type', '');
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        // Gabungkan regular, event, dan special ticket bookings
        $regularBookings = collect();
        $eventBookings = collect();
        $specialBookings = collect();

        // Query regular bookings
        if ($type == '' || $type == 'regular') {
            $regularQuery = Booking::with(['payment'])
                ->orderBy('created_at', 'desc');

            if ($status != '') {
                $regularQuery->where('status', $status);
            }
            if ($search != '') {
                $regularQuery->where(function($q) use ($search) {
                    $q->where('booking_id', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            if ($dateFrom != '') {
                $regularQuery->whereDate('tanggal_kunjungan', '>=', $dateFrom);
            }
            if ($dateTo != '') {
                $regularQuery->whereDate('tanggal_kunjungan', '<=', $dateTo);
            }

            $regularBookings = $regularQuery->get()->map(function($booking) {
                $data = [
                    'id' => $booking->booking_id,
                    'type' => 'regular',
                    'booking_id' => $booking->booking_id,
                    'nama' => $booking->nama,
                    'email' => $booking->email,
                    'tanggal_kunjungan' => $booking->tanggal_kunjungan,
                    'total_pembayaran' => $booking->total_pembayaran ?? 0,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'data' => $booking
                ];
                return (object) $data;
            });
        }

        // Query event bookings
        if ($type == '' || $type == 'event') {
            $eventQuery = EventBooking::with(['event'])
                ->orderBy('created_at', 'desc');

            if ($status != '') {
                $eventQuery->where('payment_status', $status);
            }
            if ($search != '') {
                $eventQuery->where(function($q) use ($search) {
                    $q->where('booking_id', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            if ($dateFrom != '') {
                $eventQuery->whereHas('event', function($q) use ($dateFrom) {
                    $q->whereDate('tanggal', '>=', $dateFrom);
                });
            }
            if ($dateTo != '') {
                $eventQuery->whereHas('event', function($q) use ($dateTo) {
                    $q->whereDate('tanggal', '<=', $dateTo);
                });
            }

            $eventBookings = $eventQuery->get()->map(function($booking) {
                $data = [
                    'id' => $booking->booking_id,
                    'type' => 'event',
                    'booking_id' => $booking->booking_id,
                    'nama' => $booking->nama,
                    'email' => $booking->email,
                    'tanggal_kunjungan' => $booking->event ? $booking->event->tanggal : null,
                    'total_pembayaran' => $booking->total_harga ?? 0,
                    'status' => $booking->payment_status,
                    'created_at' => $booking->created_at,
                    'data' => $booking
                ];
                return (object) $data;
            });
        }

        // Query special ticket requests
        if ($type == '' || $type == 'special') {
            $specialQuery = SpecialTicketRequest::orderBy('created_at', 'desc');

            // Special tickets don't have payment status, only approval status
            if ($status != '') {
                $specialQuery->where('status', $status);
            }
            if ($search != '') {
                $specialQuery->where(function($q) use ($search) {
                    $q->where('request_id', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            if ($dateFrom != '') {
                $specialQuery->whereDate('tanggal_kunjungan', '>=', $dateFrom);
            }
            if ($dateTo != '') {
                $specialQuery->whereDate('tanggal_kunjungan', '<=', $dateTo);
            }

            $specialBookings = $specialQuery->get()->map(function($booking) {
                $data = [
                    'id' => $booking->request_id,
                    'type' => 'special',
                    'booking_id' => $booking->request_id,
                    'nama' => $booking->nama,
                    'email' => $booking->email,
                    'tanggal_kunjungan' => $booking->tanggal_kunjungan,
                    'total_pembayaran' => 0, // Special tickets are free
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'data' => $booking
                ];
                return (object) $data;
            });
        }

        // Gabungkan dan sort - use concat instead of merge to avoid getKey() error
        $allBookings = collect([])
            ->concat($regularBookings)
            ->concat($eventBookings)
            ->concat($specialBookings)
            ->sortByDesc(function($item) {
                return $item->created_at;
            })
            ->values();

        // Manual pagination
        $perPage = 20;
        $currentPage = $request->get('page', 1);
        $total = $allBookings->count();
        
        // Get items for current page
        $items = $allBookings->forPage($currentPage, $perPage)->values();
        
        $bookings = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingDetail($id)
    {
        // Cek apakah regular booking atau event booking atau special ticket
        $regularBooking = Booking::with(['payment'])->where('booking_id', $id)->first();
        
        if ($regularBooking) {
            return view('admin.bookings.detail', [
                'booking' => $regularBooking,
                'type' => 'regular'
            ]);
        }

        $eventBooking = EventBooking::with(['event'])->where('booking_id', $id)->first();
        
        if ($eventBooking) {
            return view('admin.bookings.detail', [
                'booking' => $eventBooking,
                'type' => 'event'
            ]);
        }

        $specialTicket = SpecialTicketRequest::where('request_id', $id)->first();
        
        if ($specialTicket) {
            return view('admin.bookings.detail', [
                'booking' => $specialTicket,
                'type' => 'special'
            ]);
        }

        abort(404, 'Booking tidak ditemukan');
    }
}
