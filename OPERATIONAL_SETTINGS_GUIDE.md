# Dokumentasi Pengaturan Operasional Museum

## Overview
Fitur ini memungkinkan admin untuk mengatur hari operasional dan jam buka/tutup museum melalui dashboard admin. Sistem juga otomatis memblokir pemesanan pada hari Jumat dan hari libur nasional Indonesia.

## Fitur Utama

### 1. Pengaturan Hari Operasional
- Admin dapat memilih hari-hari museum buka (Senin - Minggu)
- Konfigurasi dilakukan melalui checkbox di dashboard admin
- Pengaturan disimpan dalam database (`operational_settings`)

### 2. Pengaturan Jam Operasional
- **Jam Buka**: Default 09:00
- **Jam Tutup**: Default 16:00
- Validasi otomatis: jam tutup harus lebih dari jam buka

### 3. Pembatasan Pemesanan (Booking Restrictions)

#### Hari yang Tidak Tersedia untuk Booking:
1. **Setiap hari Jumat** - Museum tutup
2. **Hari Libur Nasional Indonesia** (tanggal merah)

#### Daftar Hari Libur Nasional 2025:
- 01 Januari 2025 - Tahun Baru Masehi
- 29 Januari 2025 - Tahun Baru Imlek
- 29 Maret 2025 - Hari Raya Nyepi
- 31 Maret 2025 - Isra Mi'raj Nabi Muhammad SAW
- 18 April 2025 - Wafat Isa Al-Masih
- 20 April 2025 - Paskah
- 01 Mei 2025 - Hari Buruh Internasional
- 12 Mei 2025 - Hari Raya Waisak
- 29 Mei 2025 - Kenaikan Isa Al-Masih
- 01 Juni 2025 - Hari Lahir Pancasila
- 17 Juni 2025 - Hari Raya Idul Fitri (cuti bersama)
- 18 Juni 2025 - Hari Raya Idul Fitri (cuti bersama)
- 17 Agustus 2025 - Hari Kemerdekaan RI
- 27 Agustus 2025 - Hari Raya Idul Adha
- 17 September 2025 - Tahun Baru Islam 1447 H
- 26 November 2025 - Maulid Nabi Muhammad SAW
- 25 Desember 2025 - Hari Raya Natal

## Struktur Database

### Tabel: `operational_settings`
```sql
CREATE TABLE operational_settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE,
    value TEXT,
    description VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Data yang Disimpan:
1. **operational_days**: Comma-separated hari operasional (misal: "monday,tuesday,wednesday,thursday,saturday,sunday")
2. **opening_time**: Jam buka dalam format HH:MM (misal: "09:00")
3. **closing_time**: Jam tutup dalam format HH:MM (misal: "16:00")

## Cara Kerja Sistem

### A. Pengaturan oleh Admin

#### Route:
```php
GET  /admin/settings/operational       -> Form pengaturan
PUT  /admin/settings/operational       -> Update pengaturan
```

#### Cara Mengakses:
1. Login sebagai admin
2. Klik menu **"Pengaturan Operasional"** di sidebar
3. Pilih hari-hari operasional dengan checkbox
4. Atur jam buka dan jam tutup
5. Klik **"Simpan Pengaturan"**

#### Validasi:
- Minimal 1 hari operasional harus dipilih
- Jam tutup harus lebih dari jam buka
- Format waktu harus valid (HH:MM)

### B. Pembatasan Booking untuk Pengunjung

#### Frontend (JavaScript):
File: `resources/views/visitor/create.blade.php`

```javascript
// Daftar tanggal disabled di-pass dari controller
const disabledDates = @json($disabledDates);

// Validasi saat user memilih tanggal
document.getElementById('tanggal_kunjungan_raw').addEventListener('change', function() {
    if (disabledDates.includes(this.value)) {
        alert('Museum tutup pada tanggal yang Anda pilih');
        this.value = '';
        return;
    }
});
```

#### Backend (Laravel):
File: `app/Http/Controllers/BookingController.php`

```php
use App\Helpers\HolidayHelper;
use Carbon\Carbon;

public function store(Request $request) {
    $tanggalKunjungan = Carbon::parse($request->tanggal_kunjungan);
    
    // VALIDASI: Cek apakah tanggal bisa di-booking
    if (!HolidayHelper::canBookOnDate($tanggalKunjungan)) {
        $message = HolidayHelper::getBookingRestrictionMessage($tanggalKunjungan);
        return back()->withInput()->with('error', $message);
    }
    
    // ... lanjutkan proses booking
}
```

## Helper Class: HolidayHelper

### Location:
`app/Helpers/HolidayHelper.php`

### Methods:

#### 1. `canBookOnDate(Carbon $date): bool`
Mengecek apakah user dapat booking di tanggal tertentu.

**Return:**
- `false` jika Jumat atau libur nasional
- `true` jika bisa booking

**Contoh:**
```php
use App\Helpers\HolidayHelper;
use Carbon\Carbon;

