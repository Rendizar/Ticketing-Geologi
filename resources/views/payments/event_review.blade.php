@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan Event')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-5" style="background: #1F2933; border: none;">
                    <div class="mb-3">
                        <i class="fas fa-check-circle" style="font-size: 3.5rem; color: #10B981;"></i>
                    </div>
                    <h3 class="mb-0" style="font-family: 'Merriweather', serif; font-weight: 700; color: #ffffff; font-size: 1.75rem;">
                        Konfirmasi Pemesanan Event
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                    @if(session('error'))
                        <div class="alert" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b; padding: 1rem;">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @php
                        $pending = session('pending_event_booking');
                    @endphp

                    @if($pending)
                        <!-- Event Info -->
                        <div class="alert mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
                            <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.2rem;">{{ $pending['event_title'] }}</h5>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <i class="fas fa-calendar me-2" style="color: #FACC15;"></i>
                                    <strong>Tanggal:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_date'])->format('d M Y') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FACC15;"></i>
                                    <strong>Waktu:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_time'])->format('H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="card mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <div class="card-body" style="padding: 1.5rem;">
                                <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.1rem;">
                                    <i class="fas fa-user-circle me-2" style="color: #FACC15;"></i>
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
                        <div class="card mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <div class="card-body" style="padding: 1.5rem;">
                                <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.1rem;">
                                    <i class="fas fa-file-invoice me-2" style="color: #FACC15;"></i>
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
                                <hr style="border-color: #e5e7eb;">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold" style="color: #1F2933; font-size: 1.15rem;">Total Pembayaran:</span>
                                    <span class="fw-bold" style="color: #10B981; font-size: 1.35rem;">
                                        Rp {{ number_format($pending['total_harga'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="{{ route('event.payment.initiate') }}" method="POST">
                            @csrf
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-lg fw-bold btn-pay-event" 
                                    style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px;">
                                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-lg btn-cancel-event" 
                                    style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert" style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; color: #92400e; padding: 1rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Data pemesanan tidak ditemukan. Silakan isi form pemesanan kembali.
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-lg btn-back-home" 
                            style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-pay-event {
        background: #10B981;
        color: #ffffff;
        border: 2px solid #10B981;
        transition: all 0.3s ease;
    }
    
    .btn-pay-event:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
    
    .btn-cancel-event,
    .btn-back-home {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .btn-cancel-event:hover,
    .btn-back-home:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
</style>
@endsection
