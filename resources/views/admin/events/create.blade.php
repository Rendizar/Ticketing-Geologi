@extends('layouts.admin')

@section('title', 'Tambah Event Baru')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid event-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="fas fa-plus-circle me-3"></i>Tambah Event Baru
            </h1>
            <p class="subtitle-text"><strong>Buat Event Museum Geologi Bandung</strong></p>
        </div>
    </div>

    <div class="detail-card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-plus me-2"></i>
            Form Tambah Event
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Event*</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi*</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Event*</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, GIF (Max. 2MB)</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Tanggal Event*</label>
                            <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                   id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                            @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_time" class="form-label">Waktu Event*</label>
                            <input type="time" class="form-control @error('event_time') is-invalid @enderror" 
                                   id="event_time" name="event_time" value="{{ old('event_time') }}" required>
                            @error('event_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info-custom">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Info Harga:</strong> Event menggunakan harga tiket reguler sesuai kategori (Pelajar, Umum, Asing).
                        </div>

                        <div class="mb-3">
                            <label for="capacity" class="form-label">Kapasitas*</label>
                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                   id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                            @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-simpan">
                        <i class="fas fa-save me-1"></i> Simpan Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-kembali">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
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
        padding: 2rem;
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

    .form-control.is-invalid {
        border-color: #DC2626;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
    }

    .invalid-feedback {
        color: #DC2626;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .text-muted {
        color: var(--mg-muted) !important;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Alert Info Custom */
    .alert-info-custom {
        background: rgba(31, 41, 51, 0.1);
        border: 2px solid rgba(31, 41, 51, 0.2);
        border-radius: 1rem;
        padding: 1rem;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .alert-info-custom i {
        color: var(--primary-color);
    }

    /* Buttons */
    .btn-simpan {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-simpan:hover {
        background: #10B981;
        color: white;
        border-color: #10B981;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-kembali {
        background: #FFFFFF;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
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
            padding: 1.5rem;
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