@extends('layouts.app')

@section('title', 'Reschedule Tiket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4 position-relative" style="background: #1F2933; border: none;">
                    <h3 class="mb-0" style="color: #ffffff; font-family: 'Merriweather', serif; font-weight: 700; letter-spacing: 0.5px;">
                        Reschedule Tiket
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                    @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm" style="border-radius: 1rem;">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 1rem;">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="alert alert-info border-0 shadow-sm mb-4" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6 !important; border-radius: 1rem;">
                        <i class="fas fa-info-circle me-2" style="color: #3B82F6;"></i>
                        <strong>Info:</strong> Masukkan ID Tiket atau Unique Key untuk mengubah jadwal kunjungan atau event Anda.
                    </div>

                    <form action="{{ route('tickets.reschedule.check') }}" method="POST">
                        @csrf
                        
                        <!-- ID Tiket -->
                        <div class="mb-4">
                            <label for="booking_id" class="form-label fw-semibold" style="color: #1F2933; font-size: 0.95rem;">
                                <i class="bi bi-ticket-detailed-fill me-1" style="color: #FACC15;"></i>ID Tiket / Unique Key
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: #FACC15; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-ticket-detailed-fill" style="color: #FACC15; font-size: 1.3rem;"></i>
                                </span>
                                <input type="text" class="form-control border-2 @error('booking_id') is-invalid @enderror" 
                                    id="booking_id" name="booking_id" value="{{ old('booking_id') }}" 
                                    placeholder="Contoh: TKT-20251218-123456-ABCD1234" required
                                    style="border-color: #FACC15; border-radius: 0 12px 12px 0; font-family: 'Inter', sans-serif;">
                                @error('booking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size: 0.85rem;">
                                <i class="fas fa-lightbulb me-1" style="color: #FACC15;"></i>
                                ID Tiket dapat ditemukan di email konfirmasi atau PDF tiket Anda
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-search-ticket btn-lg fw-bold" 
                                style="border-radius: 12px; padding: 1rem; font-family: 'Inter', sans-serif; letter-spacing: 0.5px;">
                                <i class="fas fa-search me-2"></i>Cari Tiket
                            </button>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('home') }}" class="btn btn-back-home btn-lg" style="border-radius: 12px; padding: 0.875rem; font-family: 'Inter', sans-serif; font-weight: 600;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
                            </a>
                        </div>
                    </form>

                    <!-- Info Cards -->
                    <div class="row mt-5">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: #ffffff;">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-ticket-alt fa-3x mb-3" style="color: #FACC15;"></i>
                                    <h6 class="fw-bold mb-2" style="color: #1F2933;">Tiket Reguler</h6>
                                    <p class="small text-muted mb-0">Ubah tanggal kunjungan Anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: #ffffff;">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-calendar-check fa-3x mb-3" style="color: #10B981;"></i>
                                    <h6 class="fw-bold mb-2" style="color: #1F2933;">Tiket Event</h6>
                                    <p class="small text-muted mb-0">Pindah ke event lain yang tersedia</p>
                                </div>
                            </div>
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
    .btn-search-ticket {
        background: #FACC15;
        color: #1F2933;
        border: 2px solid #FACC15;
        transition: all 0.3s ease;
        font-weight: 700;
    }
    
    .btn-search-ticket:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.4);
    }
    
    .btn-back-home {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .btn-back-home:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }

    .icon-wrapper {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endsection
