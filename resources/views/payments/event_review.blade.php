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
                    <h3 class="mb-0" style="font-family: 'Merriweather', serif; font-weight: 700; color: #ffffff; font-size: 1.75rem;" data-lang-key="event_confirmation_title">
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
                                    <strong data-lang-key="event_date_label">Tanggal:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_date'])->format('d M Y') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FACC15;"></i>
                                    <strong data-lang-key="event_time_label">Waktu:</strong><br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse($pending['event_time'])->format('H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="card mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <div class="card-body" style="padding: 1.5rem;">
                                <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.1rem;">
                                    <i class="fas fa-user-circle me-2" style="color: #FACC15;"></i>
                                    <span data-lang-key="event_booker_info">Informasi Pemesan</span>
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong data-lang-key="event_name">Nama:</strong><br>
                                        {{ $pending['nama'] }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong data-lang-key="ticket_email">Email:</strong><br>
                                        {{ $pending['email'] }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong data-lang-key="event_ticket_count">Jumlah Tiket:</strong><br>
                                        {{ $pending['jumlah_tiket'] }} <span data-lang-key="event_ticket_plural">tiket</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Pengunjung & Harga -->
                        <div class="card mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <div class="card-body" style="padding: 1.5rem;">
                                <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.1rem;">
                                    <i class="fas fa-ticket-alt me-2" style="color: #FACC15;"></i>
                                    <span data-lang-key="event_visitor_details">Detail Pengunjung & Harga</span>
                                </h5>
                                
                                @php
                                    // Untuk event, menggunakan harga dari pengaturan admin (sama dengan tiket reguler)
                                    $hargaPelajar = $pending['harga_pelajar'] ?? 0;
                                    $hargaUmum = $pending['harga_umum'] ?? 0;
                                    $hargaAsing = $pending['harga_asing'] ?? 0;
                                    
                                    $jumlahPelajar = ($pending['sub_tk'] ?? 0) + ($pending['sub_sd'] ?? 0) + ($pending['sub_smp'] ?? 0) + ($pending['sub_sma'] ?? 0) + ($pending['sub_kuliah'] ?? 0);
                                    $jumlahUmum = $pending['jumlah_umum'] ?? 0;
                                    $jumlahAsing = $pending['jumlah_asing'] ?? 0;
                                @endphp
                                
                                <div class="list-group list-group-flush">
                                    @if($jumlahPelajar > 0)
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                            <div>
                                                <i class="bi bi-mortarboard-fill me-2" style="color: #10B981;"></i>
                                                <span class="fw-semibold" data-lang-key="student_price">Pelajar</span>
                                                <span class="badge" style="background: #10B981; color: white;">{{ $jumlahPelajar }} <span data-lang-key="event_ticket_plural">tiket</span></span>
                                                <br><small class="text-muted ms-4" data-lang-key="event_at_price">@</small> <small class="text-muted">Rp {{ number_format($hargaPelajar, 0, ',', '.') }}</small>
                                                
                                                @php
                                                    $subDetails = [];
                                                    if(($pending['sub_tk'] ?? 0) > 0) $subDetails[] = 'TK: ' . $pending['sub_tk'];
                                                    if(($pending['sub_sd'] ?? 0) > 0) $subDetails[] = 'SD: ' . $pending['sub_sd'];
                                                    if(($pending['sub_smp'] ?? 0) > 0) $subDetails[] = 'SMP: ' . $pending['sub_smp'];
                                                    if(($pending['sub_sma'] ?? 0) > 0) $subDetails[] = 'SMA: ' . $pending['sub_sma'];
                                                    if(($pending['sub_kuliah'] ?? 0) > 0) $subDetails[] = 'Kuliah: ' . $pending['sub_kuliah'];
                                                @endphp
                                                
                                                @if(count($subDetails) > 0)
                                                    <br><small class="text-muted ms-4" style="font-size: 0.75rem;">({{ implode(', ', $subDetails) }})</small>
                                                @endif
                                            </div>
                                            <strong style="color: #1F2933; font-size: 1.1rem;">
                                                Rp {{ number_format($jumlahPelajar * $hargaPelajar, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    @endif
                                    
                                    @if($jumlahUmum > 0)
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                            <div>
                                                <i class="bi bi-person-fill me-2" style="color: #3B82F6;"></i>
                                                <span class="fw-semibold" data-lang-key="general_price">Umum</span>
                                                <span class="badge" style="background: #3B82F6; color: white;">{{ $jumlahUmum }} <span data-lang-key="event_ticket_plural">tiket</span></span>
                                                <br><small class="text-muted ms-4" data-lang-key="event_at_price">@</small> <small class="text-muted">Rp {{ number_format($hargaUmum, 0, ',', '.') }}</small>
                                            </div>
                                            <strong style="color: #1F2933; font-size: 1.1rem;">
                                                Rp {{ number_format($jumlahUmum * $hargaUmum, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    @endif
                                    
                                    @if($jumlahAsing > 0)
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3" style="background: transparent;">
                                            <div>
                                                <i class="bi bi-globe-americas me-2" style="color: #FACC15;"></i>
                                                <span class="fw-semibold" data-lang-key="foreign_price">Asing</span>
                                                <span class="badge" style="background: #FACC15; color: #1F2933;">{{ $jumlahAsing }} <span data-lang-key="event_ticket_plural">tiket</span></span>
                                                <br><small class="text-muted ms-4" data-lang-key="event_at_price">@</small> <small class="text-muted">Rp {{ number_format($hargaAsing, 0, ',', '.') }}</small>
                                            </div>
                                            <strong style="color: #1F2933; font-size: 1.1rem;">
                                                Rp {{ number_format($jumlahAsing * $hargaAsing, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section mb-4 p-4 rounded-3 shadow-sm text-center" style="background: #1F2933;">
                            <div class="mb-2" style="color: #E5E7EB; font-size: 0.9rem; font-weight: 600; letter-spacing: 1px; font-family: 'Inter', sans-serif;" data-lang-key="total_payment">
                                TOTAL PEMBAYARAN
                            </div>
                            <div class="total-amount" style="color: #FACC15; font-size: 2.5rem; font-weight: 700; font-family: 'Inter', sans-serif;">
                                Rp {{ number_format($pending['total_harga'], 0, ',', '.') }}
                            </div>
                            <div class="mt-2" style="color: #E5E7EB; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i><span data-lang-key="event_check_details">Harap periksa kembali detail pemesanan Anda</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="{{ route('event.payment.initiate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-payment w-100 mb-3" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-credit-card-fill me-2"></i><span data-lang-key="event_proceed_payment">Lanjutkan ke Pembayaran</span>
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('home') }}" class="btn btn-back w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                                <i class="fas fa-arrow-left me-2"></i><span data-lang-key="event_back_form">Kembali ke Form</span>
                            </a>
                        </div>
                    @else
                        <div class="alert" style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; color: #92400e; padding: 1rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span data-lang-key="event_no_data">Data pemesanan tidak ditemukan. Silakan isi form pemesanan kembali.</span>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-lg btn-back-home" 
                            style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                            <i class="fas fa-arrow-left me-2"></i><span data-lang-key="event_back_to_home">Kembali ke Beranda</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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
</style>
@endsection
