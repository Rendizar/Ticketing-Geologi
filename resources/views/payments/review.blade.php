{{-- resources/views/visitor/review.blade.php --}}
@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 confirmation-card" style="border-radius: 20px; overflow: hidden;">
                <!-- Header dengan tema Modern Geology -->
                <div class="card-header text-center py-4 position-relative" style="background: #1F2933; border: none;">
                    <div class="check-icon-wrapper mb-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: #10B981;"></i>
                    </div>
                    <h3 class="mb-0" style="color: #ffffff; font-family: 'Merriweather', serif; font-weight: 700; letter-spacing: 0.5px;">
                        Konfirmasi Pemesanan Tiket
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 1rem;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('pending_booking'))
                        <!-- Info Section -->
                        <div class="info-section mb-4 p-4 rounded-3 shadow-sm" style="background: #ffffff; border-left: 4px solid #FACC15;">
                            <h5 class="mb-4 fw-semibold" style="color: #1F2933; font-family: 'Inter', sans-serif;">
                                <i class="bi bi-person-circle me-2" style="color: #FACC15;"></i>Informasi Pemesan
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-person-fill me-1" style="color: #9CA3AF;"></i>Nama Lengkap
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ session('pending_booking.form_data.nama') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-envelope-fill me-1" style="color: #9CA3AF;"></i>Email
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ session('pending_booking.form_data.email') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-telephone-fill me-1" style="color: #9CA3AF;"></i>Nomor Telepon
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ session('pending_booking.form_data.nomor_telepon') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-globe-americas me-1" style="color: #9CA3AF;"></i>Negara Asal
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ session('pending_booking.form_data.negara') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-people-fill me-1" style="color: #9CA3AF;"></i>Jenis Pemesanan
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ ucfirst(session('pending_booking.form_data.jenis_pemesanan')) }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-calendar-event-fill me-1" style="color: #9CA3AF;"></i>Tanggal Kunjungan
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ \Carbon\Carbon::parse(session('pending_booking.form_data.tanggal_kunjungan'))->format('d F Y') }}
                                        </div>
                                    </div>
                                </div>
                                
                                @if(session('pending_booking.form_data.nama_rombongan'))
                                <div class="col-12">
                                    <div class="info-item p-3 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                                        <div class="label mb-1" style="font-size: 0.85rem; font-weight: 600; color: #9CA3AF;">
                                            <i class="bi bi-building-fill me-1" style="color: #9CA3AF;"></i>Nama Rombongan / Instansi
                                        </div>
                                        <div class="value fw-semibold" style="color: #1F2933;">
                                            {{ session('pending_booking.form_data.nama_rombongan') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Detail Pengunjung Section -->
                        <div class="visitor-section mb-4 p-4 rounded-3 shadow-sm" style="background: #ffffff; border-left: 4px solid #10B981;">
                            <h5 class="mb-4 fw-semibold" style="color: #1F2933; font-family: 'Inter', sans-serif;">
                                <i class="bi bi-ticket-perforated me-2" style="color: #10B981;"></i>Detail Pengunjung & Harga
                            </h5>
                            
                            <div class="list-group list-group-flush">
                                @if(session('pending_booking.calculated.jumlah_pelajar') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-mortarboard-fill me-2" style="color: #10B981;"></i>
                                            <span class="fw-semibold">Pelajar</span>
                                            <span class="badge" style="background: #10B981; color: white;">{{ session('pending_booking.calculated.jumlah_pelajar') }} orang</span>
                                        </div>
                                        <strong style="color: #1F2933; font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_pelajar') * 3000) }}
                                        </strong>
                                    </div>
                                @endif
                                
                                @if(session('pending_booking.calculated.jumlah_umum') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-person-fill me-2" style="color: #3B82F6;"></i>
                                            <span class="fw-semibold">Umum</span>
                                            <span class="badge" style="background: #3B82F6; color: white;">{{ session('pending_booking.calculated.jumlah_umum') }} orang</span>
                                        </div>
                                        <strong style="color: #1F2933; font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_umum') * 5000) }}
                                        </strong>
                                    </div>
                                @endif
                                
                                @if(session('pending_booking.calculated.jumlah_asing') > 0)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                        <div>
                                            <i class="bi bi-globe-americas me-2" style="color: #FACC15;"></i>
                                            <span class="fw-semibold">Asing</span>
                                            <span class="badge" style="background: #FACC15; color: #1F2933;">{{ session('pending_booking.calculated.jumlah_asing') }} orang</span>
                                        </div>
                                        <strong style="color: #1F2933; font-size: 1.1rem;">
                                            Rp {{ number_format(session('pending_booking.calculated.jumlah_asing') * 25000) }}
                                        </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section mb-4 p-4 rounded-3 shadow-sm text-center" style="background: #1F2933;">
                            <div class="mb-2" style="color: #E5E7EB; font-size: 0.9rem; font-weight: 600; letter-spacing: 1px; font-family: 'Inter', sans-serif;">
                                TOTAL PEMBAYARAN
                            </div>
                            <div class="total-amount" style="color: #FACC15; font-size: 2.5rem; font-weight: 700; font-family: 'Inter', sans-serif;">
                                Rp {{ number_format(session('pending_booking.calculated.total_harga')) }}
                            </div>
                            <div class="mt-2" style="color: #E5E7EB; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i>Harap periksa kembali detail pemesanan Anda
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="{{ route('payment.initiate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-payment w-100 mb-3" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-credit-card-fill me-2"></i>Lanjutkan ke Pembayaran
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('tickets.create') }}" class="btn btn-back w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Form
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
    /* Modern Geology Theme */
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
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.1);
        border-color: #FACC15 !important;
    }
    
    .list-group-item {
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background: #F9FAFB !important;
    }
    
    .total-section {
        transition: all 0.3s ease;
    }
    
    .total-section:hover {
        box-shadow: 0 8px 24px rgba(250, 204, 21, 0.3);
    }
    
    .btn-payment {
        background: #10B981;
        color: white;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-payment:hover {
        background: #1F2933;
        color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
    
    .btn-back {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
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