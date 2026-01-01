@extends('layouts.admin')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid special-tickets-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="bi bi-file-text-fill me-3"></i>Detail Permintaan Tiket Khusus
            </h1>
            <p class="subtitle-text"><strong>Review Permintaan Tiket Khusus</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Card -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-text me-2"></i>Informasi Pemohon
                </div>
                <div class="card-body">
                    <table class="table table-detail">
                        <tr>
                            <th width="200">ID Permintaan</th>
                            <td><code class="request-id-detail">{{ $request->request_id }}</code></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $request->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $request->email }}</td>
                        </tr>
                        <tr>
                            <th>Negara</th>
                            <td>{{ $request->negara }}</td>
                        </tr>
                        @if($request->provinsi)
                        <tr>
                            <th>Provinsi</th>
                            <td>{{ $request->provinsi }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Kategori Khusus</th>
                            <td><span class="kategori-badge">{{ \App\Models\SpecialTicketRequest::getKategoriLabel($request->kategori_khusus) }}</span></td>
                        </tr>
                        <tr>
                            <th>Jumlah Pengunjung</th>
                            <td>{{ $request->jumlah_pengunjung }} orang</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <td>{{ \Carbon\Carbon::parse($request->tanggal_kunjungan)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $request->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Permintaan</th>
                            <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Dokumen Bukti -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Dokumen Bukti
                </div>
                <div class="card-body text-center">
                    <iframe src="{{ asset('storage/' . $request->bukti_dokumen) }}" width="100%" height="600px" class="border"></iframe>
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $request->bukti_dokumen) }}" target="_blank" class="btn-download">
                            <i class="bi bi-download me-2"></i>Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Status
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status Saat Ini:</strong><br>
                        @if($request->status == 'pending')
                            <span class="status-badge status-pending mt-2 d-inline-block">Pending Review</span>
                        @elseif($request->status == 'approved')
                            <span class="status-badge status-approved mt-2 d-inline-block">Approved</span>
                        @else
                            <span class="status-badge status-rejected mt-2 d-inline-block">Rejected</span>
                        @endif
                    </div>

                    @if($request->reviewed_by)
                        <div class="mb-2">
                            <strong>Direview oleh:</strong><br>
                            {{ $request->admin->nama ?? 'Admin' }}
                        </div>
                        <div class="mb-2">
                            <strong>Tanggal Review:</strong><br>
                            {{ $request->reviewed_at->format('d M Y H:i') }}
                        </div>
                    @endif

                    @if($request->admin_note)
                        <div class="alert-info-custom mt-3">
                            <strong>Catatan Admin:</strong><br>
                            {{ $request->admin_note }}
                        </div>
                    @endif

                    @if($request->booking_id)
                        <div class="alert-success-custom mt-3">
                            <strong>Booking ID:</strong><br>
                            <code class="booking-code">{{ $request->booking_id }}</code>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            @if($request->status == 'pending')
                <div class="detail-card mb-4">
                    <div class="card-header">
                        <i class="bi bi-gear me-2"></i>Aksi
                    </div>
                    <div class="card-body">
                        <!-- Approve Form -->
                        <form action="{{ route('admin.special-tickets.approve', $request->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="admin_note" class="form-control" rows="3" placeholder="Catatan untuk pemohon..."></textarea>
                            </div>
                            <button type="submit" class="btn-approve w-100" onclick="return confirm('Approve permintaan ini dan kirim tiket?')">
                                <i class="bi bi-check-circle me-2"></i>Approve & Kirim Tiket
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('admin.special-tickets.reject', $request->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan *</label>
                                <textarea name="admin_note" class="form-control" rows="3" placeholder="Mengapa ditolak..." required></textarea>
                            </div>
                            <button type="submit" class="btn-reject w-100" onclick="return confirm('Tolak permintaan ini?')">
                                <i class="bi bi-x-circle me-2"></i>Tolak Permintaan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('admin.special-tickets.index') }}" class="btn-kembali w-100">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
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

    /* Table Detail */
    .table-detail {
        margin-bottom: 0;
    }

    .table-detail tr {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-detail tr:last-child {
        border-bottom: none;
    }

    .table-detail th {
        font-weight: 700;
        color: var(--primary-color);
        padding: 1rem;
        font-size: 0.95rem;
    }

    .table-detail td {
        padding: 1rem;
        color: var(--text-secondary);
    }

    /* Request ID Detail */
    .request-id-detail {
        background: var(--primary-color);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        font-family: 'Courier New', monospace;
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

    /* Alerts Custom */
    .alert-info-custom {
        background: rgba(31, 41, 51, 0.1);
        border: 2px solid rgba(31, 41, 51, 0.2);
        border-radius: 1rem;
        padding: 1rem;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .alert-success-custom {
        background: rgba(16, 185, 129, 0.1);
        border: 2px solid rgba(16, 185, 129, 0.3);
        border-radius: 1rem;
        padding: 1rem;
        color: #10B981;
        font-size: 0.9rem;
    }

    .booking-code {
        background: #10B981;
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid rgba(31, 41, 51, 0.2);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(31, 41, 51, 0.15);
        outline: none;
    }

    /* PDF Iframe */
    iframe {
        border: 2px solid rgba(31, 41, 51, 0.2) !important;
        border-radius: 0.75rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Buttons */
    .btn-download {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    .btn-approve {
        background: #10B981;
        color: white;
        border: 2px solid #10B981;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-approve:hover {
        background: #FFFFFF;
        color: #10B981;
        border-color: #10B981;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-reject {
        background: #DC2626;
        color: white;
        border: 2px solid #DC2626;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reject:hover {
        background: #FFFFFF;
        color: #DC2626;
        border-color: #DC2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
    }

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
        justify-content: center;
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
