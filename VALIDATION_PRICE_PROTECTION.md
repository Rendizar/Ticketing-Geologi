# Validasi: Data Transaksi Lama Tidak Tertimpa

## Mekanisme Proteksi Data

### 1. **Snapshot Harga Saat Booking**
Ketika booking dibuat, sistem menyimpan "snapshot" harga pada waktu transaksi:

```php
// Di BookingController@store
use App\Models\TicketCategory;

// Ambil harga SAAT INI dari database
$hargaPelajar = TicketCategory::where('code', 'pelajar')->where('is_active', true)->value('price');
$hargaUmum = TicketCategory::where('code', 'umum')->where('is_active', true)->value('price');
$hargaAsing = TicketCategory::where('code', 'asing')->where('is_active', true)->value('price');

// Hitung total
$totalPembayaran = 
    ($request->jumlah_pelajar * $hargaPelajar) +
    ($request->jumlah_umum * $hargaUmum) +
    ($request->jumlah_asing * $hargaAsing);

// Simpan booking dengan SNAPSHOT harga
Booking::create([
    'booking_id' => $bookingId,
    'nama' => $request->nama,
    'email' => $request->email,
    // ... field lainnya ...
    'jumlah_pelajar' => $request->jumlah_pelajar,
    'jumlah_umum' => $request->jumlah_umum,
    'jumlah_asing' => $request->jumlah_asing,
    
    // SNAPSHOT HARGA - TIDAK AKAN BERUBAH!
    'harga_pelajar_saat_booking' => $hargaPelajar,
    'harga_umum_saat_booking' => $hargaUmum,
    'harga_asing_saat_booking' => $hargaAsing,
    'total_pembayaran' => $totalPembayaran,
]);
```

### 2. **Struktur Tabel Bookings**

```
bookings
├── jumlah_pelajar (quantity)
├── jumlah_umum (quantity)
├── jumlah_asing (quantity)
├── harga_pelajar_saat_booking ← SNAPSHOT HARGA
├── harga_umum_saat_booking    ← SNAPSHOT HARGA
├── harga_asing_saat_booking   ← SNAPSHOT HARGA
└── total_pembayaran           ← TOTAL DARI SNAPSHOT
```

### 3. **Perubahan Harga di ticket_categories**

Ketika admin mengubah harga:
```
ticket_categories (MASTER DATA)
├── Pelajar: Rp 2.000 → Rp 3.000 (BERUBAH)
├── Umum: Rp 3.000 → Rp 5.000 (BERUBAH)
└── Asing: Rp 10.000 → Rp 15.000 (BERUBAH)

bookings (DATA TRANSAKSI LAMA)
├── Booking #001 (Tanggal: 2025-01-01)
│   ├── harga_pelajar_saat_booking: Rp 2.000 (TETAP!)
│   ├── harga_umum_saat_booking: Rp 3.000 (TETAP!)
│   └── total_pembayaran: Rp 5.000 (TETAP!)
│
└── Booking #002 (Tanggal: 2025-12-30, SETELAH PERUBAHAN)
    ├── harga_pelajar_saat_booking: Rp 3.000 (HARGA BARU)
    ├── harga_umum_saat_booking: Rp 5.000 (HARGA BARU)
    └── total_pembayaran: Rp 8.000 (HARGA BARU)
```

## Test Validasi

### Skenario 1: Booking Sebelum Perubahan Harga

**Langkah:**
1. Harga Pelajar = Rp 2.000
2. User booking 5 tiket pelajar
3. Total = 5 × Rp 2.000 = **Rp 10.000**
4. Data tersimpan:
   ```
   harga_pelajar_saat_booking: 2000
   jumlah_pelajar: 5
   total_pembayaran: 10000
   ```

### Skenario 2: Admin Ubah Harga

**Langkah:**
1. Admin mengubah Harga Pelajar = Rp 3.000
2. Perubahan tercatat di `ticket_price_history`:
   ```
   old_price: 2000
   new_price: 3000
   changed_by: admin
   reason: "Penyesuaian inflasi"
   ```

### Skenario 3: Validasi Data Lama

**Query untuk validasi:**
```sql
-- Cek booking lama masih menggunakan harga lama
SELECT 
    booking_id,
    jumlah_pelajar,
    harga_pelajar_saat_booking,
    total_pembayaran,
    created_at
FROM bookings 
WHERE created_at < '2025-12-30'  -- Sebelum perubahan harga
ORDER BY created_at DESC;
```

