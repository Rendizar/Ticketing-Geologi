@extends('layouts.app')

@section('title', 'Ubah Tanggal Kunjungan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-5" style="background: #1F2933; border: none;">
                    <h3 class="mb-0" style="font-family: 'Merriweather', serif; font-weight: 700; color: #ffffff; font-size: 1.75rem;">
                        Ubah Tanggal Kunjungan
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                    <!-- Current Booking Info -->
                    <div class="alert mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
                        <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.1rem;"><i class="fas fa-info-circle me-2" style="color: #FACC15;"></i>Data Tiket Saat Ini</h5>
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
                                <span class="badge fs-6" style="background: #FACC15; color: #1F2933; border-radius: 8px; padding: 0.5rem 1rem;">
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
                    <div class="alert alert-dismissible fade show" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b;">
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
                            <label for="new_date" class="form-label fw-bold" style="color: #1F2933; font-size: 1.1rem;">Pilih Tanggal Kunjungan Baru</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="fas fa-calendar-alt" style="color: #1F2933; font-size: 1.3rem;"></i>
                                </span>
                                <input type="date" class="form-control @error('new_date') is-invalid @enderror" 
                                    id="new_date" name="new_date" 
                                    min="{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->addDay()->format('Y-m-d') }}" required
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                @error('new_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small style="color: #6c6c6c;">
                                <i class="fas fa-info-circle me-1"></i>
                                Tanggal baru harus lebih lambat dari {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }} (hanya bisa mundur)
                            </small>
                        </div>

                        <!-- Important Notes -->
                        <div class="alert" style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 1.25rem;">
                            <h6 class="fw-bold mb-2" style="color: #92400e;"><i class="fas fa-exclamation-triangle me-2" style="color: #FACC15;"></i>Ketentuan Reschedule:</h6>
                            <ul class="mb-0" style="color: #78350f; font-size: 0.95rem;">
                                <li><strong>Reschedule hanya dapat dilakukan maksimal H-2</strong> dari jadwal kunjungan awal Anda</li>
                                <li><strong>Tanggal baru hanya bisa mundur</strong>, tidak dapat maju dari jadwal awal ({{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }})</li>
                                <li>Reschedule hanya dapat dilakukan 1 kali</li>
                                <li>Tiket tetap berlaku dengan data pengunjung yang sama</li>
                                <li>Tidak ada biaya tambahan untuk reschedule</li>
                                <li>Pastikan tanggal yang dipilih sesuai dengan rencana kunjungan Anda</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-lg fw-bold btn-confirm-change">
                                <i class="fas fa-check me-2"></i>Konfirmasi Perubahan
                            </button>
                            <a href="{{ route('tickets.reschedule.form') }}" class="btn btn-lg btn-back-cancel">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-confirm-change {
        background: #FACC15;
        color: #1F2933;
        border: 2px solid #FACC15;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
        font-weight: 700;
    }
    
    .btn-confirm-change:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.4);
    }
    
    .btn-back-cancel {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-back-cancel:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
</style>
@endsection
