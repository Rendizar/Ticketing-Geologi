@extends('layouts.app')

@section('title', 'Pindah ke Event Lain')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); border: none;">
                    <h3 class="mb-0 fw-bold" style="color: #000; letter-spacing: 1px; text-transform: uppercase;">
                        <i class="fas fa-calendar-check me-2"></i>Pindah ke Event Lain
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <!-- Current Booking Info -->
                    <div class="alert" style="background: linear-gradient(135deg, #FFE4B5 0%, #FFD700 30%); border: 3px solid #FFA500;">
                        <h5 class="fw-bold mb-3"><i class="fas fa-ticket-alt me-2"></i>Tiket Event Saat Ini</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>ID Tiket:</strong> {{ $booking->booking_id }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Nama:</strong> {{ $booking->nama }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Event Sekarang:</strong><br>
                                <span class="badge bg-warning text-dark fs-6 mt-1">
                                    {{ $booking->event->title }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Tanggal Event:</strong> {{ \Carbon\Carbon::parse($booking->event->event_date)->format('d F Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Waktu Event:</strong> {{ \Carbon\Carbon::parse($booking->event->event_time)->format('H:i') }} WIB
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Jumlah Tiket:</strong> {{ $booking->jumlah_tiket }} tiket
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Total Bayar:</strong> Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
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
                        <input type="hidden" name="type" value="event">
                        <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">
                        
                        <!-- Pilih Event Baru -->
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-5">Pilih Event Baru</label>
                            
                            @if($availableEvents->count() > 0)
                                <div class="row">
                                    @foreach($availableEvents as $event)
                                    @if($event->id != $booking->event_id)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 border-0 shadow-sm event-card" style="cursor: pointer;">
                                            <input type="radio" name="new_event_id" value="{{ $event->id }}" id="event_{{ $event->id }}" class="d-none event-radio" required>
                                            <label for="event_{{ $event->id }}" class="card-body d-flex flex-column" style="cursor: pointer;">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="fw-bold mb-0">{{ $event->title }}</h6>
                                                    <span class="badge bg-success">Tersedia</span>
                                                </div>
                                                <p class="text-muted small mb-2">{{ Str::limit($event->description, 80) }}</p>
                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between text-muted small">
                                                        <span><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                                        <span><i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</span>
                                                    </div>
                                                    <div class="mt-2">
                                                        <strong style="color: #FFA500;">Rp {{ number_format($event->price, 0, ',', '.') }}</strong>/tiket
                                                        @php
                                                            $newTotal = $event->price * $booking->jumlah_tiket;
                                                            $priceDiff = $newTotal - $booking->total_harga;
                                                        @endphp
                                                        @if($priceDiff > 0)
                                                            <br><small class="text-danger">(+Rp {{ number_format($priceDiff, 0, ',', '.') }})</small>
                                                        @elseif($priceDiff < 0)
                                                            <br><small class="text-success">(-Rp {{ number_format(abs($priceDiff), 0, ',', '.') }})</small>
                                                        @else
                                                            <br><small class="text-muted">(Sama)</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Tidak ada event lain yang tersedia saat ini.
                                </div>
                            @endif
                        </div>

                        <!-- Important Notes -->
                        <div class="alert alert-warning">
                            <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Catatan Penting:</h6>
                            <ul class="mb-0 small">
                                <li>Reschedule hanya dapat dilakukan 1 kali</li>
                                <li>Jumlah tiket tetap sama dengan pemesanan awal</li>
                                <li>Jika harga event baru lebih mahal, harap hubungi admin untuk upgrade</li>
                                <li>Jika harga event baru lebih murah, selisih tidak dapat di-refund</li>
                                <li>Data pengunjung tetap sama</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        @if($availableEvents->count() > 0)
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg fw-bold shadow-lg" 
                                style="background: #FFD700; color: #000; border: none; border-radius: 0.75rem; padding: 1rem;">
                                <i class="fas fa-check me-2"></i>Konfirmasi Pindah Event
                            </button>
                            <a href="{{ route('tickets.reschedule.form') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                        @else
                        <div class="d-grid">
                            <a href="{{ route('tickets.reschedule.form') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.event-card {
    transition: all 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}

.event-radio:checked + label {
    background: linear-gradient(135deg, #FFE4B5 0%, #FFD700 100%);
    border: 3px solid #FFA500 !important;
}

.event-radio:checked + label::before {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    background: #FFA500;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.event-card label {
    position: relative;
}
</style>
@endsection
