@extends('layouts.admin')
@section('title', 'Admin Dashboard - Advanced Analytics')
@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>
<div class="container-fluid dashboard-content">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="brand-text dashboard-title-outline mb-3">
                <i class="bi bi-graph-up-arrow me-3"></i>Dashboard Analytics
            </h1>
            <p class="subtitle-text"><strong>Sistem Analitik & Forecasting Museum Geologi Bandung</strong></p>
        </div>
    </div>
   
    <!-- SECTION 1: DATA UMUM (General Statistics) -->
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-calendar-day"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($kunjungan_hari_ini) }}</h2>
                    <p class="stat-label">Kunjungan Hari Ini</p>
                    <div class="stat-date">{{ now()->format('d F Y') }}</div>
                    <div class="trend-indicator positive">
                        <i class="bi bi-arrow-up"></i> <span id="todayTrend">+0%</span>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-pelajar">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($total_per_kategori->pelajar ?? 0) }}</h2>
                    <p class="stat-label">Total Pelajar</p>
                    <div class="stat-date">Semua Jenjang</div>
                    <div class="trend-indicator positive">
                        <i class="bi bi-arrow-up"></i> <span id="studentTrend">+0%</span>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-umum">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($total_per_kategori->umum ?? 0) }}</h2>
                    <p class="stat-label">Total Umum</p>
                    <div class="stat-date">Pengunjung Dewasa</div>
                    <div class="trend-indicator positive">
                        <i class="bi bi-arrow-up"></i> <span id="publicTrend">+0%</span>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-asing">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($total_per_kategori->asing ?? 0) }}</h2>
                    <p class="stat-label">Wisatawan Asing</p>
                    <div class="stat-date">Mancanegara</div>
                    <div class="trend-indicator positive">
                        <i class="bi bi-arrow-up"></i> <span id="foreignTrend">+0%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Rata-rata Harian
                </div>
                <div class="card-body">
                    <div class="stat-item-large">
                        <div class="stat-icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ number_format($avg_daily, 1) }}</h3>
                            <p class="stat-desc">pengunjung/hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-calendar-check me-2"></i>
                    Bulan Ini
                </div>
                <div class="card-body">
                    <div class="stat-item-large">
                        <div class="stat-icon">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ number_format($kunjungan_bulan_ini ?? 0) }}</h3>
                            <p class="stat-desc">{{ now()->format('F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-database me-2"></i>
                    Total Keseluruhan
                </div>
                <div class="card-body">
                    <div class="stat-item-large">
                        <div class="stat-icon">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ number_format($total_pengunjung ?? 0) }}</h3>
                            <p class="stat-desc">pengunjung</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-lightning-fill me-2"></i>
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary w-100 py-3" style="border-radius: 0.75rem;">
                                <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                                <span class="d-block fw-bold">Tambah Event</span>
                                <small class="d-block text-white-50">Buat event baru</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-success w-100 py-3" style="border-radius: 0.75rem;">
                                <i class="bi bi-calendar-check fs-3 d-block mb-2"></i>
                                <span class="d-block fw-bold">Kelola Event</span>
                                <small class="d-block text-white-50">Lihat & edit event</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-info w-100 py-3" style="border-radius: 0.75rem;">
                                <i class="bi bi-ticket-detailed fs-3 d-block mb-2"></i>
                                <span class="d-block fw-bold">Kelola Tiket</span>
                                <small class="d-block text-white-50">Lihat pemesanan</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.stats') }}" class="btn btn-warning w-100 py-3" style="border-radius: 0.75rem;">
                                <i class="bi bi-graph-up-arrow fs-3 d-block mb-2"></i>
                                <span class="d-block fw-bold">Statistik</span>
                                <small class="d-block text-white-50">Lihat laporan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: PENJUALAN TIKET PER BULAN -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cash-coin me-2"></i>
                        <span>Penjualan Tiket Per Bulan</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <select id="salesMonth" class="form-select" style="min-width: 150px; max-width: 180px;"></select>
                        <select id="salesYear" class="form-select" style="min-width: 110px; max-width: 130px;"></select>
                        <button type="button" class="btn btn-success" onclick="exportMonthlyXlsx()" style="border-radius: 0.5rem !important; white-space: nowrap;">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export XLSX
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="monthlySalesChart" height="90"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Data Tahunan -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-download me-2"></i>
                    Export Data Tahunan
                </div>
                <div class="card-body">
                    <div class="row align-items-center g-3">
                        <div class="col-auto">
                            <label for="exportYear" class="form-label mb-0 fw-bold">Pilih Tahun:</label>
                        </div>
                        <div class="col-auto">
                            <select id="exportYear" class="form-select" style="min-width: 140px;"></select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-success" onclick="exportYearlyXlsx()">
                                <i class="bi bi-file-earmark-excel me-2"></i>Export Laporan Tahunan (XLSX)
                            </button>
                        </div>
                        <div class="col">
                            <small class="text-muted">Export data penjualan tiket per bulan dalam satu tahun</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: DISTRIBUSI & ANALISIS TENGAH -->
    <div class="row g-4 mb-4">
        <!-- Distribusi Kategori Pengunjung -->
        <div class="col-xl-8">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-pie-chart-fill me-2"></i>
                    Distribusi Kategori Pengunjung
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="80"></canvas>
                </div>
            </div>
        </div>
        <!-- Persentase Kategori -->
        <div class="col-xl-4">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-pie-chart me-2"></i>
                    Persentase Kategori
                </div>
                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Heatmap & Moving Average -->
    <div class="row g-4 mb-4">
        <!-- Heatmap Kunjungan per Hari -->
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-fill me-2"></i>
                    Heatmap Kunjungan (Hari dalam Seminggu)
                </div>
                <div class="card-body">
                    <canvas id="heatmapChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <!-- Moving Average Chart -->
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-graph-up me-2"></i>
                    Moving Average Trend (7 & 30 Hari)
                </div>
                <div class="card-body">
                    <canvas id="movingAverageChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Provinsi & Detail Pelajar -->
    <div class="row g-4 mb-4">
        <!-- Top Provinsi -->
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-geo-alt-fill me-2"></i>
                    Top 10 Provinsi
                </div>
                <div class="card-body">
                    <canvas id="provinceChart" height="120"></canvas>
                </div>
            </div>
        </div>
       
        <!-- Detail Pelajar -->
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    Detail Kategori Pelajar
                </div>
                <div class="card-body">
                    <canvas id="studentChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: FORECASTING (Paling Akhir) -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-graph-up me-2"></i>
                        <span>Tren & Forecasting Kunjungan</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-warning active" onclick="changeForecastPeriod(7)">7 Hari</button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="changeForecastPeriod(14)">14 Hari</button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="changeForecastPeriod(30)">30 Hari</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-success" onclick="exportForecastXlsx()" title="Export Prediksi XLSX">
                            <i class="bi bi-file-earmark-excel me-1"></i>Export XLSX
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="forecastChart" height="80"></canvas>
                    <div class="forecast-info mt-3">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="forecast-metric">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    <h5 id="predictedAvg">0</h5>
                                    <small>Rata-rata Prediksi</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="forecast-metric">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <h5 id="growthRate">0%</h5>
                                    <small>Pertumbuhan</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="forecast-metric">
                                    <i class="bi bi-percent"></i>
                                    <h5 id="accuracy">0%</h5>
                                    <small>Akurasi Model</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-cpu me-2"></i>
                    AI Insights & Rekomendasi
                </div>
                <div class="card-body">
                    <div class="insight-item">
                        <div class="insight-icon success">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="insight-content">
                            <h6>Peak Day Prediction</h6>
                            <p id="peakDayInsight">Memuat prediksi...</p>
                        </div>
                    </div>
                    <div class="insight-item">
                        <div class="insight-icon warning">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="insight-content">
                            <h6>Capacity Alert</h6>
                            <p id="capacityInsight">Memuat analisis...</p>
                        </div>
                    </div>
                    <div class="insight-item">
                        <div class="insight-icon info">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div class="insight-content">
                            <h6>Seasonal Pattern</h6>
                            <p id="seasonalInsight">Menganalisis pola...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('styles')
<style>
    :root {
        --mg-yellow: #FFD400;
        --mg-black: #0b0b0b;
        --mg-white: #ffffff;
        --mg-muted: #6c6c6c;
    }
    /* Particles Background */
    #particles-js {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .dashboard-content {
        position: relative;
        z-index: 1;
        padding: 2rem;
    }
    /* Brand Text */
    .brand-text {
        font-family: 'Montserrat', 'Futura PT', 'Century Gothic', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: var(--mg-black);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        animation: fadeInDown 0.8s ease-out;
    }
    
    .dashboard-title-outline {
        -webkit-text-stroke: 3px var(--mg-yellow);
        text-stroke: 3px var(--mg-yellow);
        paint-order: stroke fill;
    }
    
    .brand-text i {
        color: var(--mg-yellow);
    }
    .subtitle-text {
        color: var(--mg-muted);
        font-size: 1.1rem;
        font-weight: 500;
    }
    /* Statistics Cards */
    .stat-card {
        background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%) !important;
        color: var(--mg-black) !important;
        border: 3px solid var(--mg-black) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: fadeInUp 0.8s ease-out;
        position: relative;
        overflow: visible;
        height: 100%;
    }
    .stat-card .card-body {
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 240px;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.4s;
    }
    .stat-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 20px 50px rgba(255, 212, 0, 0.5);
    }
    .stat-card:hover::before {
        opacity: 1;
        animation: rotate 3s linear infinite;
    }
    .stat-card-pelajar {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%) !important;
        color: white !important;
    }
    .stat-card-umum {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%) !important;
        color: white !important;
    }
    .stat-card-asing {
        background: linear-gradient(135deg, #FF5722 0%, #E64A19 100%) !important;
        color: white !important;
    }
    .trend-indicator {
        margin-top: 0.75rem;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
    }
    .trend-indicator.positive {
        background: rgba(76, 175, 80, 0.2);
        color: #2e7d32;
    }
    .trend-indicator.negative {
        background: rgba(244, 67, 54, 0.2);
        color: #c62828;
    }
    .stat-card-pelajar .trend-indicator.positive,
    .stat-card-umum .trend-indicator.positive,
    .stat-card-asing .trend-indicator.positive {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }
    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        background: var(--mg-black);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 20px rgba(11, 11, 11, 0.4);
        transition: all 0.3s ease;
    }
    .stat-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(360deg);
    }
    .icon-wrapper i {
        font-size: 2.2rem;
        color: var(--mg-yellow);
    }
    .stat-card-pelajar .icon-wrapper,
    .stat-card-umum .icon-wrapper,
    .stat-card-asing .icon-wrapper {
        background: rgba(255, 255, 255, 0.3);
    }
    .stat-card-pelajar .icon-wrapper i,
    .stat-card-umum .icon-wrapper i,
    .stat-card-asing .icon-wrapper i {
        color: white;
    }
    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        margin: 0.5rem 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        animation: countUp 1s ease-out;
    }
    .stat-label {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .stat-date {
        font-size: 0.85rem;
        opacity: 0.8;
        font-weight: 600;
        margin-top: 0.25rem;
    }
    /* Detail Cards */
    .detail-card {
        background: var(--mg-white) !important;
        border: 2px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
        animation: fadeIn 1s ease-out;
        min-height: 100%;
    }
    .detail-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        transform: translateY(-5px);
    }
    .detail-card .card-header {
        background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%);
        color: var(--mg-yellow);
        border-bottom: 3px solid var(--mg-yellow);
        font-weight: 700;
        font-size: 1.15rem;
        letter-spacing: 0.05em;
        border-radius: 1.25rem 1.25rem 0 0 !important;
        padding: 1.25rem 1.5rem;
    }
    .detail-card .card-body {
        padding: 1.5rem;
    }
    /* Forecast Info */
    .forecast-info {
        background: linear-gradient(135deg, rgba(255, 212, 0, 0.1) 0%, rgba(255, 212, 0, 0.05) 100%);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 2px solid rgba(255, 212, 0, 0.3);
    }
    .forecast-metric {
        padding: 1rem;
    }
    .forecast-metric i {
        font-size: 2rem;
        color: var(--mg-yellow);
        margin-bottom: 0.5rem;
    }
    .forecast-metric h5 {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--mg-black);
        margin: 0.5rem 0;
    }
    .forecast-metric small {
        color: var(--mg-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    /* AI Insights */
    .insight-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--mg-yellow);
        transition: all 0.3s ease;
    }
    .insight-item:hover {
        background: rgba(255, 212, 0, 0.1);
        transform: translateX(5px);
    }
    .insight-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .insight-icon.success {
        background: rgba(76, 175, 80, 0.2);
        color: #4CAF50;
    }
    .insight-icon.warning {
        background: rgba(255, 152, 0, 0.2);
        color: #FF9800;
    }
    .insight-icon.info {
        background: rgba(33, 150, 243, 0.2);
        color: #2196F3;
    }
    .insight-content h6 {
        font-weight: 700;
        color: var(--mg-black);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }
    .insight-content p {
        color: var(--mg-muted);
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.4;
    }
    /* Button Group */
    .btn-outline-warning {
        color: var(--mg-yellow);
        border-color: var(--mg-yellow);
        font-weight: 600;
        font-size: 0.85rem;
    }
    .btn-outline-warning:hover,
    .btn-outline-warning.active {
        background: var(--mg-yellow);
        color: var(--mg-black);
        border-color: var(--mg-yellow);
    }
    
    /* Export Button Styling */
    .btn-success {
        border-radius: 8px !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.4);
    }
    
    .card-header .btn-success {
        border-radius: 8px !important;
    }
    /* Stat Item Large */
    .stat-item-large {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(255, 212, 0, 0.1) 0%, rgba(255, 212, 0, 0.05) 100%);
        border-radius: 1rem;
        border-left: 6px solid var(--mg-yellow);
    }
    .stat-icon {
        width: 70px;
        height: 70px;
        background: var(--mg-black);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon i {
        font-size: 2rem;
        color: var(--mg-yellow);
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--mg-black);
        margin-bottom: 0;
        line-height: 1;
    }
    .stat-desc {
        font-size: 1rem;
        color: var(--mg-muted);
        margin-bottom: 0;
        font-weight: 600;
        margin-top: 0.5rem;
    }
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes countUp {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    /* Responsive */
    @media (max-width: 768px) {
        .brand-text {
            font-size: 2rem;
        }
        .stat-number {
            font-size: 2.2rem;
        }
        .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        .icon-wrapper i {
            font-size: 1.75rem;
        }
        .dashboard-content {
            padding: 1rem;
        }
        .btn-group .btn {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
        }
    }
</style>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Initialize Particles
particlesJS('particles-js', {
    particles: {
        number: {
            value: 60,
            density: {
                enable: true,
                value_area: 800
            }
        },
        color: {
            value: ['#FFD400', '#6c6c6c', '#0b0b0b']
        },
        shape: {
            type: 'polygon',
            stroke: {
                width: 1,
                color: '#6c6c6c'
            },
            polygon: {
                nb_sides: 6
            }
        },
        opacity: {
            value: 0.6,
            random: true,
            anim: {
                enable: false
            }
        },
        size: {
            value: 12,
            random: true,
            anim: {
                enable: false
            }
        },
        line_linked: {
            enable: true,
            distance: 150,
            color: '#6c6c6c',
            opacity: 0.4,
            width: 1
        },
        move: {
            enable: true,
            speed: 3,
            direction: 'none',
            out_mode: 'out'
        }
    },
    interactivity: {
        detect_on: 'canvas',
        events: {
            onhover: {
                enable: true,
                mode: 'grab'
            },
            onclick: {
                enable: true,
                mode: 'push'
            },
            resize: true
        },
        modes: {
            grab: {
                distance: 140,
                line_linked: {
                    opacity: 0.5
                }
            },
            push: {
                particles_nb: 4
            }
        }
    },
    retina_detect: true
});
// Chart.js Data
const pelajarTotal = {{ $total_per_kategori->pelajar ?? 0 }};
const umumTotal = {{ $total_per_kategori->umum ?? 0 }};
const asingTotal = {{ $total_per_kategori->asing ?? 0 }};
const tkTotal = {{ $sub_pelajar->tk ?? 0 }};
const sdTotal = {{ $sub_pelajar->sd ?? 0 }};
const smpTotal = {{ $sub_pelajar->smp ?? 0 }};
const smaTotal = {{ $sub_pelajar->sma ?? 0 }};
const kuliahTotal = {{ $sub_pelajar->kuliah ?? 0 }};
const provinsiData = @json($per_provinsi);
// ============================================================================
// ADVANCED FORECASTING FUNCTIONS
// ============================================================================
/**
 * Simple Moving Average (SMA) Calculation
 */
function calculateSMA(data, period) {
    const result = [];
    for (let i = 0; i < data.length; i++) {
        if (i < period - 1) {
            result.push(null);
        } else {
            let sum = 0;
            for (let j = 0; j < period; j++) {
                sum += data[i - j];
            }
            result.push(sum / period);
        }
    }
    return result;
}
/**
 * Exponential Moving Average (EMA) Calculation
 */
function calculateEMA(data, period) {
    const k = 2 / (period + 1);
    const emaData = [data[0]];
   
    for (let i = 1; i < data.length; i++) {
        emaData.push(data[i] * k + emaData[i - 1] * (1 - k));
    }
   
    return emaData;
}
/**
 * Linear Regression Forecast
 */
function linearRegression(data, forecastDays) {
    const n = data.length;
    let sumX = 0, sumY = 0, sumXY = 0, sumX2 = 0;
   
    for (let i = 0; i < n; i++) {
        sumX += i;
        sumY += data[i];
        sumXY += i * data[i];
        sumX2 += i * i;
    }
   
    const slope = (n * sumXY - sumX * sumY) / (n * sumX2 - sumX * sumX);
    const intercept = (sumY - slope * sumX) / n;
   
    const forecast = [];
    for (let i = n; i < n + forecastDays; i++) {
        forecast.push(Math.max(0, slope * i + intercept));
    }
   
    return { forecast, slope, intercept };
}
/**
 * Holt-Winters Exponential Smoothing (Simplified)
 */
function holtWintersForecast(data, forecastDays, alpha = 0.3, beta = 0.1, gamma = 0.1, seasonLength = 7) {
    const level = [data[0]];
    const trend = [data[1] - data[0]];
    const seasonal = new Array(seasonLength).fill(1);
   
    // Initialize seasonal components
    for (let i = 0; i < seasonLength && i < data.length; i++) {
        const avgVal = data.reduce((a, b) => a + b, 0) / data.length;
        seasonal[i] = avgVal !== 0 ? data[i] / avgVal : 1;
    }
   
    // Calculate level, trend, and seasonal components
    for (let i = 1; i < data.length; i++) {
        const seasonalIndex = i % seasonLength;
        const seasonalVal = seasonal[seasonalIndex] || 1;
       
        const newLevel = alpha * (data[i] / seasonalVal) + (1 - alpha) * (level[i - 1] + trend[i - 1]);
        const newTrend = beta * (newLevel - level[i - 1]) + (1 - beta) * trend[i - 1];
        seasonal[seasonalIndex] = gamma * (data[i] / newLevel) + (1 - gamma) * seasonalVal;
       
        level.push(newLevel);
        trend.push(newTrend);
    }
   
    // Generate forecast
    const forecast = [];
    const lastLevel = level[level.length - 1];
    const lastTrend = trend[trend.length - 1];
   
    for (let i = 1; i <= forecastDays; i++) {
        const seasonalIndex = (data.length + i - 1) % seasonLength;
        const predicted = (lastLevel + i * lastTrend) * seasonal[seasonalIndex];
        forecast.push(Math.max(0, predicted));
    }
   
    return forecast;
}
/**
 * Polynomial Regression Forecast
 */
function polynomialRegression(data, forecastDays, degree = 2) {
    const n = data.length;
   
    if (degree === 2) {
        let sumX = 0, sumY = 0, sumX2 = 0, sumX3 = 0, sumX4 = 0, sumXY = 0, sumX2Y = 0;
       
        for (let i = 0; i < n; i++) {
            const x = i, y = data[i];
            sumX += x;
            sumY += y;
            sumX2 += x * x;
            sumX3 += x * x * x;
            sumX4 += x * x * x * x;
            sumXY += x * y;
            sumX2Y += x * x * y;
        }
       
        const denom = (n * sumX4 - sumX2 * sumX2);
        const a = denom !== 0 ? (n * sumX2Y - sumX2 * sumY) / denom : 0;
        const b = sumX2 !== 0 ? (sumXY - a * sumX3) / sumX2 : 0;
        const c = n !== 0 ? (sumY - b * sumX - a * sumX2) / n : 0;
       
        const forecast = [];
        for (let i = n; i < n + forecastDays; i++) {
            forecast.push(Math.max(0, a * i * i + b * i + c));
        }
       
        return forecast;
    }
   
    return linearRegression(data, forecastDays).forecast;
}
/**
 * AutoRegressive Forecast
 */
function autoRegressiveForecast(data, forecastDays, lag = 5) {
    const coefficients = [];
   
    // Calculate AR coefficients
    for (let i = 0; i < lag; i++) {
        let sumXY = 0, sumX2 = 0;
        for (let j = lag; j < data.length; j++) {
            sumXY += data[j] * data[j - i - 1];
            sumX2 += data[j - i - 1] * data[j - i - 1];
        }
        coefficients.push(sumX2 !== 0 ? sumXY / sumX2 : 0);
    }
   
    // Generate forecast
    const forecast = [];
    const extended = [...data];
   
    for (let i = 0; i < forecastDays; i++) {
        let predicted = 0;
        for (let j = 0; j < lag; j++) {
            if (extended.length - j - 1 >= 0) {
                predicted += coefficients[j] * extended[extended.length - j - 1];
            }
        }
        predicted = Math.max(0, predicted / lag);
        forecast.push(predicted);
        extended.push(predicted);
    }
   
    return forecast;
}
/**
 * Ensemble Forecast
 */
function ensembleForecast(data, forecastDays) {
    const linear = linearRegression(data, forecastDays).forecast;
    const holtWinters = holtWintersForecast(data, forecastDays, 0.3, 0.1, 0.1, 7);
    const polynomial = polynomialRegression(data, forecastDays, 2);
    const autoReg = autoRegressiveForecast(data, forecastDays, 5);
   
    // Weighted ensemble (you can adjust weights based on historical accuracy)
    const weights = {
        linear: 0.2,
        holtWinters: 0.35,
        polynomial: 0.25,
        autoReg: 0.2
    };
   
    const ensemble = [];
    for (let i = 0; i < forecastDays; i++) {
        const value =
            linear[i] * weights.linear +
            holtWinters[i] * weights.holtWinters +
            polynomial[i] * weights.polynomial +
            autoReg[i] * weights.autoReg;
        ensemble.push(Math.max(0, value));
    }
   
    return ensemble;
}
/**
 * Calculate MAPE (Mean Absolute Percentage Error)
 */
function calculateMAPE(actual, predicted) {
    let sum = 0;
    let count = 0;
   
    for (let i = 0; i < Math.min(actual.length, predicted.length); i++) {
        if (actual[i] !== 0) {
            sum += Math.abs((actual[i] - predicted[i]) / actual[i]);
            count++;
        }
    }
   
    return count > 0 ? (100 - (sum / count) * 100) : 0;
}
/**
 * Calculate RMSE (Root Mean Square Error)
 */
function calculateRMSE(actual, predicted) {
    let sum = 0;
    const n = Math.min(actual.length, predicted.length);
   
    for (let i = 0; i < n; i++) {
        sum += Math.pow(actual[i] - predicted[i], 2);
    }
   
    return Math.sqrt(sum / n);
}
/**
 * Generate synthetic historical data (replace with actual data from backend)
 */
function generateHistoricalData(days = 60) {
    const baseValue = {{ $avg_daily ?? 100 }};
    const data = [];
   
    for (let i = 0; i < days; i++) {
        // Weekly seasonality (weekends busier)
        const dayOfWeek = i % 7;
        const weekendBoost = (dayOfWeek === 5 || dayOfWeek === 6) ? 1.4 : 1.0;
       
        // Monthly trend (sine wave)
        const monthlyTrend = Math.sin(i / 30 * Math.PI) * 20;
       
        // Growth trend
        const growthTrend = i * 1.5;
       
        // Random noise
        const noise = (Math.random() - 0.5) * 35;
       
        // Special events simulation (every 15 days)
        const specialEvent = (i % 15 === 0) ? 1.25 : 1.0;
       
        const value = (baseValue + monthlyTrend + growthTrend + noise) * weekendBoost * specialEvent;
        data.push(Math.max(50, Math.round(value)));
    }
   
    return data;
}
/**
 * Generate date labels
 */
function generateDateLabels(startDate, days) {
    const labels = [];
    const date = new Date(startDate);
   
    for (let i = 0; i < days; i++) {
        labels.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }));
        date.setDate(date.getDate() + 1);
    }
   
    return labels;
}
/**
 * Detect Seasonality
 */