$date = Carbon::parse('2025-12-30');
if (HolidayHelper::canBookOnDate($date)) {
    echo "Tanggal tersedia untuk booking";
}
```

#### 2. `getDisabledDates(?Carbon $startDate, ?Carbon $endDate): array`
Mendapatkan array tanggal yang disabled untuk date picker.

**Return:**
```php
['2025-12-30', '2026-01-02', '2026-01-09', ...]
```

**Contoh:**
```php
// Get disabled dates untuk 3 bulan ke depan
$disabledDates = HolidayHelper::getDisabledDates();
```

#### 3. `getBookingRestrictionMessage(Carbon $date): string`
Mendapatkan pesan user-friendly kenapa tanggal tidak bisa dipilih.

**Return:**
- "Museum tutup setiap hari Jumat. Silakan pilih tanggal lain."
- "Museum tutup pada tanggal ini (Hari Raya Nyepi). Silakan pilih tanggal lain."

#### 4. `isNationalHoliday(Carbon $date): bool`
Mengecek apakah tanggal adalah hari libur nasional.

#### 5. `isFriday(Carbon $date): bool`
Mengecek apakah tanggal adalah hari Jumat.

## Filter Kategori Aktif

### Implementasi:
Hanya kategori tiket dengan `is_active = 1` yang ditampilkan di form booking.

**File:** `app/Http/Controllers/BookingController.php`

```php
public function create() {
    // Ambil HANYA kategori yang aktif
    $categories = TicketCategory::where('is_active', 1)
        ->orderBy('sort_order')
        ->get();
    
    return view('visitor.create', compact('categories'));
}

public function store(Request $request) {
    // Ambil harga dari kategori yang aktif saja
    $categories = TicketCategory::where('is_active', 1)
        ->get()
        ->keyBy('code');
    
    $hargaPelajar = $categories->get('pelajar')?->price ?? 0;
    // ...
}
```

### Cara Mengaktifkan/Nonaktifkan Kategori:
1. Login sebagai admin
2. Klik menu **"Kategori Tiket"**
3. Edit kategori yang ingin diubah
4. Centang/hapus centang **"Status Aktif"**
5. Klik **"Update Kategori"**

**Efek:**
- Kategori non-aktif tidak muncul di form booking pengunjung
- Kategori non-aktif tidak diproses dalam perhitungan harga

## Testing

### Test 1: Validasi Hari Jumat
```bash
# Via tinker
php artisan tinker

use App\Helpers\HolidayHelper;
use Carbon\Carbon;

$friday = Carbon::parse('2026-01-02'); // Jumat
HolidayHelper::canBookOnDate($friday);  // false
HolidayHelper::getBookingRestrictionMessage($friday); // "Museum tutup setiap hari Jumat..."
```

### Test 2: Validasi Libur Nasional
```bash
use Carbon\Carbon;

$nyepi = Carbon::parse('2025-03-29'); // Hari Raya Nyepi
HolidayHelper::canBookOnDate($nyepi);  // false
HolidayHelper::isNationalHoliday($nyepi); // true
```

### Test 3: Hari Normal
```bash
$monday = Carbon::parse('2025-12-29'); // Senin
HolidayHelper::canBookOnDate($monday);  // true
```

### Test 4: Filter Kategori Aktif
1. Set kategori "Pelajar" menjadi tidak aktif
2. Buka form booking (route: `/tickets/create`)
3. Kategori "Pelajar" tidak muncul di form
4. Coba booking dengan kategori tersebut via API/Postman → gagal (harga = 0)

## Update Tahunan

### Langkah Update Daftar Libur Nasional:

1. **Edit file:** `app/Helpers/HolidayHelper.php`

2. **Tambahkan tanggal libur tahun baru** di method `nationalHolidays()`:
```php
private static function nationalHolidays(): array
{
    return [
        // ... existing dates ...
        
        // 2026 (update setiap tahun)
        '2026-01-01', // Tahun Baru Masehi
        '2026-02-17', // Tahun Baru Imlek
        // dst...
    ];
}
```

3. **Update juga di** method `getHolidayName()`:
```php
$holidayNames = [
    // ... existing names ...
    
    // 2026
    '2026-01-01' => 'Tahun Baru Masehi',
    '2026-02-17' => 'Tahun Baru Imlek',
    // dst...
];
```

4. **Jalankan:**
```bash
composer dump-autoload
```

## File yang Terpengaruh

### Created:
1. `database/migrations/2025_12_30_163208_create_operational_settings_table.php`
2. `app/Models/OperationalSetting.php`
3. `app/Http/Controllers/Admin/OperationalSettingController.php`
4. `resources/views/admin/settings/operational/index.blade.php`

### Modified:
1. `app/Helpers/HolidayHelper.php` - Added booking validation methods
2. `app/Http/Controllers/BookingController.php` - Added date validation & active filter
3. `resources/views/visitor/create.blade.php` - Added disabled dates validation
4. `routes/web.php` - Added operational settings routes
5. `resources/views/layouts/admin.blade.php` - Added menu item

## Catatan Penting

⚠️ **Perbedaan dengan Price Update Restriction:**
- **Price Update**: Admin hanya bisa ubah harga di Jumat/libur nasional
- **Booking Restriction**: User TIDAK BISA booking di Jumat/libur nasional

📅 **Update Kalender Libur:**
Setiap awal tahun, update daftar hari libur nasional di `HolidayHelper.php` sesuai keputusan pemerintah.

🔒 **Validasi Ganda:**
- Frontend: Alert JavaScript saat user pilih tanggal terlarang
- Backend: Server-side validation di controller (primary security)

🎯 **Best Practice:**
Selalu gunakan `HolidayHelper::canBookOnDate()` untuk cek tanggal, jangan hardcode logic di controller.

## Support & Troubleshooting

### Issue: Tanggal masih bisa dipilih
**Solusi:** Clear browser cache, pastikan `$disabledDates` ter-pass ke view

### Issue: Alert tidak muncul
**Solusi:** Check JavaScript console, pastikan array `disabledDates` valid JSON

### Issue: Kategori non-aktif masih muncul
**Solusi:** Clear cache Laravel
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

---
**Last Updated:** 30 Desember 2025
**Version:** 1.0.0
