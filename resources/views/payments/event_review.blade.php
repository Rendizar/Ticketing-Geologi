@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan Event')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--mg-black);"></i>
                    </div>
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px;">
                        KONFIRMASI PEMESANAN EVENT
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $pending = session('pending_event_booking');
                    @endphp

                    @if($pending)
                        <!-- Event Info -->
                        <div class="alert alert-info mb-4">
                            <h5 class="fw-bold mb-3">{{ $pending['event_title'] }}</h5>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    <strong>Tanggal:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_date'])->format('d M Y') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>Waktu:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_time'])->format('H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="card mb-4" style="background: rgba(255, 212, 0, 0.1);">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-user-circle me-2" style="color: var(--mg-yellow);"></i>
                                    Informasi Pemesan
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong>Nama:</strong><br>
                                        {{ $pending['nama'] }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Email:</strong><br>
                                        {{ $pending['email'] }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>No. Telepon:</strong><br>
                                        {{ $pending['nomor_telepon'] }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Jumlah Tiket:</strong><br>
                                        {{ $pending['jumlah_tiket'] }} tiket
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="card mb-4" style="background: #f8f9fa;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-file-invoice me-2" style="color: var(--mg-yellow);"></i>
                                    Rincian Pembayaran
                                </h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga per Tiket:</span>
                                    <strong>Rp {{ number_format($pending['harga_satuan'], 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Jumlah Tiket:</span>
                                    <strong>{{ $pending['jumlah_tiket'] }}</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fs-5 fw-bold">Total Pembayaran:</span>
                                    <span class="fs-4 fw-bold" style="color: var(--mg-yellow);">
                                        Rp {{ number_format($pending['total_harga'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="{{ route('event.payment.initiate') }}" method="POST">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg fw-bold" 
                                    style="background: var(--mg-yellow); color: var(--mg-black); border: none; border-radius: 0.75rem;">
                                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Data pemesanan tidak ditemukan. Silakan isi form pemesanan kembali.
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
