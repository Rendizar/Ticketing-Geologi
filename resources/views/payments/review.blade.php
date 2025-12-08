{{-- resources/views/visitor/review.blade.php --}}
@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 confirmation-card" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header dengan gradient matching tema -->
                <div class="card-header text-center py-4 position-relative" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <div class="check-icon-wrapper mb-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--mg-black); text-shadow: 0 4px 8px rgba(0,0,0,0.2);"></i>
                    </div>
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">
                        KONFIRMASI PEMESANAN TIKET
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 1rem;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('pending_booking'))
                        <!-- Info Section -->
                        <div class="info-section mb-4 p-4 rounded-3 shadow-sm" style="background: rgba(255, 255, 255, 0.9); border-left: 5px solid var(--mg-yellow);">
                            <h5 class="mb-4 fw-bold" style="color: var(--mg-black);">
                                <i class="bi bi-person-circle me-2" style="color: var(--mg-yellow);"></i>Informasi Pemesan
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-person-fill me-1" style="color: var(--mg-yellow);"></i>Nama Lengkap
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ session('pending_booking.form_data.nama') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-envelope-fill me-1" style="color: var(--mg-yellow);"></i>Email
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ session('pending_booking.form_data.email') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-telephone-fill me-1" style="color: var(--mg-yellow);"></i>Nomor Telepon
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ session('pending_booking.form_data.nomor_telepon') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-globe-fill me-1" style="color: var(--mg-yellow);"></i>Negara Asal
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ session('pending_booking.form_data.negara') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-people-fill me-1" style="color: var(--mg-yellow);"></i>Jenis Pemesanan
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ ucfirst(session('pending_booking.form_data.jenis_pemesanan')) }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-calendar-event-fill me-1" style="color: var(--mg-yellow);"></i>Tanggal Kunjungan
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ \Carbon\Carbon::parse(session('pending_booking.form_data.tanggal_kunjungan'))->format('d F Y') }}
                                        </div>
                                    </div>
                                </div>
                                
                                @if(session('pending_booking.form_data.nama_rombongan'))
                                <div class="col-12">
                                    <div class="info-item p-3 rounded-2" style="background: rgba(255, 212, 0, 0.1);">
                                        <div class="label text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                                            <i class="bi bi-building-fill me-1" style="color: var(--mg-yellow);"></i>Nama Rombongan / Instansi
                                        </div>
                                        <div class="value fw-bold" style="color: var(--mg-black);">
                                            {{ session('pending_booking.form_data.nama_rombongan') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Detail Pengunjung Section -->
                        <div class="visitor-section mb-4 p-4 rounded-3 shadow-sm" style="background: rgba(255, 255, 255, 0.9); border-left: 5px solid #28a745;">
                            <h5 class="mb-4 fw-bold" style="color: var(--mg-black);">
                                <i class="bi bi-ticket-perforated me-2" style="color: #28a745;"></i>Detail Pengunjung & Harga
                            </h5>
                            
                            <div class="list-group list-group-flush">
                                @if(session('pending_booking.calculated.jumlah_pelajar') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-mortarboard-fill me-2" style="color: #28a745;"></i>
                                            <span class="fw-semibold">Pelajar</span>
                                            <span class="badge bg-success ms-2">{{ session('pending_booking.calculated.jumlah_pelajar') }} orang</span>
                                        </div>
                                        <strong style="color: var(--mg-black); font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_pelajar') * 3000) }}
                                        </strong>
                                    </div>
                                @endif
                                
                                @if(session('pending_booking.calculated.jumlah_umum') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-person-fill me-2" style="color: #17a2b8;"></i>
                                            <span class="fw-semibold">Umum</span>
                                            <span class="badge bg-info ms-2">{{ session('pending_booking.calculated.jumlah_umum') }} orang</span>
                                        </div>
                                        <strong style="color: var(--mg-black); font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_umum') * 5000) }}
                                        </strong>
                                    </div>
                                @endif
                                
                                @if(session('pending_booking.calculated.jumlah_asing') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-globe-americas me-2" style="color: #ffc107;"></i>
                                            <span class="fw-semibold">Asing</span>
                                            <span class="badge bg-warning text-dark ms-2">{{ session('pending_booking.calculated.jumlah_asing') }} orang</span>
                                        </div>
                                        <strong style="color: var(--mg-black); font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_asing') * 25000) }}
                                        </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section mb-4 p-4 rounded-3 shadow-lg text-center" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: 3px solid #FFD54F;">
                            <div class="mb-2" style="color: var(--mg-black); font-size: 0.9rem; font-weight: 600; letter-spacing: 1px;">
                                TOTAL PEMBAYARAN
                            </div>
                            <div class="total-amount fw-bold" style="color: var(--mg-black); font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">
                                Rp {{ number_format(session('pending_booking.calculated.total_harga')) }}
                            </div>
                            <div class="mt-2" style="color: var(--mg-black); font-size: 0.85rem; opacity: 0.8;">
                                <i class="bi bi-info-circle me-1"></i>Harap periksa kembali detail pemesanan Anda
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="{{ route('payment.initiate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-payment btn-lg w-100 mb-3 shadow-lg" style="border-radius: 50px; padding: 1rem 2rem; font-weight: 800; letter-spacing: 1px;">
                                <i class="bi bi-credit-card-fill me-2"></i>LANJUTKAN KE PEMBAYARAN
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('tickets.create') }}" class="btn btn-back btn-lg shadow-sm" style="border-radius: 50px; padding: 0.875rem 2rem; font-weight: 700; text-decoration: none;">
                                <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Form
                            </a>
                        </div>
                    @endif
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
    }
    
    .confirmation-card {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .check-icon-wrapper {
        animation: checkBounce 0.8s ease-out;
    }
    
    @keyframes checkBounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        60% {
            transform: translateY(-10px);
        }
    }
    
    .info-item {
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(255, 212, 0, 0.3);
    }
    
    .list-group-item {
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background: rgba(255, 212, 0, 0.1) !important;
        transform: translateX(5px);
    }
    
    .total-section {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 8px 25px rgba(255,193,7,0.4);
        }
        50% {
            box-shadow: 0 12px 35px rgba(255,193,7,0.6);
        }
    }
    
    .btn-payment {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: white !important;
        border: 3px solid #34ce57 !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .btn-payment:hover {
        background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-yellow) !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.4);
    }
    
    .btn-back {
        background: rgba(255, 255, 255, 0.9);
        color: var(--mg-black);
        border: 2px solid var(--mg-yellow);
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: var(--mg-yellow);
        color: var(--mg-black);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 212, 0, 0.4);
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .total-amount {
            font-size: 2rem !important;
        }
        
        .btn-payment, .btn-back {
            font-size: 0.95rem;
            padding: 0.875rem 1.5rem !important;
        }
        
        .check-icon-wrapper i {
            font-size: 3rem !important;
        }
        
        .info-section, .visitor-section, .total-section {
            padding: 1.25rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .col-md-6 {
            margin-bottom: 0.5rem;
        }
        
        .total-amount {
            font-size: 1.75rem !important;
        }
        
        .list-group-item {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        
        .list-group-item strong {
            font-size: 1rem !important;
        }
    }
</style>
@endsection