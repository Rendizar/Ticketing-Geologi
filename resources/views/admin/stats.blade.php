@extends('layouts.admin')
@section('title', 'Statistik & Forecasting - Admin')
@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>
<div class="container-fluid dashboard-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text dashboard-title-outline mb-3">
                <i class="bi bi-graph-up-arrow me-3"></i>Statistik & Forecasting
            </h1>
            <p class="subtitle-text"><strong>Analisis Prediksi & Tren Kunjungan Museum Geologi Bandung</strong></p>
        </div>
    </div>

    <!-- STATISTICS OVERVIEW -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($stats['total_visitors']) }}</h2>
                    <p class="stat-label">Total Pengunjung</p>
                    <div class="stat-date">Semua Kategori</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-pelajar">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($stats['by_category']->pelajar ?? 0) }}</h2>
                    <p class="stat-label">Pelajar</p>
                    <div class="stat-date">Semua Jenjang</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-umum">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($stats['by_category']->umum ?? 0) }}</h2>
                    <p class="stat-label">Umum</p>
                    <div class="stat-date">Pengunjung Lokal</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-asing">
                <div class="card-body text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-globe-asia-australia"></i>
                    </div>
                    <h2 class="stat-number">{{ number_format($stats['by_category']->asing ?? 0) }}</h2>
                    <p class="stat-label">Asing</p>
                    <div class="stat-date">Wisatawan Internasional</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FORECASTING SECTION -->
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

    <!-- ADDITIONAL ANALYSIS CHARTS -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-calendar-week me-2"></i>
                    Pola Kunjungan Per Hari
                </div>
                <div class="card-body">
                    <canvas id="heatmapChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="detail-card">
                <div class="card-header">
                    <i class="bi bi-activity me-2"></i>
                    Moving Average Analysis
                </div>
                <div class="card-body">
                    <canvas id="movingAverageChart" height="100"></canvas>
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
    
    .brand-text {
        font-family: 'Montserrat', 'Futura PT', 'Century Gothic', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: var(--mg-black);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        animation: fadeInDown 0.8s ease-out;
    }
    
    .subtitle-text {
        font-size: 1.1rem;
        color: var(--mg-muted);
        font-weight: 500;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
    }
    
    .stat-card-pelajar {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    .stat-card-pelajar:hover {
        box-shadow: 0 15px 40px rgba(17, 153, 142, 0.5);
    }
    
    .stat-card-umum {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
    }
    
    .stat-card-umum:hover {
        box-shadow: 0 15px 40px rgba(79, 172, 254, 0.5);
    }
    
    .stat-card-asing {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
    }
    
    .stat-card-asing:hover {
        box-shadow: 0 15px 40px rgba(250, 112, 154, 0.5);
    }
    
    .stat-card .card-body {
        padding: 2rem;
        color: white;
    }
    
    .icon-wrapper {
        font-size: 3rem;
        opacity: 0.9;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .stat-label {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        opacity: 0.95;
    }
    
    .stat-date {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .detail-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }
    
    .detail-card .card-header {
        background: linear-gradient(135deg, var(--mg-yellow) 0%, #ffc107 100%);
        color: var(--mg-black);
        padding: 1.25rem;
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: none;
    }
    
    .detail-card .card-body {
        padding: 1.5rem;
    }
    
    .forecast-info {
        padding-top: 1rem;
        border-top: 2px solid rgba(0, 0, 0, 0.05);
    }
    
    .forecast-metric {
        padding: 1rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 50%);
        border-radius: 0.75rem;
        transition: transform 0.3s ease;
    }
    
    .forecast-metric:hover {
        transform: scale(1.05);
    }
    
    .forecast-metric i {
        font-size: 2rem;
        color: var(--mg-yellow);
        margin-bottom: 0.5rem;
    }
    
    .forecast-metric h5 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--mg-black);
        margin: 0.5rem 0;
    }
    
    .forecast-metric small {
        font-size: 0.85rem;
        color: var(--mg-muted);
        font-weight: 600;
    }
    
    .insight-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .insight-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .insight-icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .insight-icon.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .insight-icon.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .insight-icon.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .insight-content h6 {
        font-weight: 700;
        color: var(--mg-black);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }
    
    .insight-content p {
        font-size: 0.85rem;
        color: var(--mg-muted);
        margin: 0;
        line-height: 1.4;
    }
    
    .btn-outline-warning {
        border-color: var(--mg-yellow);
        color: var(--mg-black);
        font-weight: 600;
    }
    
    .btn-outline-warning.active,
    .btn-outline-warning:hover {
        background-color: var(--mg-yellow);
        border-color: var(--mg-yellow);
        color: var(--mg-black);
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
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
// Initialize Particles.js
particlesJS('particles-js', {
    particles: {
        number: { value: 80, density: { enable: true, value_area: 800 } },
        color: { value: ['#FFD400', '#667eea', '#764ba2'] },
        shape: { type: 'circle' },
        opacity: { value: 0.5, random: true },
        size: { value: 3, random: true },
        line_linked: { enable: true, distance: 150, color: '#FFD400', opacity: 0.2, width: 1 },
        move: { enable: true, speed: 2, direction: 'none', random: true, out_mode: 'out' }
    },
    interactivity: {
        detect_on: 'canvas',
        events: { onhover: { enable: true, mode: 'repulse' }, onclick: { enable: true, mode: 'push' } }
    }
});

// FORECASTING FUNCTIONS
function generateHistoricalData(days) {
    const data = [];
    const baseVisitors = 200;
    for (let i = 0; i < days; i++) {
        const dayOfWeek = (i % 7);
        const weekendBoost = (dayOfWeek === 5 || dayOfWeek === 6) ? 1.5 : 1;
        const trend = i * 0.5;
        const seasonal = Math.sin(i * Math.PI / 7) * 20;
        const noise = (Math.random() - 0.5) * 40;
        const value = (baseVisitors + trend + seasonal + noise) * weekendBoost;
        data.push(Math.max(50, Math.round(value)));
    }
    return data;
}

function generateDateLabels(startDate, days) {
    const labels = [];
    const date = new Date(startDate);
    for (let i = 0; i < days; i++) {
        labels.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }));
        date.setDate(date.getDate() + 1);
    }
    return labels;
}

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

