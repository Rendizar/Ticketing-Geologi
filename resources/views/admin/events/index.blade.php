@extends('layouts.admin')

@section('title', 'Event Management')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid event-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="fas fa-calendar-alt me-3"></i>Event Management
            </h1>
            <p class="subtitle-text"><strong>Kelola Event Museum Geologi Bandung</strong></p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success-custom">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="detail-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-2"></i>
                Daftar Event
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-tambah-event">
                <i class="fas fa-plus me-1"></i> Tambah Event
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="eventsTable" class="table table-event">
                    <thead>
                        <tr>
                            <th><i class="fas fa-image me-1"></i> Gambar</th>
                            <th><i class="fas fa-file-alt me-1"></i> Judul</th>
                            <th><i class="fas fa-calendar me-1"></i> Tanggal</th>
                            <th><i class="fas fa-clock me-1"></i> Waktu</th>
                            <th><i class="fas fa-users me-1"></i> Kapasitas</th>
                            <th><i class="fas fa-toggle-on me-1"></i> Status</th>
                            <th><i class="fas fa-cog me-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="event-row">
                            <td>
                                <div class="event-image-wrapper">
                                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" 
                                        class="event-image">
                                </div>
                            </td>
                            <td class="event-title">{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</td>
                            <td><span class="badge-capacity">{{ $event->capacity }}</span></td>
                            <td>
                                <span class="badge-status {{ $event->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="fas fa-circle me-1"></i>
                                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" 
                                       class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $events->links() }}
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

    .event-content {
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

    /* Button Tambah Event */
    .btn-tambah-event {
        background: #FFFFFF !important;
        color: var(--primary-color) !important;
        border: 2px solid #FFFFFF;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-tambah-event:hover {
        background: #FFFFFF !important;
        color: #FACC15 !important;
        border-color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.4);
    }

    /* Table Styling */
    .table-event {
        margin-bottom: 0;
    }

    .table-event thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-event thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-event tbody tr.event-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-event tbody tr.event-row:hover {
        background: rgba(31, 41, 51, 0.05);
        transform: translateX(5px);
    }

    .table-event tbody td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 0.95rem;
    }

    /* Event Image */
    .event-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .event-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .event-row:hover .event-image {
        transform: scale(1.1);
    }

    /* Event Title */
    .event-title {
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Badge Capacity */
    .badge-capacity {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
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

    .badge-active {
        background: #10B981;
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .badge-inactive {
        background: #DC2626;
        color: white;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

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
    }

    .btn-edit {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-edit:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    .btn-delete {
        background: #DC2626;
        color: white;
        border-color: #DC2626;
    }

    .btn-delete:hover {
        background: #FFFFFF;
        color: #DC2626;
        border-color: #DC2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
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

        .event-image {
            width: 50px;
            height: 50px;
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

    // DataTable
    $(document).ready(function() {
        $('#eventsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection
