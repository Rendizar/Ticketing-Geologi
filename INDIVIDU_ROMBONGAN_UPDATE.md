# Update Sistem Booking: Individu & Rombongan

## 📋 Ringkasan Perubahan

Sistem booking telah diperbarui dengan aturan baru untuk membedakan **Individu** dan **Rombongan** berdasarkan jumlah total pengunjung.

---

## 🎯 Aturan Baru

### 1. **Individu (1-19 orang)**
- ✅ Mencakup 1 sampai 19 orang
- ✅ **TIDAK** dibatasi jam kunjungan (bebas pilih tanggal)
- ✅ **TIDAK** wajib pilih slot waktu
- ✅ **TIDAK** wajib isi nama rombongan
- ✅ Form booking menggunakan **counter input** (sama seperti rombongan)
- ✅ Bisa kombinasi: Pelajar (TK/SD/SMP/SMA/Kuliah) + Umum + Asing
- ✅ Total maksimal: **19 orang**

### 2. **Rombongan (≥20 orang)**
- ✅ Mencakup 20 orang atau lebih
- ✅ **WAJIB** pilih slot waktu per jam (08:00 - 16:00)
- ✅ **WAJIB** isi nama rombongan (sekolah/perusahaan)
- ✅ Form booking menggunakan **counter input**
- ✅ Bisa kombinasi: Pelajar (TK/SD/SMP/SMA/Kuliah) + Umum + Asing
- ✅ Kuota per slot: **100 orang**

### 3. **Kapasitas Harian Maksimal**
- ✅ Total pengunjung per hari: **2.500 orang**
- ✅ Berlaku untuk gabungan Individu + Rombongan
- ✅ Sistem akan blokir booking jika kapasitas penuh

---

## 🔧 File yang Diubah

### 1. **resources/views/visitor/create.blade.php**

#### Form Individu (Lines ~136-210)
```blade
<!-- Individu (1-19 orang) -->
<div id="pengunjung_individu" style="display:none;">
    <!-- Counter input untuk Pelajar (TK/SD/SMP/SMA/Kuliah) -->
    <input type="number" id="individu_sub_tk" name="sub_tk" max="19" 
           oninput="validateNumberInput(this); checkIndividuLimit();">
    
    <!-- Counter input untuk Umum -->
    <input type="number" id="individu_jumlah_umum" name="jumlah_umum" max="19"
           oninput="validateNumberInput(this); checkIndividuLimit();">
    
    <!-- Counter input untuk Asing -->
    <input type="number" id="individu_jumlah_asing" name="jumlah_asing" max="19"
           oninput="validateNumberInput(this); checkIndividuLimit();">
    
    <!-- Total Display -->
    <div class="alert alert-success">
        <strong>Total Pengunjung:</strong> <span id="individu_total">0</span> orang (Maks: 19)
    </div>
</div>
```

#### JavaScript Functions (Lines ~600-750)

**1. `checkIndividuLimit()`** - Validasi maksimal 19 orang
```javascript
function checkIndividuLimit() {
    const fields = ['individu_sub_tk', 'individu_sub_sd', 'individu_sub_smp', 
                    'individu_sub_sma', 'individu_sub_kuliah', 'individu_jumlah_umum', 
                    'individu_jumlah_asing'];
    
    let total = 0;
    fields.forEach(fieldId => {
        const elem = document.getElementById(fieldId);
        if (elem) {
            total += parseInt(elem.value) || 0;
        }
    });
    
    // Update display
    document.getElementById('individu_total').textContent = total;
    
    // Alert jika melebihi 19
    if (total > 19) {
        alert('Maksimal 19 orang untuk Individu. Sistem akan otomatis alihkan ke Rombongan jika ≥20 orang.');
        // Auto-reduce to 19
    }
}
```