function detectSeasonality(data, period = 7) {
    const patterns = [];
   
    for (let offset = 0; offset < period; offset++) {
        let sum = 0;
        let count = 0;
       
        for (let i = offset; i < data.length; i += period) {
            sum += data[i];
            count++;
        }
       
        patterns.push(count > 0 ? sum / count : 0);
    }
   
    return patterns;
}
/**
 * Detect Anomalies
 */
function detectAnomalies(data, threshold = 2) {
    const mean = data.reduce((a, b) => a + b, 0) / data.length;
    const stdDev = Math.sqrt(data.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / data.length);
   
    const anomalies = [];
    data.forEach((val, i) => {
        const zScore = Math.abs((val - mean) / stdDev);
        if (zScore > threshold) {
            anomalies.push({ index: i, value: val, zScore: zScore });
        }
    });
   
    return anomalies;
}
/**
 * Find Peak Day in Forecast
 */
function findPeakDay(forecast, startDay = 0) {
    const maxValue = Math.max(...forecast);
    const maxIndex = forecast.indexOf(maxValue);
    return { day: startDay + maxIndex + 1, value: maxValue };
}
/**
 * Calculate Confidence Intervals
 */
function calculateConfidenceIntervals(forecast, historicalData, confidenceLevel = 0.95) {
    const mean = historicalData.reduce((a, b) => a + b, 0) / historicalData.length;
    const variance = historicalData.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / historicalData.length;
    const stdDev = Math.sqrt(variance);
   
    const zScore = confidenceLevel === 0.95 ? 1.96 : 2.576;
   
    const upperBound = forecast.map((val, i) => val + zScore * stdDev * Math.sqrt(i + 1));
    const lowerBound = forecast.map((val, i) => Math.max(0, val - zScore * stdDev * Math.sqrt(i + 1)));
   
    return { upperBound, lowerBound };
}
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let forecastChart;
let currentForecastPeriod = 7;
const historicalData = generateHistoricalData(60);
let monthlySalesChart;
const monthlySalesUrl = '{{ route('admin.sales.monthly') }}';
// ============================================================================
// CHART CONFIGURATIONS
// ============================================================================
function createForecastChart(days = 7) {
    const ctx = document.getElementById('forecastChart').getContext('2d');
   
    const recentHistorical = historicalData.slice(-30);
    const historicalLabels = generateDateLabels(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), 30);
   
    const ensemble = ensembleForecast(historicalData, days);
    const { upperBound, lowerBound } = calculateConfidenceIntervals(ensemble, historicalData);
    const forecastLabels = generateDateLabels(new Date(), days);
   
    updateForecastMetrics(ensemble, historicalData);
    updateAIInsights(ensemble, days);
    updateTrendIndicators();
   
    if (forecastChart) forecastChart.destroy();
   
    forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [...historicalLabels.slice(-14), ...forecastLabels],
            datasets: [
                {
                    label: 'Data Historis',
                    data: [...recentHistorical.slice(-14), ...Array(days).fill(null)],
                    borderColor: 'rgb(33, 150, 243)',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgb(33, 150, 243)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Prediksi (Ensemble AI)',
                    data: [...Array(14).fill(null), recentHistorical[recentHistorical.length - 1], ...ensemble],
                    borderColor: 'rgb(255, 212, 0)',
                    backgroundColor: 'rgba(255, 212, 0, 0.2)',
                    borderWidth: 4,
                    borderDash: [10, 5],
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointStyle: 'rectRot',
                    pointBackgroundColor: 'rgb(255, 212, 0)',
                    tension: 0.4,
                    fill: false
                },
                {
                    label: 'Upper Confidence (95%)',
                    data: [...Array(14).fill(null), recentHistorical[recentHistorical.length - 1], ...upperBound],
                    borderColor: 'rgba(76, 175, 80, 0.3)',
                    backgroundColor: 'rgba(76, 175, 80, 0.05)',
                    borderWidth: 1,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    tension: 0.4,
                    fill: '+1'
                },
                {
                    label: 'Lower Confidence (95%)',
                    data: [...Array(14).fill(null), recentHistorical[recentHistorical.length - 1], ...lowerBound],
                    borderColor: 'rgba(244, 67, 54, 0.3)',
                    backgroundColor: 'rgba(244, 67, 54, 0.05)',
                    borderWidth: 1,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        padding: 15,
                        font: { size: 11, weight: 'bold' },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    padding: 15,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += Math.round(context.parsed.y).toLocaleString('id-ID') + ' pengunjung';
                            }
                            return label;
                        },
                        footer: function(tooltipItems) {
                            const dataIndex = tooltipItems[0].dataIndex;
                            if (dataIndex >= 14) return 'Prediksi AI dengan confidence 95%';
                            return 'Data aktual kunjungan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: {
                        font: { size: 11, weight: 'bold' },
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Pengunjung',
                        font: { size: 12, weight: 'bold' }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
}
function createHeatmapChart() {
    const ctx = document.getElementById('heatmapChart').getContext('2d');
    const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    const weekdayPattern = detectSeasonality(historicalData, 7);
   
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: daysOfWeek,
            datasets: [{
                label: 'Rata-rata Kunjungan',
                data: weekdayPattern,
                backgroundColor: daysOfWeek.map((day, i) => {
                    const value = weekdayPattern[i];
                    const maxValue = Math.max(...weekdayPattern);
                    const intensity = value / maxValue;
                    return `rgba(255, 212, 0, ${0.3 + intensity * 0.7})`;
                }),
                borderColor: daysOfWeek.map((day, i) => {
                    const value = weekdayPattern[i];
                    const maxValue = Math.max(...weekdayPattern);
                    return value === maxValue ? 'rgb(11, 11, 11)' : 'rgb(255, 212, 0)';
                }),
                borderWidth: 3,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            return 'Rata-rata: ' + context.parsed.y.toLocaleString() + ' pengunjung';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 11, weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: 'bold' } }
                }
            }
        }
    });
}
function createMovingAverageChart() {
    const ctx = document.getElementById('movingAverageChart').getContext('2d');
    const sma7 = calculateSMA(historicalData.slice(-30), 7);
    const ema14 = calculateEMA(historicalData.slice(-30), 14);
    const labels = generateDateLabels(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), 30);
   
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Data Aktual',
                    data: historicalData.slice(-30),
                    borderColor: 'rgba(158, 158, 158, 0.5)',
                    backgroundColor: 'rgba(158, 158, 158, 0.1)',
                    borderWidth: 1,
                    pointRadius: 2,
                    tension: 0.4
                },
                {
                    label: 'SMA 7 Hari',
                    data: sma7,
                    borderColor: 'rgb(33, 150, 243)',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 0,
                    tension: 0.4
                },
                {
                    label: 'EMA 14 Hari',
                    data: ema14,
                    borderColor: 'rgb(255, 212, 0)',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    pointRadius: 0,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        padding: 10,
                        font: { size: 10, weight: 'bold' },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: '#FFD400',
                    borderWidth: 2
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 10, weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 9, weight: 'bold' },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
}
function createCategoryChart() {
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: ['Pelajar', 'Umum', 'Asing'],
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: [pelajarTotal, umumTotal, asingTotal],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 87, 34, 0.8)'
                ],
                borderColor: [
                    'rgb(76, 175, 80)',
                    'rgb(33, 150, 243)',
                    'rgb(255, 87, 34)'
                ],
                borderWidth: 3,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y.toLocaleString('id-ID') + ' pengunjung';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 13,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
}
function createPieChart() {
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pelajar', 'Umum', 'Asing'],
            datasets: [{
                data: [pelajarTotal, umumTotal, asingTotal],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 87, 34, 0.8)'
                ],
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
}
function createProvinceChart() {
    const provinceCtx = document.getElementById('provinceChart').getContext('2d');
    const provinceLabels = provinsiData.map(item => item.provinsi || 'Tidak diketahui');
    const provinceTotals = provinsiData.map(item => item.total);
    new Chart(provinceCtx, {
        type: 'bar',
        data: {
            labels: provinceLabels,
            datasets: [{
                label: 'Total Pengunjung',
                data: provinceTotals,
                backgroundColor: provinceLabels.map((_, i) => {
                    if (i === 0) return 'rgba(255, 215, 0, 0.9)'; // Gold
                    if (i === 1) return 'rgba(192, 192, 192, 0.9)'; // Silver
                    if (i === 2) return 'rgba(205, 127, 50, 0.9)'; // Bronze
                    return 'rgba(255, 212, 0, 0.8)';
                }),
                borderColor: provinceLabels.map((_, i) => {
                    if (i < 3) return 'rgb(11, 11, 11)';
                    return 'rgb(255, 212, 0)';
                }),
                borderWidth: 3,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            return 'Total: ' + context.parsed.x.toLocaleString('id-ID') + ' pengunjung';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
}
function createStudentChart() {
    const studentCtx = document.getElementById('studentChart').getContext('2d');
    new Chart(studentCtx, {
        type: 'bar',
        data: {
            labels: ['TK', 'SD', 'SMP', 'SMA', 'Kuliah'],
            datasets: [{
                label: 'Jumlah Pelajar',
                data: [tkTotal, sdTotal, smpTotal, smaTotal, kuliahTotal],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(255, 87, 34, 0.8)'
                ],
                borderColor: [
                    'rgb(255, 193, 7)',
                    'rgb(76, 175, 80)',
                    'rgb(33, 150, 243)',
                    'rgb(156, 39, 176)',
                    'rgb(255, 87, 34)'
                ],
                borderWidth: 3,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y.toLocaleString('id-ID') + ' pelajar';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
}
// ============================================================================
// MONTHLY SALES (PER BULAN)
// =========================================================================
function initMonthlySalesControls() {
    const monthSelect = document.getElementById('salesMonth');
    const yearSelect = document.getElementById('salesYear');

    if (!monthSelect || !yearSelect) return;

    const monthNames = [
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ];
    const now = new Date();
    const currentMonth = now.getMonth() + 1; // 1-12
    const currentYear = now.getFullYear();

    // Populate months
    monthSelect.innerHTML = '';
    monthNames.forEach((name, idx) => {
        const opt = document.createElement('option');
        opt.value = String(idx + 1);
        opt.textContent = name;
        if (idx + 1 === currentMonth) opt.selected = true;
        monthSelect.appendChild(opt);
    });

    // Populate years (currentYear-2 .. currentYear+1)
    yearSelect.innerHTML = '';
    for (let y = currentYear - 2; y <= currentYear + 1; y++) {
        const opt = document.createElement('option');
        opt.value = String(y);
        opt.textContent = String(y);
        if (y === currentYear) opt.selected = true;
        yearSelect.appendChild(opt);
    }

    monthSelect.addEventListener('change', loadMonthlySales);
    yearSelect.addEventListener('change', loadMonthlySales);
}

let isLoadingMonthlySales = false;

async function loadMonthlySales() {
    const month = document.getElementById('salesMonth')?.value;
    const year = document.getElementById('salesYear')?.value;
    if (!month || !year) return;
    
    // Prevent multiple simultaneous calls
    if (isLoadingMonthlySales) {
        console.log('Already loading monthly sales, skipping...');
        return;
    }

    isLoadingMonthlySales = true;

    try {
        const resp = await fetch(`${monthlySalesUrl}?month=${month}&year=${year}`);
        const data = await resp.json();
        renderMonthlySalesChart(data);
    } catch (e) {
        console.error('Gagal memuat data penjualan bulanan', e);
    } finally {
        isLoadingMonthlySales = false;
    }
}

function renderMonthlySalesChart(payload) {
    const ctx = document.getElementById('monthlySalesChart')?.getContext('2d');
    if (!ctx) return;

    const labels = payload.labels || [];
    const cat = payload.by_category || { pelajar: [], umum: [], asing: [] };

    if (monthlySalesChart) monthlySalesChart.destroy();

    monthlySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pelajar',
                    data: cat.pelajar || [],
                    backgroundColor: 'rgba(76, 175, 80, 0.8)',
                    borderColor: 'rgb(76, 175, 80)',
                    borderWidth: 2,
                    borderRadius: 6,
                    stack: 'total'
                },
                {
                    label: 'Umum',
                    data: cat.umum || [],
                    backgroundColor: 'rgba(33, 150, 243, 0.8)',
                    borderColor: 'rgb(33, 150, 243)',
                    borderWidth: 2,
                    borderRadius: 6,
                    stack: 'total'
                },
                {
                    label: 'Asing',
                    data: cat.asing || [],
                    backgroundColor: 'rgba(255, 87, 34, 0.8)',
                    borderColor: 'rgb(255, 87, 34)',
                    borderWidth: 2,
                    borderRadius: 6,
                    stack: 'total'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 11, weight: 'bold' } }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    borderColor: '#FFD400',
                    borderWidth: 2,
                    padding: 12,
                    callbacks: {
                        footer: (items) => {
                            const idx = items?.[0]?.dataIndex ?? 0;
                            const total = (payload.totals?.[idx] ?? 0).toLocaleString('id-ID');
                            return `Total hari itu: ${total}`;
                        }
                    }
                }
            },
            scales: {
                x: { stacked: true, grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        callback: (v) => v.toLocaleString('id-ID')
                    },
                    title: { display: true, text: 'Jumlah Tiket', font: { size: 12, weight: 'bold' } }
                }
            }
        }
    });
}
// ============================================================================
// UPDATE FUNCTIONS
// ============================================================================
function updateForecastMetrics(forecast, historical) {
    // Calculate predicted average
    const avgPredicted = forecast.reduce((a, b) => a + b, 0) / forecast.length;
    document.getElementById('predictedAvg').textContent = Math.round(avgPredicted).toLocaleString('id-ID');
   
    // Calculate growth rate
    const avgHistorical = historical.slice(-7).reduce((a, b) => a + b, 0) / 7;
    const growthRate = ((avgPredicted - avgHistorical) / avgHistorical * 100).toFixed(1);
    const growthElement = document.getElementById('growthRate');
    growthElement.textContent = (growthRate >= 0 ? '+' : '') + growthRate + '%';
    growthElement.style.color = growthRate >= 0 ? '#4CAF50' : '#f44336';
   
    // Calculate model accuracy using ensemble validation
    const validationData = historical.slice(-14, -7);
    const validationForecast = ensembleForecast(historical.slice(0, -7), 7);
    const accuracy = calculateMAPE(validationData, validationForecast);
    document.getElementById('accuracy').textContent = accuracy.toFixed(1) + '%';
}
function updateAIInsights(forecast, days) {
    // Peak Day Prediction
    const peakDay = findPeakDay(forecast);
    const peakDate = new Date();
    peakDate.setDate(peakDate.getDate() + peakDay.day);
    const peakDateStr = peakDate.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
   
    document.getElementById('peakDayInsight').textContent =
        `Hari puncak diprediksi pada ${peakDateStr} dengan ${Math.round(peakDay.value).toLocaleString('id-ID')} pengunjung`;
   
    // Capacity Alert
    const maxCapacity = 1000; // Sesuaikan dengan kapasitas museum
    const maxForecast = Math.max(...forecast);
    const capacityPercentage = ((maxForecast / maxCapacity) * 100).toFixed(0);
   
    let capacityText = '';
    if (capacityPercentage > 90) {
        capacityText = `⚠️ PERHATIAN: Prediksi mencapai ${capacityPercentage}% kapasitas. Pertimbangkan pembatasan tiket.`;
    } else if (capacityPercentage > 70) {
        capacityText = `Prediksi ${capacityPercentage}% kapasitas. Siapkan staff tambahan untuk hari puncak.`;
    } else {
        capacityText = `✅ Kapasitas aman di ${capacityPercentage}%. Tidak ada tindakan khusus diperlukan.`;
    }
    document.getElementById('capacityInsight').textContent = capacityText;
   
    // Seasonal Pattern Analysis
    const weekdayIndices = [];
    const weekendIndices = [];
   
    for (let i = 0; i < forecast.length; i++) {
        const futureDate = new Date();
        futureDate.setDate(futureDate.getDate() + i + 1);
        const dayOfWeek = futureDate.getDay();
       
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            weekendIndices.push(i);
        } else {
            weekdayIndices.push(i);
        }
    }
   
    const avgWeekday = weekdayIndices.length > 0
        ? weekdayIndices.reduce((sum, i) => sum + forecast[i], 0) / weekdayIndices.length
        : 0;
    const avgWeekend = weekendIndices.length > 0
        ? weekendIndices.reduce((sum, i) => sum + forecast[i], 0) / weekendIndices.length
        : 0;
   
    const weekendBoost = avgWeekday !== 0
        ? ((avgWeekend - avgWeekday) / avgWeekday * 100).toFixed(0)
        : 0;
   
    document.getElementById('seasonalInsight').textContent =
        `Pola musiman: Weekend ${weekendBoost}% lebih ramai. Rata-rata weekday: ${Math.round(avgWeekday).toLocaleString('id-ID')}, weekend: ${Math.round(avgWeekend).toLocaleString('id-ID')}`;
}
function updateTrendIndicators() {
    // Today's trend
    if (historicalData.length >= 2) {
        const todayValue = historicalData[historicalData.length - 1];
        const yesterdayValue = historicalData[historicalData.length - 2];
        const todayTrend = yesterdayValue !== 0
            ? ((todayValue - yesterdayValue) / yesterdayValue * 100).toFixed(1)
            : 0;
       
        const todayTrendElement = document.getElementById('todayTrend');
        todayTrendElement.textContent = (todayTrend >= 0 ? '+' : '') + todayTrend + '%';
       
        const todayTrendParent = todayTrendElement.closest('.trend-indicator');
        if (todayTrend >= 0) {
            todayTrendParent.classList.remove('negative');
            todayTrendParent.classList.add('positive');
        } else {
            todayTrendParent.classList.remove('positive');
            todayTrendParent.classList.add('negative');
        }
    }
   
    // Weekly trends
    if (historicalData.length >= 14) {
        const recentWeek = historicalData.slice(-7).reduce((a, b) => a + b, 0) / 7;
        const previousWeek = historicalData.slice(-14, -7).reduce((a, b) => a + b, 0) / 7;
       
        const weeklyTrend = previousWeek !== 0
            ? ((recentWeek - previousWeek) / previousWeek * 100).toFixed(1)
            : 0;
       
        // Update all category trends
        ['studentTrend', 'publicTrend', 'foreignTrend'].forEach(id => {
            const element = document.getElementById(id);
            element.textContent = (weeklyTrend >= 0 ? '+' : '') + weeklyTrend + '%';
           
            const parent = element.closest('.trend-indicator');
            if (weeklyTrend >= 0) {
                parent.classList.remove('negative');
                parent.classList.add('positive');
            } else {
                parent.classList.remove('positive');
                parent.classList.add('negative');
            }
        });
    }
}
// ============================================================================
// CHANGE FORECAST PERIOD FUNCTION
// ============================================================================
function changeForecastPeriod(days) {
    currentForecastPeriod = days;
   
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
   
    // Recreate forecast chart with new period
    createForecastChart(days);
}
// ============================================================================
// EXPORT FUNCTIONS
// ============================================================================
function exportForecastData() {
    const forecast = ensembleForecast(historicalData, currentForecastPeriod);
    const labels = generateDateLabels(new Date(), currentForecastPeriod);
   
    const csvContent = "data:text/csv;charset=utf-8,"
        + "Tanggal,Prediksi Pengunjung\n"
        + labels.map((label, i) => `${label},${Math.round(forecast[i])}`).join("\n");
   
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `forecast_${currentForecastPeriod}_days.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
// ============================================================================
// REAL-TIME UPDATE (Optional - jika ada WebSocket/polling)
// ============================================================================
function startRealTimeUpdates() {
    setInterval(() => {
        // Simulate new data point
        const lastValue = historicalData[historicalData.length - 1];
        const newValue = Math.max(50, lastValue + (Math.random() - 0.5) * 30);
       
        // Add new data and remove oldest if exceeds 60 days
        historicalData.push(Math.round(newValue));
        if (historicalData.length > 60) {
            historicalData.shift();
        }
       
        // Update charts
        createForecastChart(currentForecastPeriod);
        createHeatmapChart();
        createMovingAverageChart();
        updateTrendIndicators();
       
    }, 60000); // Update every minute
}
// ============================================================================
// XLSX EXPORT FUNCTIONS
// ============================================================================
function exportMonthlyXlsx() {
    const month = document.getElementById('salesMonth')?.value;
    const year = document.getElementById('salesYear')?.value;
    
    if (!month || !year) {
        alert('Pilih bulan dan tahun terlebih dahulu');
        return;
    }
    
    const url = '{{ route("admin.export.monthly") }}?month=' + month + '&year=' + year;
    window.location.href = url;
}

function exportYearlyXlsx() {
    const year = document.getElementById('exportYear')?.value;
    
    if (!year) {
        alert('Pilih tahun terlebih dahulu');
        return;
    }
    
    const url = '{{ route("admin.export.yearly") }}?year=' + year;
    window.location.href = url;
}

function exportForecastXlsx() {
    const days = currentForecastPeriod || 7;
    const url = '{{ route("admin.export.forecast") }}?days=' + days + '&method=ensemble';
    window.location.href = url;
}

function initYearlyExportSelector() {
    const yearSelect = document.getElementById('exportYear');
    if (!yearSelect) return;
    
    const now = new Date();
    const currentYear = now.getFullYear();
    
    yearSelect.innerHTML = '';
    for (let y = currentYear - 2; y <= currentYear + 1; y++) {
        const opt = document.createElement('option');
        opt.value = String(y);
        opt.textContent = String(y);
        if (y === currentYear) opt.selected = true;
        yearSelect.appendChild(opt);
    }
}

// ============================================================================
// ANOMALY DETECTION ALERT
// ============================================================================
function checkForAnomalies() {
    const anomalies = detectAnomalies(historicalData, 2);
   
    if (anomalies.length > 0) {
        const recentAnomalies = anomalies.filter(a => a.index >= historicalData.length - 7);
       
        if (recentAnomalies.length > 0) {
            console.warn('Anomalies detected in recent data:', recentAnomalies);
            // You can show notification to admin here
        }
    }
}
// ============================================================================
// PERFORMANCE MONITORING
// ============================================================================
function measureChartPerformance() {
    const startTime = performance.now();
   
    createForecastChart(7);
    createHeatmapChart();
    createMovingAverageChart();
    createCategoryChart();
    createPieChart();
    createProvinceChart();
    createStudentChart();
   
    const endTime = performance.now();
    const loadTime = (endTime - startTime).toFixed(2);
   
    console.log(`All charts loaded in ${loadTime}ms`);
}
// ============================================================================
// INITIALIZE ALL CHARTS ON PAGE LOAD
// ============================================================================
let dashboardInitialized = false;

document.addEventListener('DOMContentLoaded', function() {
    // Prevent multiple initialization
    if (dashboardInitialized) {
        console.log('Dashboard already initialized, skipping...');
        return;
    }
    
    console.log('Initializing Advanced Analytics Dashboard...');
   
    // Create all charts
    createForecastChart(7);
    createHeatmapChart();
    createMovingAverageChart();
    createCategoryChart();
    createPieChart();
    createProvinceChart();
    createStudentChart();
    initMonthlySalesControls();
    loadMonthlySales();
    initYearlyExportSelector();
    
    // Update metrics
    updateTrendIndicators();
    
    // Check for anomalies
    checkForAnomalies();
   
    // Mark as initialized
    dashboardInitialized = true;
   
    console.log('Dashboard initialized successfully!');
});
// ============================================================================
// WINDOW RESIZE HANDLER - Disabled to prevent continuous chart reloading
// ============================================================================
// Chart.js handles responsive resize automatically, no need for manual recreation
// ============================================================================
// EXPORT GLOBAL FUNCTIONS (if needed)
// ============================================================================
window.changeForecastPeriod = changeForecastPeriod;
window.exportForecastData = exportForecastData;
window.loadMonthlySales = loadMonthlySales;
window.exportMonthlyXlsx = exportMonthlyXlsx;
window.exportYearlyXlsx = exportYearlyXlsx;
window.exportForecastXlsx = exportForecastXlsx;
</script>
@endsection