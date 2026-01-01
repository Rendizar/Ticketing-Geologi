# Testing Restriction Update Harga Tiket

## Quick Test
Buka Laravel Tinker untuk test:
```bash
php artisan tinker
```

Lalu jalankan:
```php
use App\Helpers\HolidayHelper;
use Carbon\Carbon;

// Cek hari ini
echo "Hari ini: " . Carbon::now()->isoFormat('dddd, D MMMM Y') . "\n";
echo "Apakah Jumat? " . (HolidayHelper::isFriday() ? 'Ya' : 'Tidak') . "\n";
echo "Apakah Libur Nasional? " . (HolidayHelper::isNationalHoliday() ? 'Ya' : 'Tidak') . "\n";
echo "Bisa Update Harga? " . (HolidayHelper::canUpdatePrice() ? 'YA ✅' : 'TIDAK ❌') . "\n";

if (!HolidayHelper::canUpdatePrice()) {
    echo "\nPesan: " . HolidayHelper::getUpdateRestrictionMessage() . "\n";
}

// Test hari Jumat berikutnya
$nextFriday = Carbon::now()->next(Carbon::FRIDAY);
echo "\n=== Test Jumat Berikutnya ===\n";
echo "Tanggal: " . $nextFriday->isoFormat('dddd, D MMMM Y') . "\n";
echo "Bisa Update? " . (HolidayHelper::canUpdatePrice($nextFriday) ? 'YA ✅' : 'TIDAK ❌') . "\n";

// Test hari libur nasional
echo "\n=== Test Libur Nasional ===\n";
$newYear = Carbon::parse('2025-01-01');
echo "1 Januari 2025: " . (HolidayHelper::isNationalHoliday($newYear) ? 'Libur ✅' : 'Bukan Libur ❌') . "\n";

$independence = Carbon::parse('2025-08-17');
echo "17 Agustus 2025: " . (HolidayHelper::isNationalHoliday($independence) ? 'Libur ✅' : 'Bukan Libur ❌') . "\n";
```

## Aturan Update Harga

### ✅ Boleh Update Harga Pada:
1. **Hari Jumat** - Setiap hari Jumat
2. **Hari Libur Nasional Indonesia**:
   - 1 Januari - Tahun Baru Masehi
   - 29 Januari - Tahun Baru Imlek
   - 29 Maret - Hari Raya Nyepi
   - 31 Maret - Isra Mi'raj
   - 18 April - Wafat Isa Al-Masih
   - 20 April - Paskah
   - 1 Mei - Hari Buruh
   - 12 Mei - Waisak
   - 29 Mei - Kenaikan Isa Al-Masih
   - 1 Juni - Hari Lahir Pancasila
   - 17 Juni - Idul Fitri (cuti bersama)
   - 18 Juni - Idul Fitri (cuti bersama)
   - 17 Agustus - Hari Kemerdekaan RI
   - 27 Agustus - Idul Adha
   - 17 September - Tahun Baru Islam
   - 26 November - Maulid Nabi
   - 25 Desember - Natal

### ❌ Tidak Boleh Update Harga:
- Senin sampai Kamis (bukan libur)
- Sabtu (bukan libur)
- Minggu (bukan libur)

## Alasan Pembatasan

1. **Mencegah Konflik**: Menghindari situasi dimana user sedang dalam proses booking/pembayaran saat harga berubah
2. **Waktu Sepi**: Jumat dan libur nasional biasanya waktu dengan traffic lebih rendah
3. **Predictability**: User tahu kapan harga bisa berubah
4. **Admin Planning**: Admin bisa merencanakan perubahan harga dengan baik

## Behavior di Form Edit

### Jika Hari Boleh Update (Jumat/Libur):
- ✅ Field harga ENABLED
- ✅ Tombol update berfungsi normal
- ℹ️ Ditampilkan info "Hari ini [nama hari/libur]. Anda dapat mengubah harga tiket"

### Jika Hari Tidak Boleh Update:
- ⚠️ Field harga READONLY (abu-abu)
- ⚠️ Badge "Terkunci" di label harga
- ⚠️ Alert warning dengan info kapan bisa update
- ❌ Jika tetap diubah (via inspect element), akan ditolak server-side
- ✅ Field lain (nama, deskripsi, status) tetap bisa diubah

## Update Daftar Libur

Untuk menambah/update daftar hari libur nasional, edit file:
```
app/Helpers/HolidayHelper.php
```

Pada method `nationalHolidays()`, tambahkan tanggal dengan format:
```php
'YYYY-MM-DD', // Nama Libur
```

**Ingat:** Update setiap awal tahun sesuai Keputusan Bersama (SKB) 3 Menteri tentang Hari Libur Nasional!

---
**Created:** December 30, 2025
**Version:** 1.0.0
