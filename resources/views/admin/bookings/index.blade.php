@extends('layouts.admin')

@section('title', 'Riwayat Tiket & Pembayaran')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid booking-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="fas fa-receipt me-3"></i>Riwayat Tiket & Pembayaran
            </h1>
            <p class="subtitle-text"><strong>Kelola dan Pantau Semua Transaksi Tiket Reguler dan Event</strong></p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="detail-card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-2"></i> Filter Pencarian
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Cari
                    </label>
                    <input type="text" name="search" class="form-control-custom" placeholder="Kode booking / Nama / Email" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-info-circle me-1"></i> Status
                    </label>
                    <select name="status" class="form-select-custom">
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
                    <label class="form-label fw-semibold">
                        <i class="fas fa-ticket-alt me-1"></i> Tipe
                    </label>
                    <select name="type" class="form-select-custom">
                        <option value="">Semua Tipe</option>
                        <option value="regular" {{ request('type') == 'regular' ? 'selected' : '' }}>Tiket Reguler</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Tiket Event</option>
                        <option value="special" {{ request('type') == 'special' ? 'selected' : '' }}>Tiket Khusus</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-day me-1"></i> Dari Tanggal
                    </label>
                    <input type="date" name="date_from" class="form-control-custom" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-check me-1"></i> Sampai Tanggal
                    </label>
                    <input type="date" name="date_to" class="form-control-custom" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-filter-action flex-fill" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn-reset-action flex-fill" title="Reset Filter">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="detail-card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i> Daftar Transaksi
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-booking">
                    <thead>
                        <tr>
                            <th><i class="fas fa-barcode me-1"></i> Kode Booking</th>
                            <th><i class="fas fa-user me-1"></i> Pengunjung</th>
                            <th><i class="fas fa-calendar-alt me-1"></i> Tanggal Kunjungan</th>
                            <th><i class="fas fa-tag me-1"></i> Tipe</th>
                            <th><i class="fas fa-money-bill-wave me-1"></i> Total</th>
                            <th><i class="fas fa-toggle-on me-1"></i> Status</th>
                            <th><i class="fas fa-clock me-1"></i> Tanggal Booking</th>
                            <th><i class="fas fa-cog me-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr class="booking-row">
                            <td>
                                <strong class="booking-code">{{ $booking->booking_id }}</strong>
                            </td>
                            <td>
                                <div class="user-info">
                                    <strong>{{ $booking->nama }}</strong><br>
                                    <small class="text-muted">{{ $booking->email }}</small>
                                </div>
                            </td>
                            <td>
                                @if($booking->tanggal_kunjungan)
                                    <span class="date-text">{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d M Y') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->type == 'event')
                                    <span class="badge-type badge-event">
                                        <i class="fas fa-calendar-alt me-1"></i>Event
                                    </span>
                                @elseif($booking->type == 'special')
                                    <span class="badge-type badge-special">
                                        <i class="fas fa-star me-1"></i>Khusus
                                    </span>
                                @else
                                    <span class="badge-type badge-regular">
                                        <i class="fas fa-ticket-alt me-1"></i>Reguler
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($booking->type == 'special')
                                    <span class="price-free">GRATIS</span>
                                @else
                                    <strong class="price-text">Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</strong>
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'paid')
                                    <span class="badge-status badge-paid">
                                        <i class="fas fa-check-circle me-1"></i>Lunas
                                    </span>
                                @elseif($booking->status == 'pending')
                                    <span class="badge-status badge-pending">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @elseif($booking->status == 'approved')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @elseif($booking->status == 'rejected')
                                    <span class="badge-status badge-rejected">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @elseif($booking->status == 'expired')
                                    <span class="badge-status badge-expired">
                                        <i class="fas fa-ban me-1"></i>Expired
                                    </span>
                                @else
                                    <span class="badge-status badge-cancelled">
                                        <i class="fas fa-ban me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="date-text">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.detail', $booking->id) }}" class="btn-action btn-detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-4x mb-3"></i>
                                    <p class="text-muted fw-semibold">Tidak ada data booking</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-color: #1F2933;
        --secondary-color: #3B82F6;
        --success-color: #10B981;
        --warning-color: #FACC15;
        --danger-color: #DC2626;
        --text-primary: #1F2933;
        --text-secondary: #6B7280;
        --bg-white: #ffffff;
        --mg-muted: #6c6c6c;
    }

    /* Particles Background */
    #particles-js {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .booking-content {
        position: relative;
        z-index: 1;
        padding: 2rem;
    }

    /* Brand Text */
    .brand-text {
        font-family: 'Montserrat', 'Futura PT', 'Century Gothic', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: var(--primary-color);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        animation: fadeInDown 0.8s ease-out;
    }

    .brand-text i {
        color: var(--primary-color);
    }

    .subtitle-text {
        color: var(--mg-muted);
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Detail Card */
    .detail-card {
        background: var(--bg-white) !important;
        border: 2px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
        animation: fadeIn 1s ease-out;
    }

    .detail-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        transform: translateY(-5px);
    }

    .detail-card .card-header {
        background: var(--primary-color);
        color: white;
        padding: 1.25rem;
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: none;
        border-radius: 1.25rem 1.25rem 0 0;
    }

    .detail-card .card-body {
        padding: 1.5rem;
    }

    /* Form Controls */
    .form-label {
        color: var(--text-primary);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control-custom,
    .form-select-custom {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(31, 41, 51, 0.1);
        outline: none;
    }

    /* Filter Buttons */
    .btn-filter-action {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
        border-radius: 0.75rem;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-filter-action:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    .btn-reset-action {
        background: #6B7280;
        color: white;
        border: 2px solid #6B7280;
        border-radius: 0.75rem;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset-action:hover {
        background: #FFFFFF;
        color: #6B7280;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
    }

    /* Table Styling */
    .table-booking {
        margin-bottom: 0;
    }

    .table-booking thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-booking thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-booking tbody tr.booking-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-booking tbody tr.booking-row:hover {
        background: rgba(31, 41, 51, 0.05);
        transform: translateX(5px);
    }

    .table-booking tbody td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 0.95rem;
    }

    /* Booking Code */
    .booking-code {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1rem;
    }

    /* User Info */
    .user-info strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    .user-info small {
        color: var(--text-secondary);
    }

    /* Date Text */
    .date-text {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Badge Type */
    .badge-type {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge-event {
        background: #3B82F6;
        color: white;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .badge-special {
        background: #FACC15;
        color: var(--primary-color);
        box-shadow: 0 4px 10px rgba(250, 204, 21, 0.3);
    }

    .badge-regular {
        background: #6B7280;
        color: white;
        box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);
    }

    /* Price Text */
    .price-text {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1rem;
    }

    .price-free {
        color: var(--success-color);
        font-weight: 700;
        font-size: 1rem;
    }

    /* Badge Status */
    .badge-status {
        padding: 0.6rem 1.2rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge-paid,
    .badge-approved {
        background: #10B981;
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .badge-pending {
        background: #FACC15;
        color: var(--primary-color);
        box-shadow: 0 4px 10px rgba(250, 204, 21, 0.3);
    }

    .badge-rejected,
    .badge-cancelled {
        background: #DC2626;
        color: white;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }

    .badge-expired {
        background: #6B7280;
        color: white;
        box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);
    }

    /* Action Button */
    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 2px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
    }

    .btn-detail {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-detail:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    /* Empty State */
    .empty-state {
        padding: 2rem;
    }

    .empty-state i {
        color: var(--text-secondary);
        opacity: 0.5;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .brand-text {
            font-size: 1.8rem;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    // Particles.js Configuration
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 60,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: ['#FFD400', '#6c6c6c', '#0b0b0b']
            },
            shape: {
                type: 'polygon',
                stroke: {
                    width: 1,
                    color: '#6c6c6c'
                },
                polygon: {
                    nb_sides: 6
                }
            },
            opacity: {
                value: 0.6,
                random: true,
                anim: {
                    enable: false
                }
            },
            size: {
                value: 12,
                random: true,
                anim: {
                    enable: false
                }
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#808080',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 1,
                direction: 'none',
                out_mode: 'out'
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: true,
                    mode: 'grab'
                },
                onclick: {
                    enable: true,
                    mode: 'push'
                },
                resize: true
            },
            modes: {
                grab: {
                    distance: 140,
                    line_linked: {
                        opacity: 0.5
                    }
                },
                push: {
                    particles_nb: 4
                }
            }
        },
        retina_detect: true
    });
</script>
@endsection
