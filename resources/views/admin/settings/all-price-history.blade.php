@extends('layouts.admin')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid settings-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="bi bi-clock-history me-3"></i>Riwayat Perubahan Harga
            </h1>
            <p class="subtitle-text"><strong>Lihat Semua Perubahan Harga Tiket Museum Geologi</strong></p>
        </div>
    </div>

    <div class="detail-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <i class="bi bi-table me-2"></i>
                Semua Riwayat Perubahan Harga
            </div>
            <span class="total-badge">{{ $priceHistory->total() }} Total Perubahan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-history-detail">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Kategori</th>
                            <th width="12%">Harga Lama</th>
                            <th width="12%">Harga Baru</th>
                            <th width="10%">Perubahan</th>
                            <th width="15%">Tanggal & Waktu</th>
                            <th width="12%">Diubah Oleh</th>
                            <th width="19%">Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($priceHistory as $index => $history)
                            <tr class="history-row">
                                <td>{{ $priceHistory->firstItem() + $index }}</td>
                                <td>
                                    <strong class="category-name">{{ $history->ticketCategory->name }}</strong>
                                    @if(in_array($history->ticketCategory->code, ['pelajar', 'umum', 'asing']))
                                        <br><span class="badge-main-category">Utama</span>
                                    @endif
                                </td>
                                <td class="text-end"><span class="price-old">Rp {{ number_format($history->old_price, 0, ',', '.') }}</span></td>
                                <td class="text-end"><span class="price-new">Rp {{ number_format($history->new_price, 0, ',', '.') }}</span></td>
                                <td>
                                    @php
                                        $diff = $history->new_price - $history->old_price;
                                        $percentage = $history->old_price > 0 ? (($diff / $history->old_price) * 100) : 0;
                                    @endphp
                                    @if($diff > 0)
                                        <span class="change-badge change-up">
                                            <i class="bi bi-arrow-up"></i> +{{ number_format($percentage, 1) }}%
                                        </span>
                                    @elseif($diff < 0)
                                        <span class="change-badge change-down">
                                            <i class="bi bi-arrow-down"></i> {{ number_format($percentage, 1) }}%
                                        </span>
                                    @else
                                        <span class="change-badge change-neutral">0%</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="date-text">{{ $history->created_at->format('d M Y') }}</span><br>
                                    <small class="time-text">{{ $history->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td class="admin-name">{{ $history->admin->nama_lengkap ?? 'Admin' }}</td>
                                <td>
                                    @if($history->reason)
                                        <small class="reason-text">{{ $history->reason }}</small>
                                    @else
                                        <small class="no-reason">-</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center empty-state">
                                    <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada riwayat perubahan harga</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($priceHistory->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $priceHistory->links() }}
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.settings.index') }}" class="btn-kembali">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Pengaturan
            </a>
        </div>
    </div>
</div>

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

    .settings-content {
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

    .detail-card .card-footer {
        background: rgba(31, 41, 51, 0.03);
        padding: 1.25rem;
        border-top: 2px solid rgba(0, 0, 0, 0.05);
        border-radius: 0 0 1.25rem 1.25rem;
    }

    /* Total Badge */
    .total-badge {
        background: white;
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
    }

    /* Table History Detail */
    .table-history-detail {
        margin-bottom: 0;
    }

    .table-history-detail thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-history-detail thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-history-detail tbody tr.history-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-history-detail tbody tr.history-row:hover {
        background: rgba(31, 41, 51, 0.05);
        transform: translateX(5px);
    }

    .table-history-detail tbody td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 0.95rem;
    }

    /* Category Name */
    .category-name {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Badge Main Category */
    .badge-main-category {
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }

    /* Price Old & New */
    .price-old {
        color: #DC2626;
        font-weight: 600;
        text-decoration: line-through;
    }

    .price-new {
        color: #10B981;
        font-weight: 700;
    }

    /* Change Badge */
    .change-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-block;
    }

    .change-up {
        background: #10B981;
        color: white;
    }

    .change-down {
        background: #DC2626;
        color: white;
    }

    .change-neutral {
        background: var(--mg-muted);
        color: white;
    }

    /* Date & Time */
    .date-text {
        font-weight: 600;
        color: var(--primary-color);
    }

    .time-text {
        color: var(--mg-muted);
    }

    /* Admin Name */
    .admin-name {
        font-weight: 600;
        color: var(--text-secondary);
    }

    /* Reason Text */
    .reason-text {
        color: var(--text-secondary);
        font-style: italic;
    }

    .no-reason {
        color: var(--mg-muted);
        font-style: italic;
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem !important;
    }

    .empty-state i {
        display: block;
        margin-bottom: 1rem;
    }

    /* Button Kembali */
    .btn-kembali {
        background: #FFFFFF;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-kembali:hover {
        background: #FFFFFF;
        color: #FACC15;
        border-color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.4);
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

        .detail-card .card-body {
            padding: 1rem;
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

