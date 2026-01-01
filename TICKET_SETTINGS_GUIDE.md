# Fitur Setting Harga Tiket Dinamis

## Deskripsi
Fitur ini memungkinkan admin untuk mengelola kategori tiket dan harga secara dinamis melalui dashboard admin tanpa perlu mengubah kode. Setiap perubahan harga akan tercatat dalam riwayat (history) dan tidak akan mempengaruhi transaksi yang sudah ada.

## Fitur Utama

### 1. **Harga Tiket Dinamis**
- Harga tiket disimpan di database (tabel `ticket_categories`)
- Admin dapat mengubah harga kapan saja melalui dashboard
- Perubahan harga tidak menimpa data transaksi lama

### 2. **Manajemen Kategori Tiket**
- Tambah kategori tiket baru
- Edit kategori tiket yang sudah ada
- Hapus kategori tiket
- Aktifkan/nonaktifkan kategori tiket
- Atur urutan tampilan kategori

### 3. **Riwayat Perubahan Harga**
- Setiap perubahan harga tercatat di tabel `ticket_price_history`
- Menampilkan:
  - Harga lama → Harga baru
  - Persentase kenaikan/penurunan
  - Admin yang mengubah
  - Waktu perubahan
  - Alasan perubahan (opsional)

## Struktur Database

### Tabel: `ticket_categories`
```sql
- id (bigint, primary key)
- name (string) - Nama kategori
- code (string, unique) - Kode kategori (auto-generated dari nama)
- price (decimal) - Harga tiket
- description (text, nullable) - Deskripsi kategori
- is_active (boolean) - Status aktif/non-aktif
- sort_order (integer) - Urutan tampilan
- created_at, updated_at
```

### Tabel: `ticket_price_history`
```sql
- id (bigint, primary key)
- ticket_category_id (foreign key) - ID kategori tiket
- old_price (decimal) - Harga lama
- new_price (decimal) - Harga baru
- changed_by (foreign key, nullable) - ID admin yang mengubah
- reason (text, nullable) - Alasan perubahan
- created_at, updated_at
```

## Cara Menggunakan

### 1. Setup Awal
```bash
# Jalankan migration
php artisan migrate

# Seed data kategori awal (Pelajar, Umum, Asing)
php artisan db:seed --class=TicketCategorySeeder
```

### 2. Akses Menu Setting
- Login sebagai admin
- Buka menu: **Dashboard Admin > Settings > Pengaturan Harga Tiket**
- URL: `/admin/settings/ticket-categories`

### 3. Menambah Kategori Baru
1. Klik tombol **"Tambah Kategori Baru"**
2. Isi form:
   - Nama Kategori (required)
   - Harga Tiket (required)
   - Deskripsi (opsional)
   - Urutan Tampilan (default: 0)
   - Status Aktif (checkbox)
3. Klik **"Simpan Kategori"**

### 4. Mengubah Harga Tiket
1. Klik tombol **Edit** pada kategori yang ingin diubah
2. Ubah harga tiket
3. Jika harga berubah, muncul field **"Alasan Perubahan Harga"** (opsional)
4. Klik **"Update Kategori"**
5. Perubahan akan tercatat dalam riwayat

### 5. Melihat Riwayat Perubahan Harga
1. Klik tombol **Riwayat** (icon jam) pada kategori
2. Lihat semua perubahan harga dalam bentuk timeline
3. Informasi yang ditampilkan:
   - Harga lama → Harga baru
   - Persentase perubahan
   - Admin yang mengubah
   - Tanggal & waktu perubahan
   - Alasan perubahan (jika ada)

## Routes

### Admin Settings Routes
```php
GET     /admin/settings/ticket-categories              # Daftar kategori
GET     /admin/settings/ticket-categories/create       # Form tambah kategori
POST    /admin/settings/ticket-categories              # Simpan kategori baru
GET     /admin/settings/ticket-categories/{id}/edit    # Form edit kategori
PUT     /admin/settings/ticket-categories/{id}         # Update kategori
DELETE  /admin/settings/ticket-categories/{id}         # Hapus kategori
GET     /admin/settings/ticket-categories/{id}/history # Riwayat perubahan harga
```

