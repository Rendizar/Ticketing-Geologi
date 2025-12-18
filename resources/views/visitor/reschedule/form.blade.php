@extends('layouts.app')

@section('title', 'Reschedule Tiket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px; text-transform: uppercase;">
                        <i class="fas fa-calendar-alt me-2"></i>Reschedule Tiket
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Masukkan ID Tiket atau Unique Key untuk mengubah jadwal kunjungan atau event Anda.
                    </div>

                    <form action="{{ route('tickets.reschedule.check') }}" method="POST">
                        @csrf
                        
                        <!-- ID Tiket -->
                        <div class="mb-4">
                            <label for="booking_id" class="form-label fw-bold fs-6">ID Tiket / Unique Key</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-ticket-detailed-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <input type="text" class="form-control border-2 @error('booking_id') is-invalid @enderror" 
                                    id="booking_id" name="booking_id" value="{{ old('booking_id') }}" 
                                    placeholder="Contoh: TKT-20251218-123456-ABCD1234" required
                                    style="border-color: var(--mg-yellow);">
                                @error('booking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-lightbulb me-1"></i>
                                ID Tiket dapat ditemukan di email konfirmasi atau PDF tiket Anda
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-lg fw-bold shadow-lg" 
                                style="background: var(--mg-yellow); color: var(--mg-black); border: none; border-radius: 0.75rem; padding: 1rem;">
                                <i class="fas fa-search me-2"></i>Cari Tiket
                            </button>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
                            </a>
                        </div>
                    </form>

                    <!-- Info Cards -->
                    <div class="row mt-5">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-ticket-alt fa-3x mb-3" style="color: var(--mg-yellow);"></i>
                                    <h6 class="fw-bold">Tiket Reguler</h6>
                                    <p class="small text-muted mb-0">Ubah tanggal kunjungan Anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-check fa-3x mb-3" style="color: #FFA500;"></i>
                                    <h6 class="fw-bold">Tiket Event</h6>
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
