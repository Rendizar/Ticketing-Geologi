@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4 brand-text">Dashboard</h1> <!-- Diubah menjadi brand-text untuk selaras dengan logo style -->
    
    <!-- Statistics Cards - Warna disesuaikan dengan tema: background yellow, text black, border black -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%); color: var(--mg-black); border: 2px solid var(--mg-black); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                <div class="card-body">
                    <h2>{{ $kunjungan_hari_ini }}</h2>
                    <p class="mb-0">Kunjungan Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%); color: var(--mg-black); border: 2px solid var(--mg-black); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->pelajar ?? 0 }}</h2>
                    <p class="mb-0">Total Pelajar</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%); color: var(--mg-black); border: 2px solid var(--mg-black); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->umum ?? 0 }}</h2>
                    <p class="mb-0">Total Umum</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%); color: var(--mg-black); border: 2px solid var(--mg-black); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                <div class="card-body">
                    <h2>{{ $total_per_kategori->asing ?? 0 }}</h2>
                    <p class="mb-0">Total Wisatawan Asing</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics - Card selaras dengan visitor: white bg, subtle border, header dengan icon yellow -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%); color: var(--mg-yellow); border-bottom: 2px solid var(--mg-yellow);">
                    <i class="fas fa-chart-area me-1" style="color: var(--mg-yellow);"></i>
                    Statistik Per Provinsi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background: var(--mg-black); color: var(--mg-yellow);">
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
                <div class="card-header" style="background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%); color: var(--mg-yellow); border-bottom: 2px solid var(--mg-yellow);">
                    <i class="fas fa-chart-bar me-1" style="color: var(--mg-yellow);"></i>
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

@section('styles')
<style>
    /* Selaras dengan visitor: brand-text untuk judul */
    .brand-text {
        font-family: 'Futura PT', 'Century Gothic', sans-serif;
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: 0.10em;
        color: var(--mg-black);
        text-shadow: 
            2px 2px 0px rgba(11, 11, 11, 0.3),
            4px 4px 0px rgba(11, 11, 11, 0.2),
            6px 6px 12px rgba(0, 0, 0, 0.15);
        transform: perspective(600px) rotateX(-5deg);
    }

    /* Card umum selaras */
    .card {
        background: var(--mg-white) !important;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); /* Shadow selaras dengan navbar visitor */
    }

    /* Table stripe selaras dengan muted color */
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(108,108,108,0.05); /* Menggunakan --mg-muted dengan opacity */
    }

    /* Sidebar selaras: background black dengan gradient, text yellow/white, hover efek selaras */
    .sidebar {
        background: linear-gradient(180deg, var(--mg-black) 0%, #1a1a1a 100%) !important;
        color: var(--mg-white) !important;
        box-shadow: 4px 0 12px rgba(0,0,0,0.2); /* Tambah shadow untuk efek 3D selaras navbar */
        border-right: 2px solid var(--mg-yellow); /* Border kuning untuk aksen */
    }

    .sidebar .nav-link {
        color: var(--mg-yellow) !important; /* Ubah ke yellow untuk selaras tema */
        transition: background-color 0.3s, color 0.3s, transform 0.3s;
        border-radius: 8px;
        margin: 0.5rem 0;
    }

    .sidebar .nav-link:hover {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        transform: translateX(5px); /* Efek geser saat hover untuk dinamis */
    }

    .sidebar .nav-link.active {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
    }

    .sidebar .sidebar-heading {
        color: var(--mg-yellow) !important;
        font-family: 'Futura PT', 'Century Gothic', sans-serif; /* Selaras brand-text */
        font-weight: 900;
        letter-spacing: 0.05em;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    /* Content area selaras: padding dan margin */
    .content {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); /* Gradient selaras body visitor */
        padding: 2rem !important;
    }

    /* Responsif selaras */
    @media (max-width: 768px) {
        .brand-text {
            font-size: 2rem;
        }

        .sidebar {
            width: 100% !important; /* Adjust untuk mobile */
        }

        .content {
            margin-left: 0 !important;
        }
    }
</style>
@endsection