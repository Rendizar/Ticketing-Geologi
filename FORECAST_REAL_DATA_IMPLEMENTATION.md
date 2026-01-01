# Implementasi Forecasting dengan Data Real Database

## Ringkasan Perubahan

Fitur forecasting/prediksi telah diubah dari menggunakan **data dummy yang digenerate random** menjadi menggunakan **data real dari database** yang diambil secara real-time dan berkelanjutan.

## Perubahan File

### 1. Backend - AdminController.php

**File**: `app/Http/Controllers/AdminController.php`

#### Method Baru:

**a) `getForecastData(Request $request)`** (Line 1243)
- **Fungsi**: API endpoint untuk mengambil data historis dan forecast
- **Parameter Query String**:
  - `historical_days` (default: 60) - Jumlah hari data historis yang diambil
  - `forecast_days` (default: 7) - Jumlah hari forecast ke depan
- **Proses**:
  1. Query data dari tabel `bookings` dengan status `paid`
  2. Agregasi total pengunjung (pelajar + umum + asing + khusus) per tanggal
  3. Fill missing dates dengan nilai 0 (hari tanpa kunjungan)
  4. Panggil `calculateForecast()` untuk generate prediksi
  5. Return JSON dengan struktur:
```json
{
    "success": true,
    "historical": {
        "labels": ["12 Jan", "13 Jan", ...],
        "values": [150, 200, ...]
    },
    "forecast": {
        "labels": ["15 Feb", "16 Feb", ...],
        "values": [180, 195, ...],
        "sma": [...],
        "ema": [...],
        "linear": [...],
        "confidence_upper": [...],
        "confidence_lower": [...]
    },
    "statistics": {
        "avg_historical": 175.5,
        "avg_forecast": 187.2,
        "growth_rate": 6.7,
        "total_historical": 10530,
        "max_historical": 450,
        "min_historical": 50
    },
    "metadata": {
        "historical_days": 60,
        "forecast_days": 7,
        "start_date": "2024-12-15",
        "end_date": "2025-02-14",
        "forecast_start": "2025-02-15"
    }
}
```

**b) `calculateForecast($historicalData, $forecastDays)`** (Line 1305)
- **Fungsi**: Menghitung forecast menggunakan 4 algoritma berbeda
- **Algoritma yang Digunakan**:
  1. **Simple Moving Average (SMA)** - Rata-rata 7 hari terakhir
  2. **Exponential Moving Average (EMA)** - Weighted average dengan faktor k = 2/(n+1)
  3. **Linear Regression** - Trend analysis menggunakan least squares method
  4. **Ensemble** - Kombinasi weighted: 30% SMA + 30% EMA + 40% Linear
- **Confidence Intervals**: 95% confidence (±1.96 × standard deviation)
- **Fallback**: Jika data < 7 hari, return simple average

### 2. Routes - web.php

**File**: `routes/web.php` (Line 110)

```php
Route::get('/forecast/data', [AdminController::class, 'getForecastData'])
    ->name('admin.forecast.data');
```

### 3. Frontend - stats.blade.php

**File**: `resources/views/admin/stats.blade.php`

#### Function Baru/Diubah:

**a) `loadForecastData(historicalDays, forecastDays)` (async)**
- **Fungsi**: Fetch data dari API backend
- **Fallback**: Jika API gagal, gunakan `generateHistoricalDataFallback()`
- **Cache**: Menyimpan response di `forecastDataCache`
- **Loading State**: Flag `isLoadingForecast` untuk prevent duplicate calls

**b) `createForecastChart(days)` (async)**
- **Perubahan**: Sekarang async function yang await loadForecastData()
- **Logic**:
  - Jika API berhasil: gunakan data real dari server
  - Jika API gagal: fallback ke client-side calculation
- **Data yang Digunakan**:
  - Historical: 30 hari terakhir untuk ditampilkan
  - Forecast: n hari ke depan (7/14/30/90)
  - Confidence bands: upper & lower bounds

**c) `updateForecastMetricsFromAPI(apiData)`**
- **Fungsi**: Update UI metrics menggunakan data dari API
- **Metrics yang Di-update**:
  - Average Predicted
  - Growth Rate (dengan warna hijau/merah)
  - Accuracy (calculated)

**d) `updateAIInsightsFromAPI(apiData, days)`**
- **Fungsi**: Update AI insights panel menggunakan data real
- **Insights**:
  - Peak day prediction (hari puncak kunjungan)
  - Capacity warning (based on 2500 max capacity)
  - Weekend vs Weekday analysis

