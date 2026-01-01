# Fitur Tabel Ketersediaan Slot Waktu

## Deskripsi
Fitur ini menampilkan tabel ketersediaan slot waktu secara real-time pada form pemesanan tiket kategori rombongan. Tabel akan muncul setelah pengunjung memilih tanggal kunjungan.

## Implementasi

### 1. Backend - Controller (BookingController.php)
**Method:** `getSlotAvailability(Request $request)`
- **Input:** Parameter `date` (format: YYYY-MM-DD)
- **Output:** JSON array dengan informasi slot waktu
- **Logic:**
  - Query database untuk menghitung total pengunjung yang sudah booking per slot
  - Menghitung sisa kapasitas (max 2500 per slot)
  - Menentukan status: `full`, `almost_full`, atau `available`

**Response Format:**
```json
[
  {
    "slot": "08:00-09:00",
    "booked": 1200,
    "available": 1300,
    "percentage": 48,
    "status": "available"
  },
  ...
]
```

### 2. Backend - Route (routes/web.php)
```php
Route::get('/slot-availability', [BookingController::class, 'getSlotAvailability'])
    ->name('tickets.slot-availability');
```
- URL: `/tickets/slot-availability?date=2025-01-15`
- Method: GET

### 3. Frontend - View (resources/views/visitor/create.blade.php)

#### A. HTML Tabel
Ditambahkan tabel di bawah peringatan slot waktu:
- Header: Slot Waktu, Terisi, Tersedia, Status
- Body: Diisi dinamis via JavaScript
- Styling: Gradient purple header, responsive table

#### B. JavaScript Functions

**Function 1: `fetchSlotAvailability(date)`**
- Dipanggil otomatis saat tanggal dipilih
- Fetch data dari API `/tickets/slot-availability`
- Update tabel dengan data slot
- Disable option slot yang penuh

**Function 2: Update Date Change Event**
- Memanggil `fetchSlotAvailability()` setelah validasi tanggal

## Indikator Status

| Status | Badge | Warna Baris | Kondisi |
|--------|-------|-------------|---------|
| **Penuh** | Red Badge | table-danger | available <= 0 |
| **Hampir Penuh** | Yellow Badge | table-warning | booked >= 80% |
| **Tersedia** | Green Badge | table-success | available > 20% |

## User Flow

1. Pengunjung pilih kategori "Rombongan"
2. Pengunjung input jumlah pengunjung ≥ 20 orang
3. Field "Slot Waktu" muncul
4. Pengunjung pilih tanggal kunjungan
5. **Tabel ketersediaan slot muncul otomatis**
6. Tabel menampilkan:
   - Slot waktu (08:00-09:00, dst)
   - Jumlah terisi
   - Jumlah tersedia
   - Status (badge berwarna)
7. Slot yang penuh akan di-disable di dropdown
8. Pengunjung pilih slot yang tersedia

## Keunggulan

1. **Real-time Data:** Data diambil langsung dari database saat tanggal dipilih
2. **Visual Indicator:** Badge berwarna memudahkan identifikasi ketersediaan
3. **Auto-disable:** Slot penuh otomatis tidak bisa dipilih
4. **Responsive:** Tabel responsif untuk semua ukuran layar
5. **Inline Display:** Tidak perlu pindah halaman, langsung di form

## File yang Dimodifikasi

1. **app/Http/Controllers/BookingController.php** - Tambah method `getSlotAvailability()`
2. **routes/web.php** - Tambah route `tickets.slot-availability`
3. **resources/views/visitor/create.blade.php** - Tambah:
   - HTML tabel struktur
   - Function `fetchSlotAvailability()`
   - Event listener untuk tanggal

## Testing

### Manual Test:
1. Buka http://127.0.0.1:8000/tickets/create
2. Pilih "Rombongan"
3. Input jumlah ≥ 20 orang
4. Pilih tanggal (selain Jumat/libur)
5. Verifikasi tabel muncul dengan data slot
6. Cek apakah slot penuh disabled
7. Submit booking dengan slot tersedia

### API Test:
```bash
curl "http://127.0.0.1:8000/tickets/slot-availability?date=2025-01-15"
```

## Cache Clearing
Setelah implementasi, jalankan:
```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

## Catatan Penting

- Kapasitas per slot: **2500 pengunjung**
- Total slot per hari: **8 slot** (08:00-16:00)
- Agregasi: `jumlah_pelajar + jumlah_umum + jumlah_asing`
- Status booking yang di-exclude: `cancelled`
- Tabel hanya muncul untuk kategori **Rombongan** dengan jumlah ≥ 20 orang

## Future Enhancement

1. Tambah loading spinner saat fetch data
2. Tambah refresh button untuk update manual
3. Tambah animasi saat tabel muncul
4. Export data ketersediaan slot (admin)
5. Real-time update dengan WebSocket
