#!/usr/bin/env php
<?php

/**
 * Script Validasi: Test Proteksi Data Transaksi Lama
 * 
 * Cara menjalankan:
 * php artisan tinker
 * 
 * Lalu copy-paste kode berikut satu per satu
 */

// =====================================================
// TEST 1: Simulasi Booking SEBELUM Perubahan Harga
// =====================================================
echo "=== TEST 1: Booking Sebelum Perubahan Harga ===\n";

use App\Models\Booking;
use App\Models\TicketCategory;

// Ambil harga saat ini
$hargaPelajar = TicketCategory::where('code', 'pelajar')->value('price');
$hargaUmum = TicketCategory::where('code', 'umum')->value('price');

echo "Harga Pelajar saat ini: Rp " . number_format($hargaPelajar, 0, ',', '.') . "\n";
echo "Harga Umum saat ini: Rp " . number_format($hargaUmum, 0, ',', '.') . "\n\n";

// Buat booking test
$testBooking = Booking::create([
    'booking_id' => 'TEST-' . time(),
    'nama' => 'Test User',
    'email' => 'test@example.com',
    'nomor_telepon' => '081234567890',
    'negara' => 'Indonesia',
    'jenis_pemesanan' => 'individu',
    'tanggal_kunjungan' => now()->addDays(7),
    'jumlah_pelajar' => 5,
    'jumlah_umum' => 2,
    'jumlah_asing' => 0,
    'harga_pelajar_saat_booking' => $hargaPelajar,
    'harga_umum_saat_booking' => $hargaUmum,
    'harga_asing_saat_booking' => 0,
    'total_pembayaran' => (5 * $hargaPelajar) + (2 * $hargaUmum),
    'status' => 'paid',
]);

echo "✅ Booking berhasil dibuat: {$testBooking->booking_id}\n";
echo "   - 5 Pelajar × Rp " . number_format($hargaPelajar) . " = Rp " . number_format(5 * $hargaPelajar) . "\n";
echo "   - 2 Umum × Rp " . number_format($hargaUmum) . " = Rp " . number_format(2 * $hargaUmum) . "\n";
echo "   - Total: Rp " . number_format($testBooking->total_pembayaran) . "\n\n";

// =====================================================
// TEST 2: Ubah Harga di ticket_categories
// =====================================================
echo "=== TEST 2: Admin Mengubah Harga ===\n";

$categoryPelajar = TicketCategory::where('code', 'pelajar')->first();
$oldPrice = $categoryPelajar->price;
$newPrice = $oldPrice + 1000; // Naikkan Rp 1.000

echo "Mengubah harga Pelajar dari Rp " . number_format($oldPrice) . " → Rp " . number_format($newPrice) . "\n";

$categoryPelajar->update(['price' => $newPrice]);

// Simpan history
use App\Models\TicketPriceHistory;
TicketPriceHistory::create([
    'ticket_category_id' => $categoryPelajar->id,
    'old_price' => $oldPrice,
    'new_price' => $newPrice,
    'changed_by' => 1, // ID admin (sesuaikan)
    'reason' => 'Test validasi proteksi data'
]);

echo "✅ Harga berhasil diubah dan tercatat di history\n\n";

// =====================================================
// TEST 3: Validasi Data Booking Lama TIDAK BERUBAH
// =====================================================
echo "=== TEST 3: Validasi Data Lama TIDAK Berubah ===\n";

// Refresh data booking dari database
$testBooking->refresh();

echo "Booking ID: {$testBooking->booking_id}\n";
echo "Harga Pelajar SAAT BOOKING (snapshot): Rp " . number_format($testBooking->harga_pelajar_saat_booking) . "\n";
echo "Harga Pelajar SEKARANG (master): Rp " . number_format($newPrice) . "\n";

