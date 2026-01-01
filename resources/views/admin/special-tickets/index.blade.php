@extends('layouts.admin')

@section('title', 'Special Ticket Requests')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid special-tickets-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="bi bi-ticket-perforated me-3"></i>Permintaan Tiket Khusus
            </h1>
            <p class="subtitle-text"><strong>Kelola Permintaan Tiket Khusus Museum Geologi Bandung</strong></p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="filter-tabs mb-4">
        <div class="tab-container">
            <a class="tab-item {{ $status == 'all' ? 'active' : '' }}" href="{{ route('admin.special-tickets.index') }}">
                <i class="bi bi-list-ul me-2"></i>
                Semua 
                <span class="tab-badge">{{ $requests->total() }}</span>
            </a>
            <a class="tab-item {{ $status == 'pending' ? 'active' : '' }}" href="{{ route('admin.special-tickets.index', ['status' => 'pending']) }}">
                <i class="bi bi-clock-history me-2"></i>
                Pending 
                <span class="tab-badge badge-warning">{{ $pendingCount }}</span>
            </a>
            <a class="tab-item {{ $status == 'approved' ? 'active' : '' }}" href="{{ route('admin.special-tickets.index', ['status' => 'approved']) }}">
                <i class="bi bi-check-circle me-2"></i>
                Approved
            </a>
            <a class="tab-item {{ $status == 'rejected' ? 'active' : '' }}" href="{{ route('admin.special-tickets.index', ['status' => 'rejected']) }}">
                <i class="bi bi-x-circle me-2"></i>
                Rejected
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="detail-card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Daftar Permintaan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-special-tickets">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i> ID</th>
                            <th><i class="bi bi-person me-1"></i> Nama</th>
                            <th><i class="bi bi-tag me-1"></i> Kategori</th>
                            <th><i class="bi bi-people me-1"></i> Jumlah</th>
                            <th><i class="bi bi-calendar-event me-1"></i> Tanggal Kunjungan</th>
                            <th><i class="bi bi-flag me-1"></i> Status</th>
                            <th><i class="bi bi-gear me-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr class="ticket-row">
                                <td><code class="request-id">{{ $req->request_id }}</code></td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name">{{ $req->nama }}</div>
                                        <div class="user-email">{{ $req->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="kategori-badge">
                                        {{ \App\Models\SpecialTicketRequest::getKategoriLabel($req->kategori_khusus) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="jumlah-badge">
                                        <i class="bi bi-people-fill me-1"></i>{{ $req->jumlah_pengunjung }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($req->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="bi bi-clock-history me-1"></i>Pending
                                        </span>
                                    @elseif($req->status == 'approved')
                                        <span class="status-badge status-approved">
                                            <i class="bi bi-check-circle-fill me-1"></i>Approved
                                        </span>
                                    @else
                                        <span class="status-badge status-rejected">
                                            <i class="bi bi-x-circle-fill me-1"></i>Rejected
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.special-tickets.show', $req->id) }}" class="btn-review">
                                        <i class="bi bi-eye me-1"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center empty-state">
                                    <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada permintaan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $requests->links() }}
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

    .special-tickets-content {
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

    /* Alert Success */
    .alert-success-custom {
        background: #10B981;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 1.25rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        animation: slideInDown 0.5s ease-out;
        margin-bottom: 1.5rem;
    }

    /* Filter Tabs */
    .filter-tabs {
        animation: fadeIn 0.8s ease-out;
    }

    .tab-container {
        display: flex;
        gap: 0.5rem;
        background: var(--bg-white);
        padding: 0.75rem;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
    }

    .tab-item {
        flex: 1;
        min-width: 150px;
        padding: 0.875rem 1.25rem;
        text-decoration: none;
        color: var(--primary-color);
        background: rgba(0, 0, 0, 0.03);
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .tab-item:hover {
        background: rgba(31, 41, 51, 0.1);
        transform: translateY(-2px);
        color: var(--primary-color);
    }

    .tab-item.active {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    .tab-badge {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .tab-item.active .tab-badge {
        background: rgba(0, 0, 0, 0.25);
    }

    .tab-badge.badge-warning {
        background: #F59E0B;
        color: white;
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

    /* Table Styling */
    .table-special-tickets {
        margin-bottom: 0;
    }

    .table-special-tickets thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-special-tickets thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-special-tickets tbody tr.ticket-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-special-tickets tbody tr.ticket-row:hover {
        background: rgba(31, 41, 51, 0.05);
        transform: translateX(5px);
    }

    .table-special-tickets tbody td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 0.95rem;
    }

    /* Request ID */
    .request-id {
        background: var(--primary-color);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        font-family: 'Courier New', monospace;
    }

    /* User Info */
    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .user-name {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .user-email {
        color: var(--mg-muted);
        font-size: 0.85rem;
    }

    /* Kategori Badge */
    .kategori-badge {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(31, 41, 51, 0.3);
    }

    /* Jumlah Badge */
    .jumlah-badge {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.6rem 1.2rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .status-pending {
        background: #F59E0B;
        color: white;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .status-approved {
        background: #10B981;
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .status-rejected {
        background: #DC2626;
        color: white;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }

    /* Button Review */
    .btn-review {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-review:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem !important;
    }

    .empty-state i {
        display: block;
        margin-bottom: 1rem;
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

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .brand-text {
            font-size: 1.8rem;
        }

        .tab-container {
            flex-direction: column;
        }

        .tab-item {
            min-width: 100%;
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