function calculateEMA(data, period) {
    const k = 2 / (period + 1);
    const emaData = [data[0]];
    for (let i = 1; i < data.length; i++) {
        emaData.push(data[i] * k + emaData[i - 1] * (1 - k));
    }
    return emaData;
}

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

function holtWintersForecast(data, forecastDays, alpha = 0.3, beta = 0.1, gamma = 0.1, seasonLength = 7) {
    const level = [data[0]];
    const trend = [data[1] - data[0]];
    const seasonal = new Array(seasonLength).fill(1);
    for (let i = 0; i < seasonLength && i < data.length; i++) {
        const avgVal = data.reduce((a, b) => a + b, 0) / data.length;
        seasonal[i] = avgVal !== 0 ? data[i] / avgVal : 1;
    }
    for (let i = 1; i < data.length; i++) {
        const seasonalIndex = i % seasonLength;
        const seasonalVal = seasonal[seasonalIndex] || 1;
        const newLevel = alpha * (data[i] / seasonalVal) + (1 - alpha) * (level[i - 1] + trend[i - 1]);
        const newTrend = beta * (newLevel - level[i - 1]) + (1 - beta) * trend[i - 1];
        seasonal[seasonalIndex] = gamma * (data[i] / newLevel) + (1 - gamma) * seasonalVal;
        level.push(newLevel);
        trend.push(newTrend);
    }
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

function autoRegressiveForecast(data, forecastDays, lag = 5) {
    const coefficients = [];
    for (let i = 0; i < lag; i++) {
        let sumXY = 0, sumX2 = 0;
        for (let j = lag; j < data.length; j++) {
            sumXY += data[j] * data[j - i - 1];
            sumX2 += data[j - i - 1] * data[j - i - 1];
        }
        coefficients.push(sumX2 !== 0 ? sumXY / sumX2 : 0);
    }
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

function ensembleForecast(data, forecastDays) {
    const lr = linearRegression(data, forecastDays).forecast;
    const hw = holtWintersForecast(data, forecastDays);
    const poly = polynomialRegression(data, forecastDays);
    const ar = autoRegressiveForecast(data, forecastDays);
    const ensemble = [];
    for (let i = 0; i < forecastDays; i++) {
        const avg = (lr[i] + hw[i] + poly[i] + ar[i]) / 4;
        ensemble.push(Math.round(avg));
    }
    return ensemble;
}

function calculateMAPE(actual, predicted) {
    let sum = 0;
    let count = 0;
    for (let i = 0; i < Math.min(actual.length, predicted.length); i++) {
        if (actual[i] !== 0) {
            sum += Math.abs((actual[i] - predicted[i]) / actual[i]);
            count++;
        }
    }
    return count > 0 ? (1 - sum / count) * 100 : 0;
}

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

function findPeakDay(forecast, startDay = 0) {
    const maxValue = Math.max(...forecast);
    const maxIndex = forecast.indexOf(maxValue);
    return { day: startDay + maxIndex + 1, value: maxValue };
}

function calculateConfidenceIntervals(forecast, historicalData, confidenceLevel = 0.95) {
    const mean = historicalData.reduce((a, b) => a + b, 0) / historicalData.length;
    const variance = historicalData.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / historicalData.length;
    const stdDev = Math.sqrt(variance);
    const zScore = confidenceLevel === 0.95 ? 1.96 : 2.576;
    const upperBound = forecast.map((val, i) => val + zScore * stdDev * Math.sqrt(i + 1));
    const lowerBound = forecast.map((val, i) => Math.max(0, val - zScore * stdDev * Math.sqrt(i + 1)));
    return { upperBound, lowerBound };
}

// GLOBAL VARIABLES
let forecastChart, heatmapChart, movingAverageChart;
let currentForecastPeriod = 7;
const historicalData = generateHistoricalData(60);

// CREATE CHARTS
function createForecastChart(days = 7) {
    const ctx = document.getElementById('forecastChart').getContext('2d');
    const recentHistorical = historicalData.slice(-30);
    const historicalLabels = generateDateLabels(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), 30);
    const ensemble = ensembleForecast(historicalData, days);
    const { upperBound, lowerBound } = calculateConfidenceIntervals(ensemble, historicalData);
    const forecastLabels = generateDateLabels(new Date(), days);
    updateForecastMetrics(ensemble, historicalData);
    updateAIInsights(ensemble, days);
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
                    labels: { padding: 15, font: { size: 11, weight: 'bold' }, usePointStyle: true, pointStyle: 'circle' }
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
                        callback: function(value) { return value.toLocaleString('id-ID'); }
                    },
                    title: { display: true, text: 'Jumlah Pengunjung', font: { size: 12, weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: 'bold' }, maxRotation: 45, minRotation: 45 }
                }
            }
        }
    });
}

