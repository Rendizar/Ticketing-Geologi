<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Booking;

echo "=== Checking Revenue Per Kategori ===\n\n";

try {
    $result = Booking::where('status', 'paid')
        ->select(
            DB::raw('SUM(COALESCE(jumlah_pelajar, 0) * COALESCE(harga_pelajar_saat_booking, 0)) as pelajar'),
            DB::raw('SUM(COALESCE(jumlah_umum, 0) * COALESCE(harga_umum_saat_booking, 0)) as umum'),
            DB::raw('SUM(COALESCE(jumlah_asing, 0) * COALESCE(harga_asing_saat_booking, 0)) as asing')
        )->first();
    
    // Untuk tiket khusus
    $khususBookings = Booking::where('status', 'paid')
        ->where('jumlah_tiket_khusus', '>', 0)
        ->get();
    
    $khususRevenue = 0;
    foreach ($khususBookings as $booking) {
        $otherRevenue = ($booking->jumlah_pelajar * $booking->harga_pelajar_saat_booking) +
                       ($booking->jumlah_umum * $booking->harga_umum_saat_booking) +
                       ($booking->jumlah_asing * $booking->harga_asing_saat_booking);
        $khususRevenue += max(0, $booking->total_pembayaran - $otherRevenue);
    }
    
    echo "Pelajar Revenue: Rp " . number_format($result->pelajar ?? 0, 0, ',', '.') . "\n";
    echo "Umum Revenue: Rp " . number_format($result->umum ?? 0, 0, ',', '.') . "\n";
    echo "Asing Revenue: Rp " . number_format($result->asing ?? 0, 0, ',', '.') . "\n";
    echo "Khusus Revenue: Rp " . number_format($khususRevenue ?? 0, 0, ',', '.') . "\n";
    echo "\nTotal Revenue: Rp " . number_format(($result->pelajar ?? 0) + ($result->umum ?? 0) + ($result->asing ?? 0) + ($khususRevenue ?? 0), 0, ',', '.') . "\n";
    
    // Check sample data
    echo "\n=== Sample Booking Data ===\n";
    $sample = Booking::where('status', 'paid')
        ->select('jumlah_pelajar', 'harga_pelajar_saat_booking', 'jumlah_umum', 'harga_umum_saat_booking', 'jumlah_asing', 'harga_asing_saat_booking', 'jumlah_tiket_khusus', 'harga_khusus_saat_booking')
        ->first();
    
    if ($sample) {
        echo "First booking:\n";
        echo "  Pelajar: {$sample->jumlah_pelajar} x Rp " . number_format($sample->harga_pelajar_saat_booking ?? 0, 0, ',', '.') . "\n";
        echo "  Umum: {$sample->jumlah_umum} x Rp " . number_format($sample->harga_umum_saat_booking ?? 0, 0, ',', '.') . "\n";
        echo "  Asing: {$sample->jumlah_asing} x Rp " . number_format($sample->harga_asing_saat_booking ?? 0, 0, ',', '.') . "\n";
        echo "  Khusus: {$sample->jumlah_tiket_khusus} x Rp " . number_format($sample->harga_khusus_saat_booking ?? 0, 0, ',', '.') . "\n";
    } else {
        echo "No paid bookings found!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
