@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h1 class="page-title">
                <i class="fas fa-file-invoice me-3"></i>Detail Booking
            </h1>
            <p class="page-subtitle">
                @if($type == 'special')
                    {{ $booking->request_id ?? $booking->booking_id }}
                @else
                    {{ $booking->booking_id }}
                @endif
            </p>
        </div>
    </div>

    <div class="row">
        <!-- Booking Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Booking</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Kode Booking</label>
                                <p class="fw-bold text-primary">
                                    @if($type == 'special')
                                        {{ $booking->request_id }}
                                    @else
                                        {{ $booking->booking_id }}
                                    @endif
                                </p>
                            </div>
                            @if($type == 'regular')
                            <div class="info-item">
                                <label>Tanggal Kunjungan</label>
                                <p>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}</p>
                            </div>
                            @elseif($type == 'event')
                            <div class="info-item">
                                <label>Event</label>
                                <p class="fw-bold">{{ $booking->event->nama_event }}</p>
                            </div>
                            <div class="info-item">
                                <label>Tanggal Event</label>
                                <p>{{ \Carbon\Carbon::parse($booking->event->tanggal)->format('d F Y') }}</p>
                            </div>
                            @else
                            <div class="info-item">
                                <label>Tanggal Kunjungan</label>
                                <p>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}</p>
                            </div>
                            <div class="info-item">
                                <label>Kategori Khusus</label>
                                <p class="fw-bold text-warning">{{ ucfirst($booking->kategori_khusus) }}</p>
                            </div>
                            @endif
                            <div class="info-item">
                                <label>Status</label>
                                <p>
                                    @php
                                        $status = ($type == 'regular') ? $booking->status : (($type == 'event') ? $booking->payment_status : $booking->status);
                                    @endphp
                                    @if($status == 'paid')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Nama Pengunjung</label>
                                <p>{{ $booking->nama }}</p>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <p>{{ $booking->email }}</p>
                            </div>
                            @if($booking->nomor_telepon)
                            <div class="info-item">
                                <label>No. Telepon</label>
                                <p>{{ $booking->nomor_telepon }}</p>
                            </div>
                            @endif
                            <div class="info-item">
                                <label>Tanggal Booking</label>
                                <p>{{ $booking->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Detail Tiket</h5>
                </div>
                <div class="card-body">
                    @if($type == 'event')
                        <h6 class="mb-3">Tiket Event:</h6>
                        <div class="event-ticket-item mb-3 p-3" style="background: #F9FAFB; border-radius: 8px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $booking->event->nama_event }}</h6>
                                    <p class="text-muted small mb-0">{{ $booking->jumlah_tiket }} tiket</p>
                                    <p class="text-muted small mb-0">{{ ucfirst($booking->jenis_pemesanan) }}
                                        @if($booking->jenis_pemesanan == 'rombongan' && $booking->nama_rombongan)
                                            - {{ $booking->nama_rombongan }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-end">
                                    <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    @elseif($type == 'special')
                        <h6 class="mb-3">Tiket Khusus:</h6>
                        <div class="alert alert-warning">
                            <i class="fas fa-star me-2"></i>Kategori: <strong>{{ ucfirst($booking->kategori_khusus) }}</strong>
                        </div>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="50%">Jumlah Pengunjung</td>
                                    <td>{{ $booking->jumlah_pengunjung }} orang</td>
                                    <td class="text-end"><span class="badge bg-success">GRATIS</span></td>
                                </tr>
                                @if($booking->keterangan)
                                <tr>
                                    <td colspan="3">
                                        <label class="fw-bold">Keterangan:</label>
                                        <p class="mb-0">{{ $booking->keterangan }}</p>
                                    </td>
                                </tr>
                                @endif
                                @if($booking->bukti_dokumen)
                                <tr>
                                    <td colspan="3">
                                        <label class="fw-bold">Dokumen Pendukung:</label><br>
                                        <a href="{{ Storage::url($booking->bukti_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-download me-1"></i>Lihat Dokumen
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    @else
                        <h6 class="mb-3">Tiket Reguler:</h6>
                        @if($booking->jenis_pemesanan == 'rombongan')
                        <div class="alert alert-info">
                            <i class="fas fa-users me-2"></i>Pemesanan Rombongan: <strong>{{ $booking->nama_rombongan }}</strong>
                        </div>
                        @endif
                        <table class="table table-borderless">
                            <tbody>
                                @if($booking->jumlah_pelajar > 0)
                                <tr>
                                    <td width="50%">Tiket Pelajar</td>
                                    <td>{{ $booking->jumlah_pelajar }} tiket</td>
                                    <td class="text-end">Rp {{ number_format($booking->harga_pelajar_saat_booking * $booking->jumlah_pelajar, 0, ',', '.') }}</td>
                                </tr>
                                @if($booking->sub_tk > 0)
                                <tr class="small text-muted">
                                    <td colspan="3" style="padding-left: 30px;">└ TK: {{ $booking->sub_tk }} siswa</td>
                                </tr>
                                @endif
                                @if($booking->sub_sd > 0)
                                <tr class="small text-muted">
                                    <td colspan="3" style="padding-left: 30px;">└ SD: {{ $booking->sub_sd }} siswa</td>
                                </tr>
                                @endif
                                @if($booking->sub_smp > 0)
                                <tr class="small text-muted">
                                    <td colspan="3" style="padding-left: 30px;">└ SMP: {{ $booking->sub_smp }} siswa</td>
                                </tr>
                                @endif
                                @if($booking->sub_sma > 0)
                                <tr class="small text-muted">
                                    <td colspan="3" style="padding-left: 30px;">└ SMA: {{ $booking->sub_sma }} siswa</td>
                                </tr>
                                @endif
                                @if($booking->sub_kuliah > 0)
                                <tr class="small text-muted">
                                    <td colspan="3" style="padding-left: 30px;">└ Kuliah: {{ $booking->sub_kuliah }} mahasiswa</td>
                                </tr>
                                @endif
                                @endif
                                @if($booking->jumlah_umum > 0)
                                <tr>
                                    <td>Tiket Umum</td>
                                    <td>{{ $booking->jumlah_umum }} tiket</td>
                                    <td class="text-end">Rp {{ number_format($booking->harga_umum_saat_booking * $booking->jumlah_umum, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($booking->jumlah_asing > 0)
                                <tr>
                                    <td>Tiket Asing</td>
                                    <td>{{ $booking->jumlah_asing }} tiket</td>
                                    <td class="text-end">Rp {{ number_format($booking->harga_asing_saat_booking * $booking->jumlah_asing, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($booking->jumlah_tiket_khusus > 0)
                                <tr>
                                    <td>Tiket Khusus ({{ ucfirst($booking->kategori_khusus) }})</td>
                                    <td>{{ $booking->jumlah_tiket_khusus }} tiket</td>
                                    <td class="text-end">Gratis</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <th colspan="2">Total</th>
                                    <th class="text-end">Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="col-md-4">
            @if($type == 'special')
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Status Persetujuan</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label>Status</label>
                        <p>
                            @if($booking->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($booking->status == 'pending')
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif($booking->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </p>
                    </div>
                    @if($booking->admin_notes)
                    <div class="info-item">
                        <label>Catatan Admin</label>
                        <p>{{ $booking->admin_notes }}</p>
                    </div>
                    @endif
                    @if($booking->approved_at)
                    <div class="info-item">
                        <label>{{ $booking->status == 'approved' ? 'Disetujui' : 'Ditolak' }} Pada</label>
                        <p>{{ \Carbon\Carbon::parse($booking->approved_at)->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @elseif($type == 'regular')
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    @if($booking->payment)
                    <div class="info-item">
                        <label>Metode Pembayaran</label>
                        <p class="text-uppercase">{{ $booking->payment->payment_type }}</p>
                    </div>
                    <div class="info-item">
                        <label>Status Pembayaran</label>
                        <p>
                            @if($booking->payment->transaction_status == 'settlement')
                                <span class="badge bg-success">Berhasil</span>
                            @elseif($booking->payment->transaction_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($booking->payment->transaction_status) }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="info-item">
                        <label>Order ID</label>
                        <p><small>{{ $booking->payment->order_id }}</small></p>
                    </div>
                    @if($booking->payment->paid_at)
                    <div class="info-item">
                        <label>Dibayar Pada</label>
                        <p>{{ \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    @else
                    <p class="text-muted text-center">Belum ada informasi pembayaran</p>
                    @endif
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    @if($booking->payment_type)
                    <div class="info-item">
                        <label>Metode Pembayaran</label>
                        <p class="text-uppercase">{{ $booking->payment_type }}</p>
                    </div>
                    @endif
                    <div class="info-item">
                        <label>Status Pembayaran</label>
                        <p>
                            @if($booking->payment_status == 'paid')
                                <span class="badge bg-success">Berhasil</span>
                            @elseif($booking->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($booking->payment_status) }}</span>
                            @endif
                        </p>
                    </div>
                    @if($booking->transaction_id)
                    <div class="info-item">
                        <label>Transaction ID</label>
                        <p><small>{{ $booking->transaction_id }}</small></p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-warning">
                    <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Ringkasan</h6>
                </div>
                <div class="card-body">
                    @if($type == 'special')
                    <div class="d-flex justify-content-between mb-2">
                        <span>Jumlah Pengunjung:</span>
                        <strong>{{ $booking->jumlah_pengunjung }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga:</span>
                        <strong class="text-success">GRATIS</strong>
                    </div>
                    @elseif($type == 'regular')
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Tiket:</span>
                        <strong>{{ ($booking->jumlah_pelajar ?? 0) + ($booking->jumlah_umum ?? 0) + ($booking->jumlah_asing ?? 0) + ($booking->jumlah_tiket_khusus ?? 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga:</span>
                        <strong class="text-primary">Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</strong>
                    </div>
                    @else
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Tiket:</span>
                        <strong>{{ $booking->jumlah_tiket }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga:</span>
                        <strong class="text-primary">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1F2933;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6B7280;
    font-size: 1rem;
}

.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.info-item {
    margin-bottom: 1.5rem;
}

.info-item label {
    display: block;
    font-size: 0.875rem;
    color: #6B7280;
    margin-bottom: 0.25rem;
}

.info-item p {
    margin: 0;
    font-size: 1rem;
    color: #1F2933;
}
</style>
@endsection