**2. `checkTotalPengunjungDanSlotWaktu()`** - Tampilkan slot waktu jika ≥20
```javascript
function checkTotalPengunjungDanSlotWaktu() {
    let totalPengunjung = 0;
    
    // Hitung dari counter individu atau rombongan
    if (jenisPemesanan === 'individu') {
        // Sum dari individu_sub_tk, individu_sub_sd, dst.
    } else if (jenisPemesanan === 'rombongan') {
        // Sum dari rombongan_sub_tk, rombongan_sub_sd, dst.
    }
    
    // Tampilkan slot waktu + nama rombongan jika ≥20
    if (totalPengunjung >= 20) {
        document.getElementById('slot_waktu_group').style.display = '';
        document.getElementById('slot_waktu').setAttribute('required', 'required');
        document.getElementById('nama_rombongan_group').style.display = '';
    } else {
        // Sembunyikan
    }
}
```

**3. `changeCount(id, delta)`** - Tombol +/- dengan limit
```javascript
function changeCount(id, delta) {
    const input = document.getElementById(id);
    let val = parseInt(input.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    
    // Limit untuk individu
    if (id.startsWith('individu_')) {
        const max = parseInt(input.getAttribute('max')) || 19;
        if (val > max) val = max;
        input.value = val;
        checkIndividuLimit();
        return;
    }
    
    input.value = val;
    checkTotalPengunjungDanSlotWaktu();
}
```

---

### 2. **app/Http/Controllers/BookingController.php**

#### Method `store()` (Lines ~60-100)

**Perubahan Perhitungan Pengunjung:**
```php
// OLD - Dropdown based (Individu)
if ($request->jenis_pemesanan === 'individu') {
    if ($request->kategori_individu === 'asing') {
        $jumlah_asing = 1;
    } elseif ($request->kategori_individu === 'umum') {
        if ($request->is_pelajar === 'pelajar') {
            $jumlah_pelajar = 1;
        } else {
            $jumlah_umum = 1;
        }
    }
}

// NEW - Counter based (Individu & Rombongan)
if ($request->jenis_pemesanan === 'individu') {
    $sub_tk = (int)($request->sub_tk ?? 0);
    $sub_sd = (int)($request->sub_sd ?? 0);
    $sub_smp = (int)($request->sub_smp ?? 0);
    $sub_sma = (int)($request->sub_sma ?? 0);
    $sub_kuliah = (int)($request->sub_kuliah ?? 0);
    
    $jumlah_pelajar = $sub_tk + $sub_sd + $sub_smp + $sub_sma + $sub_kuliah;
    $jumlah_umum  = (int)($request->jumlah_umum ?? 0);
    $jumlah_asing = (int)($request->jumlah_asing ?? 0);
    
    // Validasi maksimal 19
    $totalIndividu = $jumlah_pelajar + $jumlah_umum + $jumlah_asing;
    if ($totalIndividu > 19) {
        return back()->withInput()->with('error', 'Individu maksimal 19 orang.');
    }
} else {
    // Same logic for rombongan (no 19 limit)
}
```

**Klasifikasi Otomatis:**
```php
// Auto-determine based on total
$jenisPemesananAktual = $totalPengunjung >= 20 ? 'rombongan' : 'individu';
$namaRombongan = $totalPengunjung >= 20 ? ($request->nama_rombongan ?? null) : null;
```

**Validasi Slot Waktu:**
```php
if ($jenisPemesananAktual === 'rombongan') {
    if (!$request->slot_waktu) {
        return back()->with('error', 'Rombongan (≥20 orang) wajib memilih slot waktu!');
    }
    
    // Check kuota slot
    $quotaRecord = DailyGroupQuota::getOrCreate($tanggal, $slot_waktu, 100);
    if (!$quotaRecord->isAvailable($totalPengunjung)) {
        return back()->with('error', 'Slot waktu penuh!');
    }
}
```

---

## 📊 Database Schema

