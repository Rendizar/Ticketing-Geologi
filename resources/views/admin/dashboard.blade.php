@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h2>{{ $kunjungan_hari_ini }}</h2>
                    <p class="mb-0">Kunjungan Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->pelajar ?? 0 }}</h2>
                    <p class="mb-0">Total Pelajar</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->umum ?? 0 }}</h2>
                    <p class="mb-0">Total Umum</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->asing ?? 0 }}</h2>
                    <p class="mb-0">Total Wisatawan Asing</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Statistik Per Provinsi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Provinsi</th>
                                    <th>Total Pengunjung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($per_propinsi as $data)
                                <tr>
                                    <td>{{ $data->kecamatan_provinsi }}</td>
                                    <td>{{ $data->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Prediksi & Statistik
                </div>
                <div class="card-body">
                    <p><strong>Rata-rata Kunjungan Harian:</strong> {{ number_format($avg_daily, 1) }} pengunjung</p>
                    <p><strong>Total TK:</strong> {{ $sub_pelajar->tk ?? 0 }} pengunjung</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection