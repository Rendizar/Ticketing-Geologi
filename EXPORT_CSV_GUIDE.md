# Panduan Fitur Export XLSX Admin Dashboard

## 📊 Fitur Export yang Tersedia

### 1. **Export Penjualan Bulanan (Monthly Sales)**
- **Lokasi**: Card "Penjualan Tiket Per Bulan"
- **Tombol**: "Export XLSX" (hijau, sejajar dengan dropdown bulan/tahun)
- **Output**: 
  - Data harian untuk bulan yang dipilih
  - Kolom: Tanggal, Pelajar, Umum, Asing, Total
  - Total bulanan di bagian bawah
  - Format terstruktur dengan header, zebra striping, dan styling profesional
  - Format: `Penjualan_Tiket_Bulanan_YYYY_MM.xlsx`

### 2. **Export Laporan Tahunan (Yearly Report)**
- **Lokasi**: Section "Export Data Tahunan" (section baru di bawah stats sekunder)
- **Tombol**: "Export Laporan Tahunan (XLSX)"
- **Output**:
  - Data per bulan untuk tahun yang dipilih (12 bulan)
  - Kolom: Bulan, Pelajar, Umum, Asing, Total
  - Total tahunan di bagian bawah
  - Format terstruktur dengan styling profesional
  - Format: `Penjualan_Tiket_Tahunan_YYYY.xlsx`

### 3. **Export Prediksi Kunjungan (Forecast)**
- **Lokasi**: Card "Tren & Forecasting Kunjungan"
- **Tombol**: "Export XLSX" (hijau, di sebelah tombol periode)
- **Output**:
  - Data historis 60 hari terakhir (section terpisah)
  - Prediksi untuk periode yang dipilih (7/14/30 hari)
  - Confidence intervals (lower/upper) 95%
  - Ringkasan: rata-rata, total, tingkat pertumbuhan
  - Format multi-section dengan styling profesional
  - Format: `Prediksi_Kunjungan_X_Hari.xlsx`

## 🔧 Implementasi Teknis

### Backend (AdminController.php)
```php
// 3 Method export baru menggunakan PhpSpreadsheet:
- exportMonthlyXlsx()   // Export data bulanan dengan formatting
- exportYearlyXlsx()    // Export data tahunan dengan formatting
- exportForecastXlsx()  // Export prediksi AI dengan multi-section
- generateXlsxResponse() // Helper untuk generate XLSX response
```

### Routes (web.php)
```php
Route::get('/export/monthly-xlsx', [AdminController::class, 'exportMonthlyXlsx'])->name('admin.export.monthly');
Route::get('/export/yearly-xlsx', [AdminController::class, 'exportYearlyXlsx'])->name('admin.export.yearly');
Route::get('/export/forecast-xlsx', [AdminController::class, 'exportForecastXlsx'])->name('admin.export.forecast');
```

### Frontend (dashboard.blade.php)
```javascript
// JavaScript functions:
- exportMonthlyXlsx()         // Trigger export bulanan
- exportYearlyXlsx()          // Trigger export tahunan
- exportForecastXlsx()        // Trigger export prediksi
- initYearlyExportSelector()  // Init dropdown tahun
```

## 📋 Format XLSX Output