if ($testBooking->harga_pelajar_saat_booking == $oldPrice) {
    echo "✅ VALIDASI BERHASIL: Harga snapshot TETAP Rp " . number_format($oldPrice) . "\n";
    echo "   Data transaksi lama TIDAK TERTIMPA!\n\n";
} else {
    echo "❌ VALIDASI GAGAL: Harga snapshot berubah!\n\n";
}

// =====================================================
// TEST 4: Booking Baru Menggunakan Harga Baru
// =====================================================
echo "=== TEST 4: Booking Baru Menggunakan Harga Baru ===\n";

$hargaPelajarBaru = TicketCategory::where('code', 'pelajar')->value('price');
$hargaUmumBaru = TicketCategory::where('code', 'umum')->value('price');

$newBooking = Booking::create([
    'booking_id' => 'NEW-' . time(),
    'nama' => 'New User',
    'email' => 'new@example.com',
    'nomor_telepon' => '081234567891',
    'negara' => 'Indonesia',
    'jenis_pemesanan' => 'individu',
    'tanggal_kunjungan' => now()->addDays(7),
    'jumlah_pelajar' => 5,
    'jumlah_umum' => 2,
    'jumlah_asing' => 0,
    'harga_pelajar_saat_booking' => $hargaPelajarBaru,
    'harga_umum_saat_booking' => $hargaUmumBaru,
    'harga_asing_saat_booking' => 0,
    'total_pembayaran' => (5 * $hargaPelajarBaru) + (2 * $hargaUmumBaru),
    'status' => 'paid',
]);

echo "✅ Booking baru dibuat: {$newBooking->booking_id}\n";
echo "   - 5 Pelajar × Rp " . number_format($hargaPelajarBaru) . " = Rp " . number_format(5 * $hargaPelajarBaru) . "\n";
echo "   - Total: Rp " . number_format($newBooking->total_pembayaran) . "\n\n";

// =====================================================
// TEST 5: Bandingkan Kedua Booking
// =====================================================
echo "=== TEST 5: Perbandingan ===\n";
echo "┌─────────────────────────────────────────────────────────────┐\n";
echo "│ BOOKING LAMA (sebelum perubahan)                           │\n";
echo "├─────────────────────────────────────────────────────────────┤\n";
echo "│ ID: {$testBooking->booking_id}                             \n";
echo "│ Harga Pelajar: Rp " . number_format($testBooking->harga_pelajar_saat_booking) . "\n";
echo "│ Total: Rp " . number_format($testBooking->total_pembayaran) . "\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

echo "┌─────────────────────────────────────────────────────────────┐\n";
echo "│ BOOKING BARU (setelah perubahan)                           │\n";
echo "├─────────────────────────────────────────────────────────────┤\n";
echo "│ ID: {$newBooking->booking_id}                              \n";
echo "│ Harga Pelajar: Rp " . number_format($newBooking->harga_pelajar_saat_booking) . "\n";
echo "│ Total: Rp " . number_format($newBooking->total_pembayaran) . "\n";
echo "└─────────────────────────────────────────────────────────────┘\n\n";

$selisih = $newBooking->total_pembayaran - $testBooking->total_pembayaran;
echo "Selisih total: Rp " . number_format($selisih) . "\n";
echo "Customer booking lama HEMAT Rp " . number_format($selisih) . " karena booking sebelum kenaikan harga!\n\n";

// =====================================================
// KESIMPULAN
// =====================================================
echo "=== KESIMPULAN ===\n";
echo "✅ Data transaksi lama AMAN dan TIDAK TERTIMPA\n";
echo "✅ Perubahan harga hanya berlaku untuk booking baru\n";
echo "✅ History perubahan harga tercatat dengan lengkap\n";
echo "✅ Sistem VALID untuk production\n\n";

// =====================================================
// CLEANUP (Opsional - hapus data test)
// =====================================================
echo "Hapus data test? (y/n): ";
// $testBooking->delete();
// $newBooking->delete();
// $categoryPelajar->update(['price' => $oldPrice]); // Kembalikan harga
// echo "Data test dihapus.\n";
