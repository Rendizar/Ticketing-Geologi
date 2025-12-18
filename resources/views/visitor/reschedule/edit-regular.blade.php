@extends('layouts.app')

@section('title', 'Ubah Tanggal Kunjungan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); border: none;">
                    <h3 class="mb-0 fw-bold" style="letter-spacing: 1px; text-transform: uppercase; color: #000;">
                        <i class="fas fa-calendar-alt me-2"></i>Ubah Tanggal Kunjungan
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <!-- Current Booking Info -->
                    <div class="alert alert-info mb-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Data Tiket Saat Ini</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>ID Tiket:</strong> {{ $booking->booking_id }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Nama:</strong> {{ $booking->nama }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Email:</strong> {{ $booking->email }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Tanggal Kunjungan Sekarang:</strong><br>
                                <span class="badge bg-warning text-dark fs-6">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Jenis Pemesanan:</strong> {{ ucfirst($booking->jenis_pemesanan) }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Total Pengunjung:</strong> {{ $booking->jumlah_pelajar + $booking->jumlah_umum + $booking->jumlah_asing }} orang
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('tickets.reschedule.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="regular">
                        <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">
                        
                        <!-- Tanggal Baru -->
                        <div class="mb-4">
                            <label for="new_date" class="form-label fw-bold fs-5">Pilih Tanggal Kunjungan Baru</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: #FFD700;">
                                    <i class="bi bi-calendar3" style="color: #FFA500; font-size: 1.5rem;"></i>
                                </span>
                                <input type="date" class="form-control border-2 @error('new_date') is-invalid @enderror" 
                                    id="new_date" name="new_date" 
                                    min="{{ date('Y-m-d') }}" required
                                    style="border-color: #FFD700;">
                                @error('new_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih tanggal minimal hari ini atau setelahnya
                            </small>
                        </div>

                        <!-- Important Notes -->
                        <div class="alert alert-warning">
                            <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Catatan Penting:</h6>
                            <ul class="mb-0 small">
                                <li>Reschedule hanya dapat dilakukan 1 kali</li>
                                <li>Tiket tetap berlaku dengan data pengunjung yang sama</li>
                                <li>Tidak ada biaya tambahan untuk reschedule</li>
                                <li>Pastikan tanggal yang dipilih sesuai dengan rencana kunjungan Anda</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg fw-bold shadow-lg" 
                                style="background: #000; color: #FFD700; border: none; border-radius: 0.75rem; padding: 1rem;">
                                <i class="fas fa-check me-2"></i>Konfirmasi Perubahan
                            </button>
                            <a href="{{ route('tickets.reschedule.form') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