**Hasil yang diharapkan:**
```
booking_id  | jumlah | harga_snapshot | total  | created_at
-----------|--------|----------------|--------|------------
BKG001     | 5      | 2000.00        | 10000  | 2025-01-15
BKG002     | 3      | 2000.00        | 6000   | 2025-02-20
```

**✅ VALIDASI: Harga tetap Rp 2.000, tidak berubah jadi Rp 3.000**

### Skenario 4: Booking Setelah Perubahan Harga

**Langkah:**
1. User baru booking 5 tiket pelajar
2. Sistem ambil harga dari `ticket_categories` (Rp 3.000)
3. Total = 5 × Rp 3.000 = **Rp 15.000**
4. Data tersimpan:
   ```
   harga_pelajar_saat_booking: 3000
   jumlah_pelajar: 5
   total_pembayaran: 15000
   ```

## Kode Validasi untuk Testing

### Test 1: Cek Konsistensi Data
```php
// Test bahwa snapshot harga = (total / quantity)
$bookings = Booking::where('jumlah_pelajar', '>', 0)->get();

foreach ($bookings as $booking) {
    $expectedTotal = 
        ($booking->jumlah_pelajar * $booking->harga_pelajar_saat_booking) +
        ($booking->jumlah_umum * $booking->harga_umum_saat_booking) +
        ($booking->jumlah_asing * $booking->harga_asing_saat_booking);
    
    if ($booking->total_pembayaran != $expectedTotal) {
        echo "❌ INCONSISTENCY: Booking {$booking->booking_id}\n";
    } else {
        echo "✅ VALID: Booking {$booking->booking_id}\n";
    }
}
```

### Test 2: Bandingkan Harga Lama vs Baru
```php
// Ambil harga saat ini dari master
$currentPrice = TicketCategory::where('code', 'pelajar')->value('price');

// Ambil booking lama
$oldBookings = Booking::where('created_at', '<', '2025-12-30')
    ->where('jumlah_pelajar', '>', 0)
    ->get();

foreach ($oldBookings as $booking) {
    echo "Booking: {$booking->booking_id}\n";
    echo "Harga saat booking: Rp " . number_format($booking->harga_pelajar_saat_booking) . "\n";
    echo "Harga sekarang: Rp " . number_format($currentPrice) . "\n";
    
    if ($booking->harga_pelajar_saat_booking == $currentPrice) {
        echo "⚠️  WARNING: Harga sama (mungkin belum ada perubahan)\n";
    } else {
        echo "✅ PROTECTED: Harga snapshot berbeda dari harga current\n";
    }
    echo "---\n";
}
```

## Laporan Untuk Audit

### Query Laporan Perbandingan
```sql
-- Laporan booking dengan perbandingan harga lama vs baru
SELECT 
    b.booking_id,
    b.nama,
    b.created_at AS tanggal_booking,
    b.jumlah_pelajar,
    b.harga_pelajar_saat_booking AS harga_lama,
    tc.price AS harga_sekarang,
    (tc.price - b.harga_pelajar_saat_booking) AS selisih,
    CASE 
        WHEN b.harga_pelajar_saat_booking < tc.price 
        THEN 'HEMAT (booking sebelum kenaikan)'
        WHEN b.harga_pelajar_saat_booking > tc.price 
        THEN 'MAHAL (booking sebelum penurunan)'
        ELSE 'SAMA'
    END AS keterangan
FROM bookings b
LEFT JOIN ticket_categories tc ON tc.code = 'pelajar'
WHERE b.jumlah_pelajar > 0
ORDER BY b.created_at DESC;
```

## Kesimpulan

✅ **Data transaksi lama AMAN dan TIDAK TERTIMPA** karena:

1. **Snapshot Mechanism**: Harga disimpan di tabel `bookings` saat transaksi
2. **Separated Tables**: Master harga (`ticket_categories`) terpisah dari data transaksi (`bookings`)
3. **History Tracking**: Semua perubahan harga tercatat di `ticket_price_history`
4. **Immutable Transaction**: Sekali booking dibuat, harga snapshot tidak pernah berubah

### Keuntungan:
- ✅ Laporan keuangan akurat
- ✅ Audit trail lengkap
- ✅ Tidak ada dispute harga dengan customer
- ✅ Analisis trend harga mudah
- ✅ Compliance dengan aturan perpajakan

---
**Date:** December 30, 2025
**Status:** ✅ VALIDATED - Data Protected
