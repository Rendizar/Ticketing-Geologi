@extends('layouts.app')

@section('title', 'Book Event - ' . $event->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-5" style="background: #1F2933; border: none;">
                    <h3 class="mb-0" style="font-family: 'Merriweather', serif; font-weight: 700; color: #ffffff; font-size: 1.75rem;" data-lang-key="event_booking_title">
                        Pemesanan Tiket Event
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                    <!-- Event Info -->
                    <div class="alert mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
                        <h5 class="fw-bold mb-3" style="color: #1F2933; font-size: 1.2rem;">{{ $event->title }}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-calendar me-2" style="color: #FACC15;"></i>
                                <strong data-lang-key="event_date_label">Tanggal:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-clock me-2" style="color: #FACC15;"></i>
                                <strong data-lang-key="event_time_label">Waktu:</strong> {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} WIB
                            </div>
                            <div class="col-md-12 mb-2">
                                <i class="fas fa-users me-2" style="color: #FACC15;"></i>
                                <strong data-lang-key="event_capacity_label">Kapasitas:</strong> {{ $event->available_slots }} / {{ $event->capacity }} <span data-lang-key="event_remaining">tersisa</span>
                                @if($event->available_slots <= 10 && $event->available_slots > 0)
                                    <span class="badge ms-2" style="background: #FACC15; color: #1F2933; border-radius: 8px; padding: 0.35rem 0.75rem;" data-lang-key="event_almost_sold">Hampir Habis!</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                    <div class="alert" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b; padding: 1rem;">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('event.booking.store') }}" method="POST" id="eventBookingForm">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_name_label">Nama Lengkap</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-person-fill" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                    id="nama" name="nama" value="{{ old('nama') }}" 
                                    data-lang-placeholder="event_name_placeholder"
                                    placeholder="Masukkan nama lengkap" required
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="ticket_email">Email</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-envelope-fill" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    data-lang-placeholder="event_email_placeholder"
                                    placeholder="contoh@email.com" required
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Negara Asal -->
                        <div class="mb-4">
                            <label for="negara" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_country_label">Negara Asal</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-globe-americas" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <select class="form-select @error('negara') is-invalid @enderror" 
                                    id="negara" name="negara" required
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                    <option value="" data-lang-key="form_select_country">Pilih Negara</option>
                                </select>
                                @error('negara')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Provinsi (untuk Indonesia) -->
                        <div class="mb-4" id="provinsi_group" style="display:none;">
                            <label for="provinsi" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_province_label">Provinsi</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-map-fill" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <select class="form-select @error('provinsi') is-invalid @enderror" 
                                    id="provinsi" 
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                    <option value="" data-lang-key="form_select_province">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="provinsi" id="provinsi_name">
                                @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Pemesanan -->
                        <div class="mb-4">
                            <label for="jenis_pemesanan" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_booking_type_label">Jenis Pemesanan</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-ticket-detailed-fill" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <select class="form-select @error('jenis_pemesanan') is-invalid @enderror" 
                                    id="jenis_pemesanan" name="jenis_pemesanan" required
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                                    <option value="" data-lang-key="form_select_booking_type">Pilih Jenis Pemesanan</option>
                                    <option value="individu" {{ old('jenis_pemesanan') == 'individu' ? 'selected' : '' }}>Individu</option>
                                    <option value="rombongan" {{ old('jenis_pemesanan') == 'rombongan' ? 'selected' : '' }}>Rombongan</option>
                                </select>
                                @error('jenis_pemesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama Rombongan -->
                        <div class="mb-4" id="nama_rombongan_group" style="display:none;">
                            <label for="nama_rombongan" class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_group_name_label">Nama Rombongan / Instansi</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="background: #ffffff; border: 1px solid #d1d5db; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i class="fas fa-building" style="color: #9CA3AF; font-size: 1.2rem;"></i>
                                </span>
                                <input type="text" class="form-control" id="nama_rombongan" name="nama_rombongan" 
                                    data-lang-placeholder="event_group_name_placeholder"
                                    placeholder="Nama sekolah / perusahaan" value="{{ old('nama_rombongan') }}"
                                    style="border: 1px solid #d1d5db; border-left: none; border-radius: 0 12px 12px 0; padding: 0.75rem 1rem; font-size: 1rem;">
                            </div>
                        </div>

                        <!-- Jenis Pengunjung Dinamis -->
                        <div class="mb-4" id="jenis_pengunjung_group" style="display:none;">
                            <label class="form-label fw-bold" style="color: #1F2933; font-size: 1.05rem;" data-lang-key="event_visitor_count_label">Jumlah Pengunjung</label>

                            <!-- Individu (1-19 orang) -->
                            <div id="pengunjung_individu" style="display:none;" class="p-4 rounded-3" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
                                <div class="alert mb-3" style="background: rgba(251, 191, 36, 0.1); border: 1px solid #FACC15; border-radius: 8px; padding: 1rem;">
                                    <small>
                                        <i class="bi bi-info-circle-fill me-1"></i>
                                        <span data-lang-key="event_individual_alert"><strong>Individu:</strong> Maksimal 19 orang total. Sistem akan otomatis alihkan ke Rombongan jika ≥20 orang.</span>
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;">Jumlah Pelajar</label>
                                    <div class="row g-3">
                                        @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                        <div class="col-6 col-md-4">
                                            <label class="fw-bold mb-2" style="color: #1F2933;">{{ $v }}</label>
                                            <div class="input-group">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('individu_sub_{{ $k }}',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                                <input type="number" class="form-control text-center fw-bold" id="individu_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('individu_sub_{{ $k }}',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;" data-lang-key="event_general_count_label">Jumlah Umum</label>
                                    <div class="input-group" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('individu_jumlah_umum',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                        <input type="number" class="form-control text-center fw-bold" id="individu_jumlah_umum" name="jumlah_umum" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('individu_jumlah_umum',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;" data-lang-key="event_foreign_count_label">Jumlah Asing</label>
                                    <div class="input-group" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('individu_jumlah_asing',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                        <input type="number" class="form-control text-center fw-bold" id="individu_jumlah_asing" name="jumlah_asing" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('individu_jumlah_asing',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                    </div>
                                </div>

                                <div class="alert mt-3" style="background: #ecfdf5; border: 1px solid #86efac; border-radius: 8px; padding: 1rem;">
                                    <strong style="color: #166534;" data-lang-key="event_total_visitors">Total Pengunjung:</strong> <span id="total_individu" style="color: #166534; font-weight: bold;">0</span> <span data-lang-key="visitors">orang</span>
                                </div>
                            </div>

                            <!-- Rombongan (>=20 orang) -->
                            <div id="pengunjung_rombongan" style="display:none;" class="p-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
                                <div class="alert mb-3" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10B981; border-radius: 8px; padding: 1rem;">
                                    <small>
                                        <i class="bi bi-info-circle-fill me-1"></i>
                                        <span data-lang-key="event_rombongan_alert"><strong>Rombongan:</strong> Minimal 20 orang total. Sistem akan otomatis alihkan ke Individu jika <20 orang.</span>
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;">Jumlah Pelajar</label>
                                    <div class="row g-3">
                                        @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                        <div class="col-6 col-md-4">
                                            <label class="fw-bold mb-2" style="color: #1F2933;">{{ $v }}</label>
                                            <div class="input-group">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                                <input type="number" class="form-control text-center fw-bold" id="rombongan_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" oninput="validateNumberInput(this); checkRombonganLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;" data-lang-key="event_general_count_label">Jumlah Umum</label>
                                    <div class="input-group" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                        <input type="number" class="form-control text-center fw-bold" id="rombongan_jumlah_umum" name="jumlah_umum" value="0" min="0" oninput="validateNumberInput(this); checkRombonganLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #1F2933; font-size: 1rem;" data-lang-key="event_foreign_count_label">Jumlah Asing</label>
                                    <div class="input-group" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',-1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 8px 0 0 8px;">−</button>
                                        <input type="number" class="form-control text-center fw-bold" id="rombongan_jumlah_asing" name="jumlah_asing" value="0" min="0" oninput="validateNumberInput(this); checkRombonganLimit();" style="border: 1px solid #d1d5db; border-left: none; border-right: none;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',1)" style="background-color: #1F2933; color: #FACC15; border: 2px solid #1F2933; min-width: 45px; font-size: 1.5rem; line-height: 1; border-radius: 0 8px 8px 0;">+</button>
                                    </div>
                                </div>

                                <div class="alert mt-3" style="background: #ecfdf5; border: 1px solid #86efac; border-radius: 8px; padding: 1rem;">
                                    <strong style="color: #166534;" data-lang-key="event_total_visitors">Total Pengunjung:</strong> <span id="total_rombongan" style="color: #166534; font-weight: bold;">0</span> <span data-lang-key="visitors" style="color: #166534;">orang</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-lg fw-bold btn-submit-event" id="submitBtn" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px;">
                                <span data-lang-key="event_submit_ticket">Submit Tiket</span>
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-lg btn-back-event" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                                <i class="fas fa-arrow-left me-2"></i><span data-lang-key="event_back_home">Kembali ke Beranda</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi validasi input angka
function validateNumberInput(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value === '' || parseInt(value) < 0) {
        value = '0';
    }
    input.value = value;
}

// Fungsi +/- jumlah
function changeCount(id, delta) {
    const input = document.getElementById(id);
    let val = parseInt(input.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    
    // Limit untuk individu
    if (id.startsWith('individu_') && val > 19) {
        val = 19;
    }
    
    input.value = val;
    
    // Update total
    if (id.startsWith('individu_')) {
        checkIndividuLimit();
    } else if (id.startsWith('rombongan_')) {
        checkRombonganLimit();
    }
}

// Cek limit individu dan auto-switch ke rombongan
function checkIndividuLimit() {
    const total = 
        parseInt(document.getElementById('individu_sub_tk').value || 0) +
        parseInt(document.getElementById('individu_sub_sd').value || 0) +
        parseInt(document.getElementById('individu_sub_smp').value || 0) +
        parseInt(document.getElementById('individu_sub_sma').value || 0) +
        parseInt(document.getElementById('individu_sub_kuliah').value || 0) +
        parseInt(document.getElementById('individu_jumlah_umum').value || 0) +
        parseInt(document.getElementById('individu_jumlah_asing').value || 0);
    
    document.getElementById('total_individu').textContent = total;
    
    if (total >= 20) {
        // Auto switch ke rombongan
        document.getElementById('jenis_pemesanan').value = 'rombongan';
        
        // Copy values ke rombongan
        document.getElementById('rombongan_sub_tk').value = document.getElementById('individu_sub_tk').value;
        document.getElementById('rombongan_sub_sd').value = document.getElementById('individu_sub_sd').value;
        document.getElementById('rombongan_sub_smp').value = document.getElementById('individu_sub_smp').value;
        document.getElementById('rombongan_sub_sma').value = document.getElementById('individu_sub_sma').value;
        document.getElementById('rombongan_sub_kuliah').value = document.getElementById('individu_sub_kuliah').value;
        document.getElementById('rombongan_jumlah_umum').value = document.getElementById('individu_jumlah_umum').value;
        document.getElementById('rombongan_jumlah_asing').value = document.getElementById('individu_jumlah_asing').value;
        
        refreshForm();
        checkRombonganLimit();
        
        alert('Total pengunjung mencapai 20 orang. Sistem otomatis mengubah ke Rombongan.');
    }
}

// Cek limit rombongan dan auto-switch ke individu
function checkRombonganLimit() {
    const total = 
        parseInt(document.getElementById('rombongan_sub_tk').value || 0) +
        parseInt(document.getElementById('rombongan_sub_sd').value || 0) +
        parseInt(document.getElementById('rombongan_sub_smp').value || 0) +
        parseInt(document.getElementById('rombongan_sub_sma').value || 0) +
        parseInt(document.getElementById('rombongan_sub_kuliah').value || 0) +
        parseInt(document.getElementById('rombongan_jumlah_umum').value || 0) +
        parseInt(document.getElementById('rombongan_jumlah_asing').value || 0);
    
    document.getElementById('total_rombongan').textContent = total;
    
    if (total < 20 && total > 0) {
        // Auto switch ke individu
        document.getElementById('jenis_pemesanan').value = 'individu';
        
        // Copy values ke individu
        document.getElementById('individu_sub_tk').value = document.getElementById('rombongan_sub_tk').value;
        document.getElementById('individu_sub_sd').value = document.getElementById('rombongan_sub_sd').value;
        document.getElementById('individu_sub_smp').value = document.getElementById('rombongan_sub_smp').value;
        document.getElementById('individu_sub_sma').value = document.getElementById('rombongan_sub_sma').value;
        document.getElementById('individu_sub_kuliah').value = document.getElementById('rombongan_sub_kuliah').value;
        document.getElementById('individu_jumlah_umum').value = document.getElementById('rombongan_jumlah_umum').value;
        document.getElementById('individu_jumlah_asing').value = document.getElementById('rombongan_jumlah_asing').value;
        
        refreshForm();
        checkIndividuLimit();
        
        alert('Total pengunjung kurang dari 20 orang. Sistem otomatis mengubah ke Individu.');
    }
}

// Logika utama saat jenis pemesanan berubah
function refreshForm() {
    const jenis = document.getElementById('jenis_pemesanan').value;

    document.getElementById('nama_rombongan_group').style.display = (jenis === 'rombongan') ? '' : 'none';

    const jenisGroup = document.getElementById('jenis_pengunjung_group');
    const pengIndividu = document.getElementById('pengunjung_individu');
    const pengRombongan = document.getElementById('pengunjung_rombongan');

    if (jenis === 'individu' || jenis === 'rombongan') {
        jenisGroup.style.display = '';
        
        if (jenis === 'individu') {
            pengIndividu.style.display = '';
            pengRombongan.style.display = 'none';
        } else {
            pengIndividu.style.display = 'none';
            pengRombongan.style.display = '';
        }
    } else {
        jenisGroup.style.display = 'none';
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle form submit - disable inputs yang tidak aktif
    const form = document.getElementById('eventBookingForm');
    form.addEventListener('submit', function(e) {
        const jenis = document.getElementById('jenis_pemesanan').value;
        
        if (jenis === 'individu') {
            // Disable semua input rombongan
            document.querySelectorAll('#pengunjung_rombongan input[type="number"]').forEach(input => {
                input.disabled = true;
            });
        } else if (jenis === 'rombongan') {
            // Disable semua input individu
            document.querySelectorAll('#pengunjung_individu input[type="number"]').forEach(input => {
                input.disabled = true;
            });
        }
    });

    // Populate countries
    const countryList = [
        {name: "Indonesia", code: "ID"}, {name: "Malaysia", code: "MY"}, {name: "Singapore", code: "SG"}, 
        {name: "Thailand", code: "TH"}, {name: "Vietnam", code: "VN"}, {name: "Australia", code: "AU"}, 
        {name: "United States", code: "US"}, {name: "United Kingdom", code: "GB"}, {name: "Afghanistan", code: "AF"}, 
        {name: "Albania", code: "AL"}, {name: "Algeria", code: "DZ"}, {name: "Andorra", code: "AD"}, 
        {name: "Angola", code: "AO"}, {name: "Antigua and Barbuda", code: "AG"}, {name: "Argentina", code: "AR"}, 
        {name: "Armenia", code: "AM"}, {name: "Austria", code: "AT"}, {name: "Azerbaijan", code: "AZ"}, 
        {name: "Bahamas", code: "BS"}, {name: "Bahrain", code: "BH"}, {name: "Bangladesh", code: "BD"}, 
        {name: "Barbados", code: "BB"}, {name: "Belarus", code: "BY"}, {name: "Belgium", code: "BE"}, 
        {name: "Belize", code: "BZ"}, {name: "Benin", code: "BJ"}, {name: "Bhutan", code: "BT"}, 
        {name: "Bolivia", code: "BO"}, {name: "Bosnia and Herzegovina", code: "BA"}, {name: "Botswana", code: "BW"}, 
        {name: "Brazil", code: "BR"}, {name: "Brunei", code: "BN"}, {name: "Bulgaria", code: "BG"}, 
        {name: "Burkina Faso", code: "BF"}, {name: "Burundi", code: "BI"}, {name: "Cabo Verde", code: "CV"}, 
        {name: "Cambodia", code: "KH"}, {name: "Cameroon", code: "CM"}, {name: "Canada", code: "CA"}, 
        {name: "Central African Republic", code: "CF"}, {name: "Chad", code: "TD"}, {name: "Chile", code: "CL"}, 
        {name: "China", code: "CN"}, {name: "Colombia", code: "CO"}, {name: "Comoros", code: "KM"}, 
        {name: "Congo", code: "CG"}, {name: "Costa Rica", code: "CR"}, {name: "Croatia", code: "HR"}, 
        {name: "Cuba", code: "CU"}, {name: "Cyprus", code: "CY"}, {name: "Czechia", code: "CZ"}, 
        {name: "Denmark", code: "DK"}, {name: "Djibouti", code: "DJ"}, {name: "Dominica", code: "DM"}, 
        {name: "Dominican Republic", code: "DO"}, {name: "Ecuador", code: "EC"}, {name: "Egypt", code: "EG"}, 
        {name: "El Salvador", code: "SV"}, {name: "Equatorial Guinea", code: "GQ"}, {name: "Eritrea", code: "ER"}, 
        {name: "Estonia", code: "EE"}, {name: "Eswatini", code: "SZ"}, {name: "Ethiopia", code: "ET"}, 
        {name: "Fiji", code: "FJ"}, {name: "Finland", code: "FI"}, {name: "France", code: "FR"}, 
        {name: "Gabon", code: "GA"}, {name: "Gambia", code: "GM"}, {name: "Georgia", code: "GE"}, 
        {name: "Germany", code: "DE"}, {name: "Ghana", code: "GH"}, {name: "Greece", code: "GR"}, 
        {name: "Grenada", code: "GD"}, {name: "Guatemala", code: "GT"}, {name: "Guinea", code: "GN"}, 
        {name: "Guinea-Bissau", code: "GW"}, {name: "Guyana", code: "GY"}, {name: "Haiti", code: "HT"}, 
        {name: "Honduras", code: "HN"}, {name: "Hungary", code: "HU"}, {name: "Iceland", code: "IS"}, 
        {name: "India", code: "IN"}, {name: "Iran", code: "IR"}, {name: "Iraq", code: "IQ"}, 
        {name: "Ireland", code: "IE"}, {name: "Israel", code: "IL"}, {name: "Italy", code: "IT"}, 
        {name: "Jamaica", code: "JM"}, {name: "Japan", code: "JP"}, {name: "Jordan", code: "JO"}, 
        {name: "Kazakhstan", code: "KZ"}, {name: "Kenya", code: "KE"}, {name: "Kiribati", code: "KI"}, 
        {name: "Kuwait", code: "KW"}, {name: "Kyrgyzstan", code: "KG"}, {name: "Laos", code: "LA"}, 
        {name: "Latvia", code: "LV"}, {name: "Lebanon", code: "LB"}, {name: "Lesotho", code: "LS"}, 
        {name: "Liberia", code: "LR"}, {name: "Libya", code: "LY"}, {name: "Liechtenstein", code: "LI"}, 
        {name: "Lithuania", code: "LT"}, {name: "Luxembourg", code: "LU"}, {name: "Madagascar", code: "MG"}, 
        {name: "Malawi", code: "MW"}, {name: "Maldives", code: "MV"}, {name: "Mali", code: "ML"}, 
        {name: "Malta", code: "MT"}, {name: "Marshall Islands", code: "MH"}, {name: "Mauritania", code: "MR"}, 
        {name: "Mauritius", code: "MU"}, {name: "Mexico", code: "MX"}, {name: "Micronesia", code: "FM"}, 
        {name: "Moldova", code: "MD"}, {name: "Monaco", code: "MC"}, {name: "Mongolia", code: "MN"}, 
        {name: "Montenegro", code: "ME"}, {name: "Morocco", code: "MA"}, {name: "Mozambique", code: "MZ"}, 
        {name: "Myanmar", code: "MM"}, {name: "Namibia", code: "NA"}, {name: "Nauru", code: "NR"}, 
        {name: "Nepal", code: "NP"}, {name: "Netherlands", code: "NL"}, {name: "New Zealand", code: "NZ"}, 
        {name: "Nicaragua", code: "NI"}, {name: "Niger", code: "NE"}, {name: "Nigeria", code: "NG"}, 
        {name: "North Korea", code: "KP"}, {name: "North Macedonia", code: "MK"}, {name: "Norway", code: "NO"}, 
        {name: "Oman", code: "OM"}, {name: "Pakistan", code: "PK"}, {name: "Palau", code: "PW"}, 
        {name: "Palestine", code: "PS"}, {name: "Panama", code: "PA"}, {name: "Papua New Guinea", code: "PG"}, 
        {name: "Paraguay", code: "PY"}, {name: "Peru", code: "PE"}, {name: "Philippines", code: "PH"}, 
        {name: "Poland", code: "PL"}, {name: "Portugal", code: "PT"}, {name: "Qatar", code: "QA"}, 
        {name: "Romania", code: "RO"}, {name: "Russia", code: "RU"}, {name: "Rwanda", code: "RW"}, 
        {name: "Saint Kitts and Nevis", code: "KN"}, {name: "Saint Lucia", code: "LC"}, 
        {name: "Saint Vincent and the Grenadines", code: "VC"}, {name: "Samoa", code: "WS"}, 
        {name: "San Marino", code: "SM"}, {name: "Sao Tome and Principe", code: "ST"}, 
        {name: "Saudi Arabia", code: "SA"}, {name: "Senegal", code: "SN"}, {name: "Serbia", code: "RS"}, 
        {name: "Seychelles", code: "SC"}, {name: "Sierra Leone", code: "SL"}, {name: "Slovakia", code: "SK"}, 
        {name: "Slovenia", code: "SI"}, {name: "Solomon Islands", code: "SB"}, {name: "Somalia", code: "SO"}, 
        {name: "South Africa", code: "ZA"}, {name: "South Korea", code: "KR"}, {name: "South Sudan", code: "SS"}, 
        {name: "Spain", code: "ES"}, {name: "Sri Lanka", code: "LK"}, {name: "Sudan", code: "SD"}, 
        {name: "Suriname", code: "SR"}, {name: "Sweden", code: "SE"}, {name: "Switzerland", code: "CH"}, 
        {name: "Syria", code: "SY"}, {name: "Taiwan", code: "TW"}, {name: "Tajikistan", code: "TJ"}, 
        {name: "Tanzania", code: "TZ"}, {name: "Timor-Leste", code: "TL"}, {name: "Togo", code: "TG"}, 
        {name: "Tonga", code: "TO"}, {name: "Trinidad and Tobago", code: "TT"}, {name: "Tunisia", code: "TN"}, 
        {name: "Turkey", code: "TR"}, {name: "Turkmenistan", code: "TM"}, {name: "Tuvalu", code: "TV"}, 
        {name: "Uganda", code: "UG"}, {name: "Ukraine", code: "UA"}, {name: "United Arab Emirates", code: "AE"}, 
        {name: "Uruguay", code: "UY"}, {name: "Uzbekistan", code: "UZ"}, {name: "Vanuatu", code: "VU"}, 
        {name: "Vatican City", code: "VA"}, {name: "Venezuela", code: "VE"}, {name: "Yemen", code: "YE"}, 
        {name: "Zambia", code: "ZM"}, {name: "Zimbabwe", code: "ZW"}
    ];
    
    const negaraSelect = document.getElementById('negara');
    countryList.forEach(item => {
        const option = document.createElement('option');
        option.value = item.name;
        option.textContent = item.name;
        negaraSelect.appendChild(option);
    });

    // Load provinsi dari API Wilayah Indonesia
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(response => response.json())
        .then(data => {
            const provinsiSelect = document.getElementById('provinsi');
            data.forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov.id;
                opt.textContent = prov.name;
                provinsiSelect.appendChild(opt);
            });
        });

    // Simpan nama provinsi ketika dipilih
    document.getElementById('provinsi').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const provName = selectedOption ? selectedOption.textContent : '';
        const provinsiNameInput = document.getElementById('provinsi_name');
        
        if (provinsiNameInput) {
            provinsiNameInput.value = provName || '';
        }
    });

    // Show/hide provinsi field when Indonesia is selected
    document.getElementById('negara').addEventListener('change', function() {
        const provinsiGroup = document.getElementById('provinsi_group');
        if (this.value === 'Indonesia') {
            provinsiGroup.style.display = '';
        } else {
            provinsiGroup.style.display = 'none';
        }
    });

    // Event listeners
    document.getElementById('jenis_pemesanan').addEventListener('change', refreshForm);
});
</script>

<style>
    .btn-submit-event {
        background: #FACC15;
        color: #1F2933;
        border: 2px solid #FACC15;
        transition: all 0.3s ease;
        font-weight: 700;
    }
    
    .btn-submit-event:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.4);
    }
    
    .btn-back-event {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .btn-back-event:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
</style>
@endsection
