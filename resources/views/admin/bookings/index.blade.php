@extends('layouts.admin')

@section('title', 'Riwayat Tiket & Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">
                <i class="fas fa-receipt me-3"></i>Riwayat Tiket & Pembayaran
            </h1>
            <p class="page-subtitle">Kelola dan pantau semua transaksi tiket reguler dan event</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Kode booking / Nama / Email" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-select">
                        <option value="">Semua Tipe</option>
                        <option value="regular" {{ request('type') == 'regular' ? 'selected' : '' }}>Tiket Reguler</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Tiket Event</option>
                        <option value="special" {{ request('type') == 'special' ? 'selected' : '' }}>Tiket Khusus</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary flex-fill" title="Reset Filter">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Pengunjung</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Tipe</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $booking->booking_id }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $booking->nama }}</strong><br>
                                    <small class="text-muted">{{ $booking->email }}</small>
                                </div>
                            </td>
                            <td>
                                @if($booking->tanggal_kunjungan)
                                    {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->type == 'event')
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar-alt me-1"></i>Event
                                    </span>
                                @elseif($booking->type == 'special')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star me-1"></i>Khusus
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-ticket-alt me-1"></i>Reguler
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($booking->type == 'special')
                                    <span class="text-success fw-bold">GRATIS</span>
                                @else
                                    <strong>Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</strong>
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'paid')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($booking->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($booking->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($booking->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($booking->status == 'expired')
                                    <span class="badge bg-secondary">Expired</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.detail', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data booking</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
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

.table {
    margin-bottom: 0;
}

.table thead th {
    background: #F9FAFB;
    border-bottom: 2px solid #E5E7EB;
    font-weight: 600;
    color: #1F2933;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background: rgba(59, 130, 246, 0.05);
}

.btn-primary {
    background: #3B82F6;
    border-color: #3B82F6;
}

.btn-primary:hover {
    background: #2563EB;
    border-color: #2563EB;
}
</style>
@endsection