### Table: `daily_visitor_quotas`
```sql
CREATE TABLE daily_visitor_quotas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL UNIQUE,
    max_capacity INT NOT NULL DEFAULT 2500,
    total_booked INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Table: `daily_group_quotas`
```sql
CREATE TABLE daily_group_quotas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    slot_waktu VARCHAR(255) NOT NULL,
    quota INT NOT NULL DEFAULT 100,
    used INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_date_slot (tanggal, slot_waktu)
);
```

### Table: `bookings` - Field Tambahan
```sql
ALTER TABLE bookings ADD COLUMN slot_waktu VARCHAR(255) NULL AFTER tanggal_kunjungan;
```

---

## 🎨 UI/UX Changes

### Alert Boxes

**1. Kapasitas Harian (Top of Form)**
```html
<div class="alert alert-danger">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <strong>Kapasitas Maksimal:</strong> 2.500 pengunjung per hari
</div>
```

**2. Aturan Booking**
```html
<div class="alert alert-info">
    <strong>Individu (1-19 orang):</strong> Bebas pilih tanggal, tidak perlu slot waktu
    <br>
    <strong>Rombongan (≥20 orang):</strong> Wajib pilih slot waktu per jam
</div>
```

**3. Total Individu Counter**
```html
<div class="alert alert-success">
    <strong>Total Pengunjung:</strong> <span id="individu_total">0</span> orang (Maks: 19)
</div>
```

---

## ✅ Testing Checklist

### Individu (1-19 orang)
- [ ] Bisa input counter 1-19 orang (kombinasi pelajar/umum/asing)
- [ ] Alert muncul jika coba input >19 orang
- [ ] Slot waktu **TIDAK** muncul
- [ ] Nama rombongan **TIDAK** muncul
- [ ] Booking berhasil disimpan dengan `jenis_pemesanan_aktual = 'individu'`
- [ ] Harga dihitung benar sesuai kategori

### Rombongan (≥20 orang)
- [ ] Bisa input counter ≥20 orang
- [ ] Slot waktu **MUNCUL** otomatis saat total ≥20
- [ ] Nama rombongan **MUNCUL** otomatis saat total ≥20
- [ ] Dropdown slot waktu berisi 8 slot (08:00-16:00)
- [ ] Error muncul jika slot waktu kosong
- [ ] Booking berhasil disimpan dengan `slot_waktu` dan `nama_rombongan`
- [ ] Kuota slot berkurang setelah booking

### Kapasitas Harian
- [ ] Error muncul jika total booking hari itu sudah 2.500
- [ ] Sisa kuota ditampilkan di error message
- [ ] Kuota bertambah setelah payment success

---

## 🚀 Deployment Notes

1. **Jalankan Migration:**
   ```bash
   php artisan migrate
   ```

2. **Clear Cache:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

3. **Test Form:**
   - Akses `/booking/create`
   - Test input individu 1-19 orang
   - Test input rombongan ≥20 orang
   - Verify slot waktu muncul otomatis

4. **Verify Database:**
   ```sql
   SELECT * FROM daily_visitor_quotas WHERE tanggal = CURDATE();
   SELECT * FROM daily_group_quotas WHERE tanggal = CURDATE();
   SELECT * FROM bookings WHERE DATE(created_at) = CURDATE();
   ```

---

## 🐛 Troubleshooting

### Issue: Form individu tidak muncul
**Solution:** Clear view cache
```bash
php artisan view:clear
```

### Issue: Slot waktu tidak muncul saat ≥20
**Solution:** Check JavaScript console, pastikan `checkTotalPengunjungDanSlotWaktu()` terpanggil

### Issue: Error "slot_waktu required" untuk individu
**Solution:** Pastikan `checkTotalPengunjungDanSlotWaktu()` remove required saat <20

### Issue: Kuota tidak berkurang setelah booking
**Solution:** Check `PaymentController` apakah `DailyVisitorQuota::increment()` terpanggil

---

## 📝 Catatan Penting

1. **Backward Compatibility:**
   - Booking lama dengan `kategori_individu` masih bisa ditampilkan
   - Sistem baru hanya berlaku untuk booking baru

2. **Auto-Classification:**
   - Sistem otomatis klasifikasi `individu` vs `rombongan` berdasarkan total
   - User pilih `jenis_pemesanan` hanya sebagai UI hint
   - Backend pakai `jenisPemesananAktual` untuk logic final

3. **Quota Management:**
   - `DailyVisitorQuota` track total harian (2.500)
   - `DailyGroupQuota` track per slot (100)
   - Kedua quota dicek independent

---

**Terakhir Diupdate:** 31 Desember 2025  
**Versi:** 2.0  
**Author:** GitHub Copilot + Salik