### 1. Monthly Sales XLSX
**Sheet: "Laporan Bulanan"**
- **Header Section**: Judul bold 16pt, centered, Museum info
- **Metadata**: Periode dan tanggal cetak (italic)
- **Data Table**: 
  - Header row: Background kuning (#FFD400), teks bold putih, border
  - Data rows: Zebra striping (abu-abu muda setiap baris genap)
  - Kolom: Tanggal (25 char) | Pelajar | Umum | Asing | Total (15 char each)
  - Alignment: Data centered, tanggal left-aligned
- **Total Row**: Background hitam (#0B0B0B), teks bold putih, border medium

### 2. Yearly Report XLSX
**Sheet: "Laporan Tahunan"**
- **Header Section**: Sama dengan monthly
- **Data Table**:
  - 12 baris data (Januari - Desember)
  - Zebra striping untuk readability
  - Format sama dengan monthly sales
- **Total Row**: Total tahunan semua kategori

### 3. Forecast XLSX
**Sheet: "Prediksi Kunjungan"**
- **Section 1 - Historical Data**:
  - Background abu-abu muda untuk section header
  - Tabel 2 kolom: Tanggal | Total Pengunjung
  - 60 baris data historis
- **Section 2 - Prediction Data**:
  - Catatan metode AI (italic, small font)
  - Tabel 4 kolom: Tanggal | Prediksi | Confidence Lower | Confidence Upper
  - Header kuning, zebra striping
- **Section 3 - Summary**:
  - Background hitam dengan teks putih
  - Ringkasan: rata-rata, total, growth rate

## ✨ Fitur Khusus

1. **Professional Styling**: Header bold, warna brand (kuning #FFD400, hitam #0B0B0B), border rapi
2. **Zebra Striping**: Baris genap dengan background abu-abu muda untuk readability
3. **Auto Column Width**: Lebar kolom disesuaikan dengan konten optimal
4. **Tanggal Indonesia**: Format tanggal otomatis dalam Bahasa Indonesia
5. **Responsive UI**: Tombol export sejajar dengan filter (monthly sales)
6. **Parameter Dinamis**: Semua export mengikuti filter yang dipilih user
7. **Linear Regression**: Forecast menggunakan algoritma prediksi dengan confidence intervals
8. **Multi-Section Layout**: Forecast terorganisir dalam 3 section berbeda
9. **Error Handling**: Try-catch dengan logging untuk troubleshooting
10. **File Icon**: Icon Excel (fa-file-excel) untuk visual cues

## 📱 Cara Penggunaan

### Export Bulanan:
1. Buka dashboard admin
2. Scroll ke section "Penjualan Tiket Per Bulan"
3. Pilih bulan dan tahun
4. Klik tombol "Export CSV"
5. File akan otomatis terdownload

### Export Tahunan:
1. Scroll ke section "Export Data Tahunan"
2. Pilih tahun dari dropdown
3. Klik "Export Laporan Tahunan (CSV)"
4. File akan otomatis terdownload

### Export Prediksi:
1. Scroll ke section "Tren & Forecasting Kunjungan"
2. Pilih periode prediksi (7/14/30 hari)
3. Klik tombol "Export"
4. File prediksi akan otomatis terdownload

## 🎨 Styling

**Tombol Export:**
- Class Bootstrap: `btn btn-sm btn-success` (monthly & forecast), `btn btn-success` (yearly)
- Icon: `fas fa-file-excel`
- Warna hijau (#28a745) untuk menandakan export action
- Posisi monthly sales: **Sejajar** dengan dropdown bulan/tahun (inline, bukan di bawah)

**XLSX Formatting:**
- Brand colors: Kuning #FFD400 (header), Hitam #0B0B0B (total row)
- Font: Bold untuk header dan total, Regular untuk data
- Alignment: Center untuk angka, Left untuk tanggal
- Border: Thin untuk data area, Medium untuk total row
- Fill: Zebra striping dengan #F9F9F9 untuk baris genap

## 🔒 Security Notes

- Semua route berada di dalam `admin` prefix (protected)
- Validasi input tahun/bulan untuk mencegah invalid data
- Error logging untuk monitoring
- Session-based admin authentication

## 📊 Data yang Diekspor

**Monthly/Yearly:**
- Jumlah tiket per kategori (Pelajar, Umum, Asing)
- Total harian/bulanan
- Aggregate totals

**Forecast:**
- Historical data 60 hari terakhir
- Prediksi berbasis Linear Regression
- Confidence intervals (95%)
- Metrics: rata-rata, total, growth rate

## 🚀 Testing

Untuk test fitur export:

```bash
# Start Laravel server
php artisan serve

# Access dashboard
http://localhost:8000/admin

# Test exports dengan berbagai parameter:
# - Monthly: pilih bulan/tahun berbeda
# - Yearly: pilih tahun berbeda
# - Forecast: ubah periode (7/14/30 hari)
```

## 📝 Catatan

- File XLSX kompatibel dengan Excel, Google Sheets, dan LibreOffice Calc
- Format native Excel (.xlsx) - buka langsung tanpa import
- Styling dan formatting otomatis terapply (tidak perlu format manual)
- Zebra striping untuk readability yang lebih baik
- Professional appearance untuk presentasi atau laporan resmi
- Library: PhpOffice/PhpSpreadsheet 5.3.0

---

**Dibuat**: 2 Desember 2025  
**Developer**: GitHub Copilot + User  
**Project**: Ticketing System Museum Geologi Bandung
