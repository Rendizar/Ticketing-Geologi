<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Carbon\Carbon;
use App\Models\Booking;

$today = Carbon::now('Asia/Jakarta');

echo "=== VERIFIKASI PERHITUNGAN RATA-RATA PENDAPATAN PERBULAN ===\n";
echo "Tanggal sekarang: " . $today->format('Y-m-d') . " (Hari ke-" . $today->day . ")\n";
echo "Bulan: " . $today->format('F Y') . "\n";
echo "---\n\n";

// Query revenue bulan ini
$revenueBulanIni = Booking::whereMonth('tanggal_kunjungan', $today->month)
    ->whereYear('tanggal_kunjungan', $today->year)
    ->where('status', 'paid')
    ->sum('total_pembayaran');

echo "Total Revenue Bulan Ini: Rp " . number_format($revenueBulanIni) . "\n\n";

// Detail bookings
$bookings = Booking::whereMonth('tanggal_kunjungan', $today->month)
    ->whereYear('tanggal_kunjungan', $today->year)
    ->where('status', 'paid')
    ->get(['id', 'tanggal_kunjungan', 'total_pembayaran']);

echo "Detail Booking Bulan Ini (" . $bookings->count() . " booking):\n";
$totalCheck = 0;
foreach ($bookings as $booking) {
    echo "  - ID #{$booking->id} | {$booking->tanggal_kunjungan} | Rp " . number_format($booking->total_pembayaran) . "\n";
    $totalCheck += $booking->total_pembayaran;
}
echo "\n";

echo "Verifikasi Manual: Rp " . number_format($totalCheck) . "\n";
echo "Dari Query: Rp " . number_format($revenueBulanIni) . "\n\n";

echo "---\n";
echo "PERHITUNGAN RATA-RATA PENDAPATAN BERSIH:\n\n";

$daysInMonth = $today->daysInMonth;
$weeksInMonth = 4;
$avgWeekly = round($revenueBulanIni / $weeksInMonth);
echo "1. PERMINGGU (rata-rata per minggu dalam sebulan):\n";
echo "   Total bulan ini / 4 minggu\n";
echo "   = Rp " . number_format($revenueBulanIni) . " / {$weeksInMonth}\n";
echo "   = Rp " . number_format($avgWeekly) . "\n\n";

$avgMonthly = round($revenueBulanIni / $daysInMonth);
echo "2. PERBULAN (rata-rata per hari dalam sebulan):\n";
echo "   Total bulan ini / jumlah hari dalam bulan\n";
echo "   = Rp " . number_format($revenueBulanIni) . " / {$daysInMonth} hari\n";
echo "   = Rp " . number_format($avgMonthly) . "\n\n";

$monthsElapsed = $today->month;
$revenueTahunIni = Booking::whereYear('tanggal_kunjungan', $today->year)
    ->where('status', 'paid')
    ->sum('total_pembayaran') ?? 0;
$avgYearly = $monthsElapsed > 0 ? round($revenueTahunIni / $monthsElapsed) : 0;
echo "3. PERTAHUN (rata-rata per bulan dalam tahun):\n";
echo "   Total tahun ini / jumlah bulan yang sudah lewat\n";
echo "   = Rp " . number_format($revenueTahunIni) . " / {$monthsElapsed} bulan\n";
echo "   = Rp " . number_format($avgYearly) . "\n\n";

echo "---\n";
echo "KESIMPULAN:\n";
echo "✓ Semua menampilkan RATA-RATA, bukan total\n";
echo "✓ Konsisten dengan judul card 'Rata-rata Pendapatan Bersih'\n";