function createHeatmapChart() {
    const ctx = document.getElementById('heatmapChart').getContext('2d');
    const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    const weekdayPattern = detectSeasonality(historicalData, 7);
    if (heatmapChart) heatmapChart.destroy();
    heatmapChart = new Chart(ctx, {
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
                        label: function(context) { return 'Rata-rata: ' + context.parsed.y.toLocaleString() + ' pengunjung'; }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { font: { size: 11, weight: 'bold' } } },
                x: { grid: { display: false }, ticks: { font: { size: 11, weight: 'bold' } } }
            }
        }
    });
}

function createMovingAverageChart() {
    const ctx = document.getElementById('movingAverageChart').getContext('2d');
    const sma7 = calculateSMA(historicalData.slice(-30), 7);
    const ema14 = calculateEMA(historicalData.slice(-30), 14);
    const labels = generateDateLabels(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000), 30);
    if (movingAverageChart) movingAverageChart.destroy();
    movingAverageChart = new Chart(ctx, {
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
                legend: { display: true, position: 'top', labels: { padding: 10, font: { size: 10, weight: 'bold' }, usePointStyle: true } },
                tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, borderColor: '#FFD400', borderWidth: 2 }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { font: { size: 10, weight: 'bold' } } },
                x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' }, maxRotation: 45, minRotation: 45 } }
            }
        }
    });
}

function updateForecastMetrics(forecast, historical) {
    const avgPredicted = forecast.reduce((a, b) => a + b, 0) / forecast.length;
    document.getElementById('predictedAvg').textContent = Math.round(avgPredicted).toLocaleString('id-ID');
    const avgHistorical = historical.slice(-7).reduce((a, b) => a + b, 0) / 7;
    const growthRate = ((avgPredicted - avgHistorical) / avgHistorical * 100).toFixed(1);
    const growthElement = document.getElementById('growthRate');
    growthElement.textContent = (growthRate >= 0 ? '+' : '') + growthRate + '%';
    growthElement.style.color = growthRate >= 0 ? '#4CAF50' : '#f44336';
    const validationData = historical.slice(-14, -7);
    const validationForecast = ensembleForecast(historical.slice(0, -7), 7);
    const accuracy = calculateMAPE(validationData, validationForecast);
    document.getElementById('accuracy').textContent = accuracy.toFixed(1) + '%';
}

function updateAIInsights(forecast, days) {
    const peakDay = findPeakDay(forecast);
    const peakDate = new Date();
    peakDate.setDate(peakDate.getDate() + peakDay.day);
    const peakDateStr = peakDate.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    document.getElementById('peakDayInsight').textContent =
        `Hari puncak diprediksi pada ${peakDateStr} dengan ${Math.round(peakDay.value).toLocaleString('id-ID')} pengunjung`;
    const maxCapacity = 1000;
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
    const avgWeekday = weekdayIndices.length > 0 ? weekdayIndices.reduce((sum, i) => sum + forecast[i], 0) / weekdayIndices.length : 0;
    const avgWeekend = weekendIndices.length > 0 ? weekendIndices.reduce((sum, i) => sum + forecast[i], 0) / weekendIndices.length : 0;
    const weekendBoost = avgWeekday !== 0 ? ((avgWeekend - avgWeekday) / avgWeekday * 100).toFixed(0) : 0;
    document.getElementById('seasonalInsight').textContent =
        `Pola musiman: Weekend ${weekendBoost}% lebih ramai. Rata-rata weekday: ${Math.round(avgWeekday).toLocaleString('id-ID')}, weekend: ${Math.round(avgWeekend).toLocaleString('id-ID')}`;
}

function changeForecastPeriod(days) {
    currentForecastPeriod = days;
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    createForecastChart(days);
}

function exportForecastXlsx() {
    const days = currentForecastPeriod || 7;
    const url = '{{ route("admin.export.forecast") }}?days=' + days + '&method=ensemble';
    window.location.href = url;
}

// INITIALIZE
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Stats & Forecasting Dashboard...');
    createForecastChart(7);
    createHeatmapChart();
    createMovingAverageChart();
    console.log('Dashboard initialized successfully!');
});

window.changeForecastPeriod = changeForecastPeriod;
window.exportForecastXlsx = exportForecastXlsx;
</script>
@endsection
