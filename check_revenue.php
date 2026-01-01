<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Carbon\Carbon;
use App\Models\Booking;

$today = Carbon::now('Asia/Jakarta');

echo "=== VERIFIKASI PERHITUNGAN RATA-RATA PENDAPATAN PERMINGGU ===\n";
echo "Tanggal sekarang: " . $today->format('Y-m-d') . " (Hari ke-" . $today->day . ")\n";
echo "Bulan: " . $today->month . ", Tahun: " . $today->year . "\n";
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
foreach ($bookings as $booking) {
    echo "  - ID #{$booking->id} | {$booking->tanggal_kunjungan} | Rp " . number_format($booking->total_pembayaran) . "\n";
}
echo "\n";

// Perhitungan rata-rata perminggu
$weeksInMonth = 4; // Jumlah minggu dalam sebulan
echo "Perhitungan:\n";
echo "  Jumlah minggu dalam sebulan: {$weeksInMonth} minggu\n";

$avgWeekly = round($revenueBulanIni / $weeksInMonth);
echo "  Rata-rata per minggu: Rp " . number_format($revenueBulanIni) . " / {$weeksInMonth} = Rp " . number_format($avgWeekly) . "\n\n";

echo "---\n";
echo "HASIL: Rata-rata Pendapatan Perminggu = Rp " . number_format($avgWeekly) . "\n";

if ($avgWeekly == 3570000) {
    echo "✓ BENAR! Perhitungan sesuai (Rp 3.570.000).\n";
} else {
    echo "Hasil perhitungan: Rp " . number_format($avgWeekly) . "\n";
}