## Files yang Dibuat/Dimodifikasi

### Migrations
- `2025_12_30_153052_create_ticket_categories_table.php`
- `2025_12_30_153116_create_ticket_price_history_table.php`

### Models
- `app/Models/TicketCategory.php`
- `app/Models/TicketPriceHistory.php`

### Controllers
- `app/Http/Controllers/Admin/TicketCategoryController.php`

### Views
- `resources/views/admin/settings/ticket-categories/index.blade.php` - Daftar kategori
- `resources/views/admin/settings/ticket-categories/create.blade.php` - Form tambah
- `resources/views/admin/settings/ticket-categories/edit.blade.php` - Form edit
- `resources/views/admin/settings/ticket-categories/history.blade.php` - Riwayat harga

### Seeders
- `database/seeders/TicketCategorySeeder.php`

### Routes
- `routes/web.php` - Tambahan route untuk settings

## Keamanan Data Transaksi Lama

### Cara Kerja:
1. Ketika booking dibuat, harga diambil dari tabel `ticket_categories`
2. Harga tersebut disimpan dalam tabel `bookings` atau `payments`
3. Ketika admin mengubah harga di tabel `ticket_categories`, hanya kategori yang berubah
4. Data booking/payment lama tetap menggunakan harga saat transaksi dibuat

### Best Practice untuk Integrasi:
Saat membuat booking, simpan harga di tabel booking:
```php
// Contoh implementasi di BookingController
$category = TicketCategory::where('code', 'pelajar')->where('is_active', true)->first();
$priceAtBooking = $category->price;

Booking::create([
    'ticket_category_id' => $category->id,
    'price_paid' => $priceAtBooking, // Simpan harga saat booking
    // ... field lainnya
]);
```

## Contoh Penggunaan API

### Mendapatkan Semua Kategori Aktif
```php
use App\Models\TicketCategory;

$activeCategories = TicketCategory::active()->ordered()->get();
```

### Mendapatkan Harga Kategori Tertentu
```php
$pelajarPrice = TicketCategory::where('code', 'pelajar')
    ->where('is_active', true)
    ->value('price');
```

### Menyimpan Riwayat Perubahan Manual
```php
use App\Models\TicketPriceHistory;

TicketPriceHistory::create([
    'ticket_category_id' => $categoryId,
    'old_price' => 2000,
    'new_price' => 3000,
    'changed_by' => session('admin_id'),
    'reason' => 'Penyesuaian inflasi tahun 2025'
]);
```

## Troubleshooting

### Error: Foreign Key Constraint
Pastikan tabel `admins` sudah ada sebelum menjalankan migration `ticket_price_history`.

### Kategori Tidak Muncul di Form Booking
Periksa status `is_active` kategori. Hanya kategori dengan `is_active = true` yang akan ditampilkan.

### Perubahan Harga Tidak Tercatat
Pastikan admin sudah login dan session `admin_id` tersimpan dengan benar.

## Future Improvements

1. **Validasi Harga Minimum/Maximum**
   - Batasi range perubahan harga untuk menghindari error input

2. **Notifikasi Perubahan Harga**
   - Email notifikasi ke super admin saat harga berubah

3. **Approval System**
   - Perubahan harga butuh approval dari super admin

4. **Bulk Update**
   - Update harga beberapa kategori sekaligus

5. **Price Schedule**
   - Set harga berbeda untuk tanggal/musim tertentu

6. **Export/Import Kategori**
   - Import kategori dari Excel/CSV

## Support
Untuk pertanyaan atau bantuan, hubungi tim development.

---
**Created:** December 30, 2025
**Version:** 1.0.0
