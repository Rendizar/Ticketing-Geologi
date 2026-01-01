<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use Carbon\Carbon;

echo "=== ANALISIS KEBERLANJUTAN DASHBOARD ===\n\n";

// 1. Cek jumlah total records
echo "1. VOLUME DATA\n";
echo "   Total bookings: " . Booking::count() . " records\n";
echo "   Bookings paid: " . Booking::where('status', 'paid')->count() . " records\n\n";

// 2. Test query performance dengan EXPLAIN
echo "2. PERFORMA QUERY (dengan EXPLAIN)\n";

// Test query getRevenuePerKategori
echo "   a) Revenue per kategori (agregat):\n";
$explain = DB::select("EXPLAIN SELECT 
    SUM(COALESCE(jumlah_pelajar, 0) * COALESCE(harga_pelajar_saat_booking, 0)) as pelajar,
    SUM(COALESCE(jumlah_umum, 0) * COALESCE(harga_umum_saat_booking, 0)) as umum,
    SUM(COALESCE(jumlah_asing, 0) * COALESCE(harga_asing_saat_booking, 0)) as asing
FROM bookings WHERE status = 'paid'");
echo "      Rows examined: " . $explain[0]->rows . "\n";
echo "      Type: " . $explain[0]->type . "\n";
echo "      Key used: " . ($explain[0]->key ?? 'NONE') . "\n\n";

// Test query khusus bookings (potensi bottleneck)
echo "   b) Tiket khusus bookings (per-row processing):\n";
$start = microtime(true);
$khususBookings = Booking::where('status', 'paid')
    ->where('jumlah_tiket_khusus', '>', 0)
    ->get();
$end = microtime(true);
echo "      Records: " . $khususBookings->count() . "\n";
echo "      Time: " . round(($end - $start) * 1000, 2) . " ms\n";
echo "      ⚠️ WARNING: Loop foreach untuk " . $khususBookings->count() . " records (N+1 problem)\n\n";

// Test monthly revenue query
echo "   c) Monthly revenue (per day):\n";
$month = now()->month;
$year = now()->year;
$start_time = microtime(true);
$result = Booking::whereYear('tanggal_kunjungan', $year)
    ->whereMonth('tanggal_kunjungan', $month)
    ->where('status', 'paid')
    ->select(
        DB::raw('DAY(tanggal_kunjungan) as day'),
        DB::raw('SUM(COALESCE(total_pembayaran, 0)) as total')
    )
    ->groupBy(DB::raw('DAY(tanggal_kunjungan)'))
    ->orderBy(DB::raw('DAY(tanggal_kunjungan)'))
    ->get();
$end_time = microtime(true);
echo "      Days with data: " . $result->count() . "\n";
echo "      Time: " . round(($end_time - $start_time) * 1000, 2) . " ms\n\n";

// 3. Cek indeks
echo "3. DATABASE INDEXES\n";
$indexes = DB::select("SHOW INDEX FROM bookings");
$indexNames = array_unique(array_column($indexes, 'Key_name'));
echo "   Indexes found: " . implode(', ', $indexNames) . "\n";

// Recommended indexes
$recommendedIndexes = [
    'status',
    'tanggal_kunjungan',
    'jumlah_tiket_khusus'
];

echo "\n   Recommended indexes:\n";
foreach ($recommendedIndexes as $col) {
    $hasIndex = false;
    foreach ($indexes as $idx) {
        if ($idx->Column_name === $col) {
            $hasIndex = true;
            break;
        }
    }
    echo "      - $col: " . ($hasIndex ? "✓ EXISTS" : "✗ MISSING") . "\n";
}

echo "\n4. MASALAH KEBERLANJUTAN YANG DITEMUKAN\n";
$issues = [];

// Check N+1 problem in getRevenuePerKategori
if ($khususBookings->count() > 0) {
    $issues[] = [
        'severity' => 'HIGH',
        'issue' => 'N+1 Query Problem di getRevenuePerKategori()',
        'detail' => 'Foreach loop untuk ' . $khususBookings->count() . ' records. Setiap record melakukan kalkulasi di PHP.',
        'impact' => 'Performance akan menurun drastis saat data tiket khusus bertambah (100+ records)',
        'solution' => 'Gunakan DB::raw() untuk menghitung di database level'
    ];
}

// Check missing indexes
$missingIndexes = [];
foreach ($recommendedIndexes as $col) {
    $hasIndex = false;
    foreach ($indexes as $idx) {
        if ($idx->Column_name === $col) {
            $hasIndex = true;
            break;
        }
    }
    if (!$hasIndex) {
        $missingIndexes[] = $col;
    }
}

if (count($missingIndexes) > 0) {
    $issues[] = [
        'severity' => 'MEDIUM',
        'issue' => 'Missing Database Indexes',
        'detail' => 'Kolom: ' . implode(', ', $missingIndexes),
        'impact' => 'Query akan lambat saat data membesar (1000+ records)',
        'solution' => 'Tambahkan index pada kolom yang sering di-filter/group'
    ];
}

// Check no caching
$issues[] = [
    'severity' => 'MEDIUM',
    'issue' => 'No Caching Mechanism',
    'detail' => 'Semua query dijalankan setiap page load',
    'impact' => 'Database load tinggi, response time lambat',
    'solution' => 'Implementasi Laravel Cache untuk data yang jarang berubah (5-15 menit TTL)'
];

// Check no pagination
$issues[] = [
    'severity' => 'LOW',
    'issue' => 'No Pagination in Export',
    'detail' => 'Export Excel mengambil semua data sekaligus',
    'impact' => 'Memory overflow jika export >10,000 records',
    'solution' => 'Gunakan chunking atau limit export range'
];

foreach ($issues as $i => $issue) {
    echo "\n   Issue #" . ($i + 1) . " [" . $issue['severity'] . "]\n";
    echo "   Problem: " . $issue['issue'] . "\n";
    echo "   Detail: " . $issue['detail'] . "\n";
    echo "   Impact: " . $issue['impact'] . "\n";
    echo "   Solution: " . $issue['solution'] . "\n";
}

echo "\n\n5. SKOR KEBERLANJUTAN\n";
$totalScore = 100;
$deductions = [
    'N+1 Problem' => 30,
    'Missing Indexes' => count($missingIndexes) * 10,
    'No Caching' => 20,
    'No Pagination' => 10
];

foreach ($deductions as $reason => $points) {
    if ($reason === 'Missing Indexes' && count($missingIndexes) === 0) continue;
    echo "   -$points pts: $reason\n";
    $totalScore -= $points;
}

echo "\n   TOTAL SCORE: $totalScore/100\n";

if ($totalScore >= 80) {
    echo "   STATUS: ✓ GOOD - Dashboard sustainable untuk skala kecil-menengah\n";
} elseif ($totalScore >= 60) {
    echo "   STATUS: ⚠️ FAIR - Perlu optimasi untuk skala menengah-besar\n";
} else {
    echo "   STATUS: ✗ POOR - Butuh perbaikan segera untuk keberlanjutan jangka panjang\n";
}

echo "\n\n6. REKOMENDASI PRIORITAS\n";
echo "   [1] HIGH: Optimasi getRevenuePerKategori() - ganti foreach dengan DB aggregate\n";
echo "   [2] MEDIUM: Tambahkan index pada kolom status, tanggal_kunjungan\n";
echo "   [3] MEDIUM: Implementasi caching untuk KPI dan statistik\n";
echo "   [4] LOW: Tambahkan chunking pada export Excel\n";

echo "\n\nAnalisis selesai.\n";
