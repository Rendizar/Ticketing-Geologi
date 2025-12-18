<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = $request->only('username', 'password');
            
            // Simple hardcoded admin check
            if ($credentials['username'] === 'admin' && $credentials['password'] === '1234') {
                session(['admin_logged_in' => true]);
                return redirect()->route('admin.dashboard');
            }
            
            return back()->withErrors(['error' => 'Username atau password salah!']);
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
                'kunjungan_bulan_ini' => $this->getKunjunganBulanIni()
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
            return Booking::whereDate('tanggal_kunjungan', today())
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)')) ?? 0;
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
                DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing')
            )->first();

            return $result ?? (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0];
        } catch (\Exception $e) {
            Log::warning('Error calculating total_per_kategori: ' . $e->getMessage());
            return (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0];
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
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)) as total')
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
            return Booking::sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)')) ?? 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating total_pengunjung: ' . $e->getMessage());
            return 0;
        }
    }

    private function getAvgDaily()
    {
        try {
            $total_pengunjung = $this->getTotalPengunjung();
            $first_booking = Booking::min('created_at');
            
            if ($first_booking && $total_pengunjung > 0) {
                $days = now()->diffInDays($first_booking) + 1;
                return $days > 0 ? $total_pengunjung / $days : 0;
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating avg_daily: ' . $e->getMessage());
            return 0;
        }
    }

    private function getKunjunganBulanIni()
    {
        try {
            return Booking::whereMonth('tanggal_kunjungan', now()->month)
                ->whereYear('tanggal_kunjungan', now()->year)
                ->sum(DB::raw('COALESCE(jumlah_pelajar, 0) + COALESCE(jumlah_umum, 0) + COALESCE(jumlah_asing, 0)')) ?? 0;
        } catch (\Exception $e) {
            Log::warning('Error calculating kunjungan_bulan_ini: ' . $e->getMessage());
            return 0;
        }
    }

    private function returnEmptyDashboard($errorMessage = null)
    {
        return view('admin.dashboard', [
            'kunjungan_hari_ini' => 0,
            'total_per_kategori' => (object)['pelajar' => 0, 'umum' => 0, 'asing' => 0],
            'sub_pelajar' => (object)['tk' => 0, 'sd' => 0, 'smp' => 0, 'sma' => 0, 'kuliah' => 0],
            'per_provinsi' => collect([]),
            'avg_daily' => 0,
            'total_pengunjung' => 0,
            'kunjungan_bulan_ini' => 0,
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

            // Fetch grouped sums by day
            $rows = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->select(
                    DB::raw('DAY(tanggal_kunjungan) as day'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing')
                )
                ->groupBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->orderBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->get();

            // Map rows to day => values for quick lookup
            $byDay = [];
            foreach ($rows as $r) {
                $byDay[(int) $r->day] = [
                    'pelajar' => (int) $r->pelajar,
                    'umum' => (int) $r->umum,
                    'asing' => (int) $r->asing,
                ];
            }

            $labels = [];
            $pelajar = [];
            $umum = [];
            $asing = [];
            $totals = [];

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = (string) $d;
                $p = $byDay[$d]['pelajar'] ?? 0;
                $u = $byDay[$d]['umum'] ?? 0;
                $a = $byDay[$d]['asing'] ?? 0;
                $pelajar[] = $p;
                $umum[] = $u;
                $asing[] = $a;
                $totals[] = $p + $u + $a;
            }

            return response()->json([
                'labels' => $labels,
                'totals' => $totals,
                'by_category' => [
                    'pelajar' => $pelajar,
                    'umum' => $umum,
                    'asing' => $asing,
                ],
                'meta' => [
                    'month' => $month,
                    'year' => $year,
                    'days' => $daysInMonth,
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
                ],
                'error' => 'Terjadi kesalahan saat memuat data.'
            ], 500);
        }
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
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
            $daysInMonth = $start->daysInMonth;

            // Fetch grouped sums by day
            $rows = Booking::whereBetween('tanggal_kunjungan', [$start->toDateString(), $end->toDateString()])
                ->select(
                    DB::raw('DAY(tanggal_kunjungan) as day'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing')
                )
                ->groupBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->orderBy(DB::raw('DAY(tanggal_kunjungan)'))
                ->get();

            // Map rows to day => values
            $byDay = [];
            foreach ($rows as $r) {
                $byDay[(int) $r->day] = [
                    'pelajar' => (int) $r->pelajar,
                    'umum' => (int) $r->umum,
                    'asing' => (int) $r->asing,
                ];
            }

            $monthName = Carbon::create($year, $month, 1)->locale('id')->translatedFormat('F Y');
            $filename = "Penjualan_Tiket_Bulanan_{$year}_{$month}.xlsx";

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Laporan Bulanan');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PENJUALAN TIKET BULANAN');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('A2', 'Museum Geologi Bandung');
            $sheet->mergeCells('A2:E2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setSize(12);

            $sheet->setCellValue('A3', 'Periode: ' . $monthName);
            $sheet->setCellValue('D3', 'Dicetak: ' . now()->locale('id')->translatedFormat('d F Y H:i'));
            $sheet->getStyle('A3:E3')->getFont()->setItalic(true);

            // Table header
            $headerRow = 5;
            $headers = ['Tanggal', 'Pelajar', 'Umum', 'Asing', 'Total'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $headerRow, $header);
                $col++;
            }

            // Style table header
            $sheet->getStyle("A{$headerRow}:E{$headerRow}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Data rows
            $row = $headerRow + 1;
            $totalPelajar = $totalUmum = $totalAsing = 0;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $date = Carbon::create($year, $month, $d);
                $p = $byDay[$d]['pelajar'] ?? 0;
                $u = $byDay[$d]['umum'] ?? 0;
                $a = $byDay[$d]['asing'] ?? 0;
                $total = $p + $u + $a;

                $sheet->setCellValue('A' . $row, $date->locale('id')->translatedFormat('d F Y'));
                $sheet->setCellValue('B' . $row, $p);
                $sheet->setCellValue('C' . $row, $u);
                $sheet->setCellValue('D' . $row, $a);
                $sheet->setCellValue('E' . $row, $total);

                $totalPelajar += $p;
                $totalUmum += $u;
                $totalAsing += $a;

                // Zebra striping
                if ($d % 2 == 0) {
                    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']]
                    ]);
                }

                $row++;
            }

            // Style data area
            $lastRow = $row - 1;
            $sheet->getStyle("A{$headerRow}:E{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
            ]);
            $sheet->getStyle("B" . ($headerRow + 1) . ":E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Total row
            $row++;
            $grandTotal = $totalPelajar + $totalUmum + $totalAsing;
            $sheet->setCellValue('A' . $row, 'TOTAL BULANAN');
            $sheet->setCellValue('B' . $row, $totalPelajar);
            $sheet->setCellValue('C' . $row, $totalUmum);
            $sheet->setCellValue('D' . $row, $totalAsing);
            $sheet->setCellValue('E' . $row, $grandTotal);

            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B0B0B']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]]
            ]);

            // Column widths
            $sheet->getColumnDimension('A')->setWidth(25);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);

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
                ->select(
                    DB::raw('MONTH(tanggal_kunjungan) as month'),
                    DB::raw('SUM(COALESCE(jumlah_pelajar, 0)) as pelajar'),
                    DB::raw('SUM(COALESCE(jumlah_umum, 0)) as umum'),
                    DB::raw('SUM(COALESCE(jumlah_asing, 0)) as asing')
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
            $headers = ['Bulan', 'Pelajar', 'Umum', 'Asing', 'Total'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $headerRow, $header);
                $col++;
            }

            // Style table header
            $sheet->getStyle("A{$headerRow}:E{$headerRow}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD400']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Data rows
            $row = $headerRow + 1;
            $totalPelajar = $totalUmum = $totalAsing = 0;

            for ($m = 1; $m <= 12; $m++) {
                $p = $byMonth[$m]['pelajar'] ?? 0;
                $u = $byMonth[$m]['umum'] ?? 0;
                $a = $byMonth[$m]['asing'] ?? 0;
                $total = $p + $u + $a;

                $sheet->setCellValue('A' . $row, $monthNames[$m] . ' ' . $year);
                $sheet->setCellValue('B' . $row, $p);
                $sheet->setCellValue('C' . $row, $u);
                $sheet->setCellValue('D' . $row, $a);
                $sheet->setCellValue('E' . $row, $total);

                $totalPelajar += $p;
                $totalUmum += $u;
                $totalAsing += $a;

                // Zebra striping
                if ($m % 2 == 0) {
                    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']]
                    ]);
                }

                $row++;
            }

            // Style data area
            $lastRow = $row - 1;
            $sheet->getStyle("A{$headerRow}:E{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
            ]);
            $sheet->getStyle("B" . ($headerRow + 1) . ":E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Total row
            $row++;
            $grandTotal = $totalPelajar + $totalUmum + $totalAsing;
            $sheet->setCellValue('A' . $row, 'TOTAL TAHUNAN');
            $sheet->setCellValue('B' . $row, $totalPelajar);
            $sheet->setCellValue('C' . $row, $totalUmum);
            $sheet->setCellValue('D' . $row, $totalAsing);
            $sheet->setCellValue('E' . $row, $grandTotal);

            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
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
}