**e) `generateHistoricalDataFallback(days)`**
- **Fungsi**: Generate dummy data (HANYA untuk fallback jika API error)
- **Note**: Ini adalah rename dari function `generateHistoricalData()` lama

#### Initialization:

```javascript
document.addEventListener('DOMContentLoaded', async function() {
    // Load real data from API
    await loadForecastData(60, 7);
    
    // Create charts with real data
    await createForecastChart(7);
    createHeatmapChart();
    createMovingAverageChart();
});
```

## Alur Data Real-Time

```
1. User buka halaman Stats & Forecasting
   ↓
2. DOMContentLoaded event trigger
   ↓
3. loadForecastData() fetch dari API
   ↓
4. AdminController::getForecastData()
   ↓
5. Query bookings table (60 hari terakhir)
   ↓
6. Agregasi data per tanggal
   ↓
7. Fill missing dates dengan 0
   ↓
8. calculateForecast() dengan 4 algoritma
   ↓
9. Return JSON dengan historical + forecast + statistics
   ↓
10. Frontend update charts & metrics dengan data real
    ↓
11. Heatmap & Moving Average juga gunakan historicalData real
```

## Keuntungan Implementasi Baru

### ✅ Data Real & Akurat
- Data diambil langsung dari database bookings
- Tidak ada data random/dummy
- Reflect actual visitor patterns

### ✅ Real-Time & Berkelanjutan
- Setiap refresh halaman = data terbaru
- Tidak perlu seed/manual update
- Automatic dengan pertumbuhan data bookings

### ✅ Multiple Forecasting Methods
- 4 algoritma berbeda untuk accuracy
- Ensemble method untuk hasil terbaik
- Confidence intervals untuk uncertainty

### ✅ Comprehensive Statistics
- Growth rate calculation
- Historical trends
- Peak day detection
- Capacity planning

### ✅ Robust Error Handling
- Fallback ke client-side calculation jika API error
- Graceful degradation
- Loading states

## Testing Recommendations

1. **Test dengan Data Minimal**:
   ```
   - Buat < 7 hari bookings → should use average fallback
   ```

2. **Test dengan Data Normal**:
   ```
   - Buat 30-60 hari bookings → should show proper forecast
   ```

3. **Test Missing Dates**:
   ```
   - Buat bookings dengan gap tanggal → should fill with 0
   ```

4. **Test Different Periods**:
   ```
   - Switch antara 7/14/30/90 days → should reload API
   ```

5. **Test API Failure**:
   ```
   - Simulate network error → should fallback to dummy
   ```

## Database Query Performance

### Query yang Digunakan:
```sql
SELECT 
    tanggal_kunjungan,
    SUM(COALESCE(jumlah_pelajar, 0) + 
        COALESCE(jumlah_umum, 0) + 
        COALESCE(jumlah_asing, 0) + 
        COALESCE(jumlah_tiket_khusus, 0)) as total
FROM bookings
WHERE status = 'paid'
  AND tanggal_kunjungan BETWEEN ? AND ?
GROUP BY tanggal_kunjungan
ORDER BY tanggal_kunjungan
```

### Index Recommendations:
```sql
-- Untuk optimasi query
CREATE INDEX idx_bookings_tanggal_status 
ON bookings(tanggal_kunjungan, status);
```

## Configuration

### Default Values:
- **Historical Days**: 60 (2 bulan data)
- **Forecast Days**: 7 (default period)
- **Museum Capacity**: 2500 pengunjung/hari
- **Confidence Level**: 95% (z-score = 1.96)

### Weights untuk Ensemble:
- SMA: 30%
- EMA: 30%
- Linear Regression: 40%

## API Endpoint

**URL**: `/admin/forecast/data`  
**Method**: GET  
**Auth**: Required (admin middleware)  

**Query Parameters**:
- `historical_days` (optional, default: 60)
- `forecast_days` (optional, default: 7)

**Response**: JSON (see structure above)

## Backward Compatibility

- Client-side forecasting functions tetap ada sebagai fallback
- Jika API error, system otomatis switch ke calculation mode
- No breaking changes pada UI/UX

## Future Enhancements

1. **Cache Layer**: Redis cache untuk forecast results
2. **Advanced Algorithms**: ARIMA, Prophet, LSTM
3. **Seasonal Adjustment**: Holiday detection & adjustment
4. **External Factors**: Weather, events integration
5. **Batch Processing**: Pre-calculate forecasts via cron job

---

**Updated**: {{ date('Y-m-d H:i:s') }}  
**Version**: 2.0 - Real Database Implementation
