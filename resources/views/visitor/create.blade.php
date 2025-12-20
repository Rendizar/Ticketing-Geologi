@extends('layouts.app')

@section('title', 'Submit Ticket')

@section('content')
<div class="row justify-content-center mb-5 pb-5">
    <div class="col-md-10 col-lg-8">
        <div class="card mt-5 shadow-lg border-0 ticket-form-card" style="border-radius: 20px; overflow: hidden;">
            <!-- Header dengan tema Modern Geology -->
            <div class="card-header text-center py-4" style="background: #1F2933; border: none;">
                <h3 class="mb-0" style="color: #ffffff; font-family: 'Merriweather', serif; font-weight: 700; letter-spacing: 0.5px;">
                    Data Pemesanan Tiket
                </h3>
            </div>
            
            <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-semibold">
                            Nama Lengkap
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-person-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" class="form-control modern-ticket-input" id="nama" name="nama" 
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-envelope-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="email" class="form-control modern-ticket-input" id="email" name="email" 
                                placeholder="contoh@email.com" required>
                        </div>
                    </div>

                    <!-- Negara -->
                    <div class="mb-4">
                        <label for="negara" class="form-label fw-semibold">
                            Negara Asal
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-globe-americas" style="color: #9CA3AF;"></i>
                            </span>
                            <select class="form-select modern-ticket-input" id="negara" name="negara" required>
                                <option value="">Pilih Negara</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label for="nomor_telepon" class="form-label fw-semibold">
                            Nomor Telepon
                        </label>
                        <div class="input-group">
                            <select class="form-select modern-ticket-input" id="phone_country_code" style="max-width: 140px; border-radius: 12px 0 0 12px;">
                                <option value="+62" data-flag="🇮🇩">🇮🇩 +62</option>
                            </select>
                            <input type="text" class="form-control modern-ticket-input" id="nomor_telepon" name="nomor_telepon" 
                                placeholder="8123456789" required style="border-radius: 0 12px 12px 0;">
                        </div>
                        <input type="hidden" id="full_phone" name="full_phone">
                    </div>

                    <!-- Jenis Pemesanan -->
                    <div class="mb-4">
                        <label for="jenis_pemesanan" class="form-label fw-semibold">
                            Jenis Pemesanan
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-ticket-detailed-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <select class="form-select modern-ticket-input" id="jenis_pemesanan" name="jenis_pemesanan" required>
                                <option value="">Pilih Jenis Pemesanan</option>
                                <option value="individu">Individu</option>
                                <option value="rombongan">Rombongan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Rombongan -->
                    <div class="mb-4" id="nama_rombongan_group" style="display:none;">
                        <label for="nama_rombongan" class="form-label fw-semibold">
                            Nama Rombongan / Instansi
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-buildings-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" class="form-control modern-ticket-input" id="nama_rombongan" name="nama_rombongan" 
                                placeholder="Nama sekolah / perusahaan">
                        </div>
                    </div>

                    <!-- Jenis Pengunjung Dinamis -->
                    <div class="mb-4" id="jenis_pengunjung_group" style="display:none;">
                        <label class="form-label fw-semibold">
                            Jenis Pengunjung
                        </label>

                        <!-- Individu -->
                        <div id="pengunjung_individu" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 4px solid #FACC15;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Pilih Kategori Individu
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-person-badge-fill" style="color: #9CA3AF;"></i>
                                    </span>
                                    <select class="form-select modern-ticket-input" id="kategori_individu" name="kategori_individu">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Asing -->
                            <div id="individu_asing" style="display:none;" class="alert alert-info border-start border-5 border-primary shadow-sm">
                                <strong>Kategori:</strong> Asing, <strong>Jumlah:</strong> 1
                                <input type="hidden" id="jumlah_asing" name="jumlah_asing" value="1">
                            </div>

                            <!-- Umum -->
                            <div id="individu_umum" style="display:none;">
                                <label class="form-label fw-semibold">
                                    Apakah Anda Pelajar?
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-patch-question-fill" style="color: #9CA3AF;"></i>
                                    </span>
                                    <select class="form-select modern-ticket-input" id="is_pelajar" name="is_pelajar">
                                        <option value="">Pilih</option>
                                        <option value="pelajar">Ya, Pelajar</option>
                                        <option value="bukan">Tidak, Umum</option>
                                    </select>
                                </div>
                            </div>

                            <div id="individu_umum_bukan" style="display:none;" class="alert alert-success border-start border-5 border-success shadow-sm mt-3">
                                <strong>Kategori:</strong> Umum (Bukan Pelajar), <strong>Jumlah:</strong> 1
                                <input type="hidden" id="jumlah_umum" name="jumlah_umum" value="1">
                            </div>

                            <div id="individu_umum_pelajar" style="display:none;" class="mt-3">
                                <label class="form-label fw-semibold">
                                    Pilih Jenjang Pendidikan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-mortarboard-fill" style="color: #9CA3AF;"></i>
                                    </span>
                                    <select class="form-select modern-ticket-input" id="jenjang_pelajar" name="jenjang_pelajar">
                                        <option value="">Pilih Jenjang</option>
                                        <option value="sub_tk">TK</option>
                                        <option value="sub_sd">SD</option>
                                        <option value="sub_smp">SMP</option>
                                        <option value="sub_sma">SMA</option>
                                        <option value="sub_kuliah">Kuliah</option>
                                    </select>
                                </div>
                            </div>

                            <div id="individu_umum_pelajar_jumlah" style="display:none;" class="alert border-start border-5 shadow-sm mt-3" style="background: #FFF3CD; border-color: #FACC15 !important;">
                                <span id="info_pelajar"><strong>Kategori:</strong> Pelajar, <strong>Jumlah:</strong> 1</span>
                                <input type="hidden" id="jumlah_pelajar" name="jumlah_pelajar" value="1">
                                <input type="hidden" id="sub_tk" name="sub_tk" value="0">
                                <input type="hidden" id="sub_sd" name="sub_sd" value="0">
                                <input type="hidden" id="sub_smp" name="sub_smp" value="0">
                                <input type="hidden" id="sub_sma" name="sub_sma" value="0">
                                <input type="hidden" id="sub_kuliah" name="sub_kuliah" value="0">
                            </div>
                        </div>

                        <!-- Rombongan -->
                        <div id="pengunjung_rombongan" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 4px solid #10B981;">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Jumlah Pelajar
                                </label>
                                <div class="row g-3">
                                    @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                    <div class="col-6 col-md-4">
                                        <label class="fw-semibold mb-2 small">
                                            {{ $v }}
                                        </label>
                                        <div class="input-group modern-counter">
                                            <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_sub_{{ $k }}',-1)">
                                                −
                                            </button>
                                            <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" oninput="validateNumberInput(this)">
                                            <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_sub_{{ $k }}',1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Jumlah Umum
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_umum',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_jumlah_umum" name="jumlah_umum" value="0" min="0" oninput="validateNumberInput(this)">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_umum',1)">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Jumlah Asing
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_asing',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_jumlah_asing" name="jumlah_asing" value="0" min="0" oninput="validateNumberInput(this)">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_asing',1)">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Tanggal Kunjungan
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-calendar3" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="date" id="tanggal_kunjungan_raw" class="form-control modern-ticket-input" 
                                min="{{ date('Y-m-d') }}" required>
                            <input type="text" id="tanggal_kunjungan_display" class="form-control modern-ticket-input" 
                                placeholder="Pilih tanggal..." readonly 
                                style="background:white;">
                            <input type="hidden" id="tanggal_kunjungan" name="tanggal_kunjungan" required>
                        </div>
                    </div>

                    <!-- Lokasi Indonesia -->
                    <div id="lokasi_indonesia" style="display:none;">
                        <div class="mb-4">
                            <label for="provinsi" class="form-label fw-semibold">
                                Provinsi
                            </label>
                            <div class="input-group">
                                <span class="input-group-text modern-input-icon">
                                    <i class="bi bi-map-fill" style="color: #9CA3AF;"></i>
                                </span>
                                <select class="form-select modern-ticket-input" id="provinsi">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="provinsi" id="provinsi_name">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="kota_kabupaten" class="form-label fw-semibold">
                                Kota/Kabupaten
                            </label>
                            <div class="input-group">
                                <span class="input-group-text modern-input-icon">
                                    <i class="bi bi-buildings" style="color: #9CA3AF;"></i>
                                </span>
                                <select class="form-select modern-ticket-input" id="kota_kabupaten" name="kota_kabupaten" disabled>
                                    <option value="">Pilih Provinsi terlebih dahulu</option>
                                </select>
                            </div>
                            <small class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i>Kota/Kabupaten akan tersedia setelah memilih provinsi
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ticket-modern w-100 mt-4" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px;">
                        Submit Tiket
                    </button>
                </form>

                <!-- Back to Home Button -->
                <div class="mt-3">
                    <a href="{{ url('/') }}" class="btn btn-back w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Flag Icons CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.11.1/css/flag-icons.min.css" />
<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css" />
<style>
    /* Emoji dan Flag Support */
    select, option {
        font-family: 'Segoe UI Emoji', 'Apple Color Emoji', 'Noto Color Emoji', 'Inter', sans-serif !important;
    }
    
    .flag-icon {
        width: 1.2em;
        height: 0.9em;
        margin-right: 0.5em;
        border-radius: 2px;
        display: inline-block;
        vertical-align: middle;
    }
    
    /* Choices.js customization */
    .choices__inner {
        border: 1px solid #E5E7EB !important;
        border-radius: 12px !important;
        padding: 0.75rem 1rem !important;
        background: #ffffff !important;
        min-height: auto !important;
    }
    
    .choices__inner:focus {
        border-color: #FACC15 !important;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1) !important;
    }
    
    .choices__list--dropdown {
        border: 1px solid #E5E7EB !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
    
    .choices__item--selectable {
        padding: 0.5rem 1rem !important;
    }
    
    /* Modern Geology Theme */
    .ticket-form-card {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Modern Input Styling */
    .modern-ticket-input {
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }
    
    .modern-ticket-input:focus {
        border-color: #FACC15;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
        outline: none;
    }
    
    .modern-input-icon {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-right: none;
        border-radius: 12px 0 0 12px;
    }
    
    .input-group .modern-ticket-input {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }
    
    .form-select {
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        border-color: #FACC15;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
        outline: none;
    }
    
    /* Button Styling */
    .btn-ticket-modern {
        background: #FACC15;
        color: #1F2933;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.3);
    }
    
    .btn-ticket-modern:hover {
        background: #1F2933;
        color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
    
    .btn-outline-warning {
        border-color: #FACC15;
        color: #FACC15;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-warning:hover {
        background: #FACC15;
        color: #1F2933;
        border-color: #FACC15;
    }
    
    label.form-label {
        color: #1F2933;
        margin-bottom: 0.5rem;
        font-family: 'Inter', sans-serif;
    }
    
    /* Counter Buttons */
    .modern-counter {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .btn-counter {
        background: #1F2933;
        color: #FACC15;
        border: none;
        font-size: 1.5rem;
        line-height: 1;
        min-width: 45px;
        padding: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-counter:hover {
        background: #FACC15;
        color: #1F2933;
    }
    
    .counter-input {
        border: 1px solid #E5E7EB;
        border-left: none;
        border-right: none;
        border-radius: 0;
        font-size: 1rem;
    }
    
    .counter-input:focus {
        border-color: #E5E7EB;
        box-shadow: none;
    }
    
    .alert {
        border-radius: 12px;
        font-weight: 600;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .modern-ticket-input {
            font-size: 0.95rem;
        }
        
        .btn-ticket-modern {
            font-size: 0.95rem;
            padding: 0.75rem 1.5rem;
        }
    }

    .btn-back {
        background: #ffffff;
        color: #1F2933;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #1F2933;
        color: #FACC15;
        border-color: #1F2933;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
</style>
@endsection

@section('scripts')
<script>
// Fungsi validasi input angka
function validateNumberInput(input) {
    // Hapus karakter non-digit
    let value = input.value.replace(/[^0-9]/g, '');
    
    // Jika kosong atau negatif, set ke 0
    if (value === '' || parseInt(value) < 0) {
        value = '0';
    }
    
    // Update nilai input
    input.value = value;
}

// Fungsi +/- jumlah (rombongan)
function changeCount(id, delta) {
    const input = document.getElementById(id);
    let val = parseInt(input.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    input.value = val;
}

// Sembunyikan semua detail individu
function hideAllIndividuDetails() {
    const ids = ['individu_asing','individu_umum','individu_umum_bukan','individu_umum_pelajar','individu_umum_pelajar_jumlah'];
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
}

// Update opsi kategori individu berdasarkan negara
function updateKategoriIndividuOptions() {
    const select = document.getElementById('kategori_individu');
    const negara = document.getElementById('negara').value;
    const jenis = document.getElementById('jenis_pemesanan').value;

    select.innerHTML = '<option value="">Pilih Kategori</option>';

    if (jenis !== 'individu') return;

    if (negara === 'Indonesia') {
        select.innerHTML += '<option value="umum">Umum</option>';
    } else if (negara) {
        select.innerHTML += '<option value="asing">Asing</option>';
    }
}

// Logika utama saat jenis pemesanan / negara berubah
function refreshForm() {
    const jenis = document.getElementById('jenis_pemesanan').value;
    const negara = document.getElementById('negara').value;

    document.getElementById('nama_rombongan_group').style.display = (jenis === 'rombongan') ? '' : 'none';

    const jenisGroup = document.getElementById('jenis_pengunjung_group');
    const pengIndividu = document.getElementById('pengunjung_individu');
    const pengRombongan = document.getElementById('pengunjung_rombongan');

    if (jenis === 'individu' || jenis === 'rombongan') {
        jenisGroup.style.display = '';
    } else {
        jenisGroup.style.display = 'none';
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = 'none';
        return;
    }

    if (jenis === 'individu') {
        pengIndividu.style.display = '';
        pengRombongan.style.display = 'none';
        hideAllIndividuDetails();
        updateKategoriIndividuOptions();
    } else {
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = '';
    }

    document.getElementById('lokasi_indonesia').style.display = (negara === 'Indonesia') ? '' : 'none';
}

// Initialize Choices.js for flag icons
function initCountrySelects() {
    const negaraSelect = document.getElementById('negara');
    const phoneCountrySelect = document.getElementById('phone_country_code');
    
    // Check if Choices is loaded
    if (typeof Choices === 'undefined') {
        console.error('Choices.js not loaded');
        return;
    }
    
    // Populate negara dengan bendera
    if (negaraSelect) {
        const negaraChoices = [];
        countryList.forEach(function(item) {
            negaraChoices.push({
                value: item.name,
                label: '<span class="flag-icon flag-icon-' + item.code.toLowerCase() + '"></span> ' + item.name,
                customProperties: {
                    phone: item.phone,
                    code: item.code
                }
            });
        });
        
        window.negaraChoicesInstance = new Choices(negaraSelect, {
            searchEnabled: true,
            itemSelectText: '',
            choices: negaraChoices,
            allowHTML: true,
            shouldSort: false
        });
    }
    
    // Populate phone country codes dengan bendera
    if (phoneCountrySelect) {
        const phoneChoices = [];
        countryList.forEach(function(item) {
            phoneChoices.push({
                value: item.phone,
                label: '<span class="flag-icon flag-icon-' + item.code.toLowerCase() + '"></span> ' + item.phone,
                customProperties: {
                    country: item.name,
                    code: item.code
                }
            });
        });
        
        window.phoneChoicesInstance = new Choices(phoneCountrySelect, {
            searchEnabled: true,
            itemSelectText: '',
            choices: phoneChoices,
            allowHTML: true,
            shouldSort: false
        });
        
        // Set default to Indonesia
        window.phoneChoicesInstance.setChoiceByValue('+62');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Load Choices.js library
    const choicesScript = document.createElement('script');
    choicesScript.src = 'https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js';
    choicesScript.onload = function() {
        initCountrySelects();
    };
    document.head.appendChild(choicesScript);
    
    // Event listeners
    document.getElementById('jenis_pemesanan').addEventListener('change', refreshForm);
    document.getElementById('negara').addEventListener('change', refreshForm);

    // Kategori individu berubah
    document.getElementById('kategori_individu').addEventListener('change', function() {
        hideAllIndividuDetails();
        const val = this.value;

        if (val === 'asing') {
            document.getElementById('individu_asing').style.display = '';
            document.getElementById('jumlah_asing').value = 1;
        } else if (val === 'umum') {
            document.getElementById('individu_umum').style.display = '';
        }
    });

    // Pelajar / bukan
    document.getElementById('is_pelajar').addEventListener('change', function() {
        document.getElementById('individu_umum_bukan').style.display = 'none';
        document.getElementById('individu_umum_pelajar').style.display = 'none';
        document.getElementById('individu_umum_pelajar_jumlah').style.display = 'none';

        if (this.value === 'bukan') {
            document.getElementById('individu_umum_bukan').style.display = '';
            document.getElementById('jumlah_umum').value = 1;
        } else if (this.value === 'pelajar') {
            document.getElementById('individu_umum_pelajar').style.display = '';
        }
    });

    // Jenjang pelajar
    document.getElementById('jenjang_pelajar').addEventListener('change', function() {
        const val = this.value;
        const jumlahDiv = document.getElementById('individu_umum_pelajar_jumlah');
        jumlahDiv.style.display = val ? '' : 'none';

        ['sub_tk','sub_sd','sub_smp','sub_sma','sub_kuliah'].forEach(id => {
            document.getElementById(id).value = 0;
        });

        if (val) {
            document.getElementById(val).value = 1;
            const text = this.options[this.selectedIndex].text;
            document.getElementById('info_pelajar').innerHTML = `<strong>Kategori:</strong> Pelajar ${text}, <strong>Jumlah:</strong> 1`;
        }
    });

    // Format tanggal
    document.getElementById('tanggal_kunjungan_raw').addEventListener('change', function() {
        const raw = this.value;
        if (!raw) return;

        const date = new Date(raw);
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const display = date.toLocaleDateString('id-ID', options);

        document.getElementById('tanggal_kunjungan_display').value = display;
        document.getElementById('tanggal_kunjungan').value = raw;
    });

    // Populate country list with flags
    const countryList = [
        {name: "Indonesia", code: "ID", flag: "🇮🇩", phone: "+62"}, 
        {name: "Malaysia", code: "MY", flag: "🇲🇾", phone: "+60"}, 
        {name: "Singapore", code: "SG", flag: "🇸🇬", phone: "+65"}, 
        {name: "Thailand", code: "TH", flag: "🇹🇭", phone: "+66"}, 
        {name: "Vietnam", code: "VN", flag: "🇻🇳", phone: "+84"}, 
        {name: "Australia", code: "AU", flag: "🇦🇺", phone: "+61"}, 
        {name: "United States", code: "US", flag: "🇺🇸", phone: "+1"}, 
        {name: "United Kingdom", code: "GB", flag: "🇬🇧", phone: "+44"}, 
        {name: "Afghanistan", code: "AF", flag: "🇦🇫", phone: "+93"}, 
        {name: "Albania", code: "AL", flag: "🇦🇱", phone: "+355"}, 
        {name: "Algeria", code: "DZ", flag: "🇩🇿", phone: "+213"}, 
        {name: "Andorra", code: "AD", flag: "🇦🇩", phone: "+376"}, 
        {name: "Angola", code: "AO", flag: "🇦🇴", phone: "+244"}, 
        {name: "Antigua and Barbuda", code: "AG", flag: "🇦🇬", phone: "+1-268"}, 
        {name: "Argentina", code: "AR", flag: "🇦🇷", phone: "+54"}, 
        {name: "Armenia", code: "AM", flag: "🇦🇲", phone: "+374"}, 
        {name: "Austria", code: "AT", flag: "🇦🇹", phone: "+43"}, 
        {name: "Azerbaijan", code: "AZ", flag: "🇦🇿", phone: "+994"}, 
        {name: "Bahamas", code: "BS", flag: "🇧🇸", phone: "+1-242"}, 
        {name: "Bahrain", code: "BH", flag: "🇧🇭", phone: "+973"}, 
        {name: "Bangladesh", code: "BD", flag: "🇧🇩", phone: "+880"}, 
        {name: "Barbados", code: "BB", flag: "🇧🇧", phone: "+1-246"}, 
        {name: "Belarus", code: "BY", flag: "🇧🇾", phone: "+375"}, 
        {name: "Belgium", code: "BE", flag: "🇧🇪", phone: "+32"}, 
        {name: "Belize", code: "BZ", flag: "🇧🇿", phone: "+501"}, 
        {name: "Benin", code: "BJ", flag: "🇧🇯", phone: "+229"}, 
        {name: "Bhutan", code: "BT", flag: "🇧🇹", phone: "+975"}, 
        {name: "Bolivia", code: "BO", flag: "🇧🇴", phone: "+591"}, 
        {name: "Bosnia and Herzegovina", code: "BA", flag: "🇧🇦", phone: "+387"}, 
        {name: "Botswana", code: "BW", flag: "🇧🇼", phone: "+267"}, 
        {name: "Brazil", code: "BR", flag: "🇧🇷", phone: "+55"}, 
        {name: "Brunei", code: "BN", flag: "🇧🇳", phone: "+673"}, 
        {name: "Bulgaria", code: "BG", flag: "🇧🇬", phone: "+359"}, 
        {name: "Burkina Faso", code: "BF", flag: "🇧🇫", phone: "+226"}, 
        {name: "Burundi", code: "BI", flag: "🇧🇮", phone: "+257"}, 
        {name: "Cabo Verde", code: "CV", flag: "🇨🇻", phone: "+238"}, 
        {name: "Cambodia", code: "KH", flag: "🇰🇭", phone: "+855"}, 
        {name: "Cameroon", code: "CM", flag: "🇨🇲", phone: "+237"}, 
        {name: "Canada", code: "CA", flag: "🇨🇦", phone: "+1"}, 
        {name: "Central African Republic", code: "CF", flag: "🇨🇫", phone: "+236"}, 
        {name: "Chad", code: "TD", flag: "🇹🇩", phone: "+235"}, 
        {name: "Chile", code: "CL", flag: "🇨🇱", phone: "+56"}, 
        {name: "China", code: "CN", flag: "🇨🇳", phone: "+86"}, 
        {name: "Colombia", code: "CO", flag: "🇨🇴", phone: "+57"}, 
        {name: "Comoros", code: "KM", flag: "🇰🇲", phone: "+269"}, 
        {name: "Congo", code: "CG", flag: "🇨🇬", phone: "+242"}, 
        {name: "Costa Rica", code: "CR", flag: "🇨🇷", phone: "+506"}, 
        {name: "Croatia", code: "HR", flag: "🇭🇷", phone: "+385"}, 
        {name: "Cuba", code: "CU", flag: "🇨🇺", phone: "+53"}, 
        {name: "Cyprus", code: "CY", flag: "🇨🇾", phone: "+357"}, 
        {name: "Czechia", code: "CZ", flag: "🇨🇿", phone: "+420"}, 
        {name: "Denmark", code: "DK", flag: "🇩🇰", phone: "+45"}, 
        {name: "Djibouti", code: "DJ", flag: "🇩🇯", phone: "+253"}, 
        {name: "Dominica", code: "DM", flag: "🇩🇲", phone: "+1-767"}, 
        {name: "Dominican Republic", code: "DO", flag: "🇩🇴", phone: "+1-809"}, 
        {name: "Ecuador", code: "EC", flag: "🇪🇨", phone: "+593"}, 
        {name: "Egypt", code: "EG", flag: "🇪🇬", phone: "+20"}, 
        {name: "El Salvador", code: "SV", flag: "🇸🇻", phone: "+503"}, 
        {name: "Equatorial Guinea", code: "GQ", flag: "🇬🇶", phone: "+240"}, 
        {name: "Eritrea", code: "ER", flag: "🇪🇷", phone: "+291"}, 
        {name: "Estonia", code: "EE", flag: "🇪🇪", phone: "+372"}, 
        {name: "Eswatini", code: "SZ", flag: "🇸🇿", phone: "+268"}, 
        {name: "Ethiopia", code: "ET", flag: "🇪🇹", phone: "+251"}, 
        {name: "Fiji", code: "FJ", flag: "🇫🇯", phone: "+679"}, 
        {name: "Finland", code: "FI", flag: "🇫🇮", phone: "+358"}, 
        {name: "France", code: "FR", flag: "🇫🇷", phone: "+33"}, 
        {name: "Gabon", code: "GA", flag: "🇬🇦", phone: "+241"}, 
        {name: "Gambia", code: "GM", flag: "🇬🇲", phone: "+220"}, 
        {name: "Georgia", code: "GE", flag: "🇬🇪", phone: "+995"}, 
        {name: "Germany", code: "DE", flag: "🇩🇪", phone: "+49"}, 
        {name: "Ghana", code: "GH", flag: "🇬🇭", phone: "+233"}, 
        {name: "Greece", code: "GR", flag: "🇬🇷", phone: "+30"}, 
        {name: "Grenada", code: "GD", flag: "🇬🇩", phone: "+1-473"}, 
        {name: "Guatemala", code: "GT", flag: "🇬🇹", phone: "+502"}, 
        {name: "Guinea", code: "GN", flag: "🇬🇳", phone: "+224"}, 
        {name: "Guinea-Bissau", code: "GW", flag: "🇬🇼", phone: "+245"}, 
        {name: "Guyana", code: "GY", flag: "🇬🇾", phone: "+592"}, 
        {name: "Haiti", code: "HT", flag: "🇭🇹", phone: "+509"}, 
        {name: "Honduras", code: "HN", flag: "🇭🇳", phone: "+504"}, 
        {name: "Hungary", code: "HU", flag: "🇭🇺", phone: "+36"}, 
        {name: "Iceland", code: "IS", flag: "🇮🇸", phone: "+354"}, 
        {name: "India", code: "IN", flag: "🇮🇳", phone: "+91"}, 
        {name: "Iran", code: "IR", flag: "🇮🇷", phone: "+98"}, 
        {name: "Iraq", code: "IQ", flag: "🇮🇶", phone: "+964"}, 
        {name: "Ireland", code: "IE", flag: "🇮🇪", phone: "+353"}, 
        {name: "Israel", code: "IL", flag: "🇮🇱", phone: "+972"}, 
        {name: "Italy", code: "IT", flag: "🇮🇹", phone: "+39"}, 
        {name: "Jamaica", code: "JM", flag: "🇯🇲", phone: "+1-876"}, 
        {name: "Japan", code: "JP", flag: "🇯🇵", phone: "+81"}, 
        {name: "Jordan", code: "JO", flag: "🇯🇴", phone: "+962"}, 
        {name: "Kazakhstan", code: "KZ", flag: "🇰🇿", phone: "+7"}, 
        {name: "Kenya", code: "KE", flag: "🇰🇪", phone: "+254"}, 
        {name: "Kiribati", code: "KI", flag: "🇰🇮", phone: "+686"}, 
        {name: "Kuwait", code: "KW", flag: "🇰🇼", phone: "+965"}, 
        {name: "Kyrgyzstan", code: "KG", flag: "🇰🇬", phone: "+996"}, 
        {name: "Laos", code: "LA", flag: "🇱🇦", phone: "+856"}, 
        {name: "Latvia", code: "LV", flag: "🇱🇻", phone: "+371"}, 
        {name: "Lebanon", code: "LB", flag: "🇱🇧", phone: "+961"}, 
        {name: "Lesotho", code: "LS", flag: "🇱🇸", phone: "+266"}, 
        {name: "Liberia", code: "LR", flag: "🇱🇷", phone: "+231"}, 
        {name: "Libya", code: "LY", flag: "🇱🇾", phone: "+218"}, 
        {name: "Liechtenstein", code: "LI", flag: "🇱🇮", phone: "+423"}, 
        {name: "Lithuania", code: "LT", flag: "🇱🇹", phone: "+370"}, 
        {name: "Luxembourg", code: "LU", flag: "🇱🇺", phone: "+352"}, 
        {name: "Madagascar", code: "MG", flag: "🇲🇬", phone: "+261"}, 
        {name: "Malawi", code: "MW", flag: "🇲🇼", phone: "+265"}, 
        {name: "Maldives", code: "MV", flag: "🇲🇻", phone: "+960"}, 
        {name: "Mali", code: "ML", flag: "🇲🇱", phone: "+223"}, 
        {name: "Malta", code: "MT", flag: "🇲🇹", phone: "+356"}, 
        {name: "Marshall Islands", code: "MH", flag: "🇲🇭", phone: "+692"}, 
        {name: "Mauritania", code: "MR", flag: "🇲🇷", phone: "+222"}, 
        {name: "Mauritius", code: "MU", flag: "🇲🇺", phone: "+230"}, 
        {name: "Mexico", code: "MX", flag: "🇲🇽", phone: "+52"}, 
        {name: "Micronesia", code: "FM", flag: "🇫🇲", phone: "+691"}, 
        {name: "Moldova", code: "MD", flag: "🇲🇩", phone: "+373"}, 
        {name: "Monaco", code: "MC", flag: "🇲🇨", phone: "+377"}, 
        {name: "Mongolia", code: "MN", flag: "🇲🇳", phone: "+976"}, 
        {name: "Montenegro", code: "ME", flag: "🇲🇪", phone: "+382"}, 
        {name: "Morocco", code: "MA", flag: "🇲🇦", phone: "+212"}, 
        {name: "Mozambique", code: "MZ", flag: "🇲🇿", phone: "+258"}, 
        {name: "Myanmar", code: "MM", flag: "🇲🇲", phone: "+95"}, 
        {name: "Namibia", code: "NA", flag: "🇳🇦", phone: "+264"}, 
        {name: "Nauru", code: "NR", flag: "🇳🇷", phone: "+674"}, 
        {name: "Nepal", code: "NP", flag: "🇳🇵", phone: "+977"}, 
        {name: "Netherlands", code: "NL", flag: "🇳🇱", phone: "+31"}, 
        {name: "New Zealand", code: "NZ", flag: "🇳🇿", phone: "+64"}, 
        {name: "Nicaragua", code: "NI", flag: "🇳🇮", phone: "+505"}, 
        {name: "Niger", code: "NE", flag: "🇳🇪", phone: "+227"}, 
        {name: "Nigeria", code: "NG", flag: "🇳🇬", phone: "+234"}, 
        {name: "North Korea", code: "KP", flag: "🇰🇵", phone: "+850"}, 
        {name: "North Macedonia", code: "MK", flag: "🇲🇰", phone: "+389"}, 
        {name: "Norway", code: "NO", flag: "🇳🇴", phone: "+47"}, 
        {name: "Oman", code: "OM", flag: "🇴🇲", phone: "+968"}, 
        {name: "Pakistan", code: "PK", flag: "🇵🇰", phone: "+92"}, 
        {name: "Palau", code: "PW", flag: "🇵🇼", phone: "+680"}, 
        {name: "Palestine", code: "PS", flag: "🇵🇸", phone: "+970"}, 
        {name: "Panama", code: "PA", flag: "🇵🇦", phone: "+507"}, 
        {name: "Papua New Guinea", code: "PG", flag: "🇵🇬", phone: "+675"}, 
        {name: "Paraguay", code: "PY", flag: "🇵🇾", phone: "+595"}, 
        {name: "Peru", code: "PE", flag: "🇵🇪", phone: "+51"}, 
        {name: "Philippines", code: "PH", flag: "🇵🇭", phone: "+63"}, 
        {name: "Poland", code: "PL", flag: "🇵🇱", phone: "+48"}, 
        {name: "Portugal", code: "PT", flag: "🇵🇹", phone: "+351"}, 
        {name: "Qatar", code: "QA", flag: "🇶🇦", phone: "+974"}, 
        {name: "Romania", code: "RO", flag: "🇷🇴", phone: "+40"}, 
        {name: "Russia", code: "RU", flag: "🇷🇺", phone: "+7"}, 
        {name: "Rwanda", code: "RW", flag: "🇷🇼", phone: "+250"}, 
        {name: "Saint Kitts and Nevis", code: "KN", flag: "🇰🇳", phone: "+1-869"}, 
        {name: "Saint Lucia", code: "LC", flag: "🇱🇨", phone: "+1-758"}, 
        {name: "Saint Vincent and the Grenadines", code: "VC", flag: "🇻🇨", phone: "+1-784"}, 
        {name: "Samoa", code: "WS", flag: "🇼🇸", phone: "+685"}, 
        {name: "San Marino", code: "SM", flag: "🇸🇲", phone: "+378"}, 
        {name: "Sao Tome and Principe", code: "ST", flag: "🇸🇹", phone: "+239"}, 
        {name: "Saudi Arabia", code: "SA", flag: "🇸🇦", phone: "+966"}, 
        {name: "Senegal", code: "SN", flag: "🇸🇳", phone: "+221"}, 
        {name: "Serbia", code: "RS", flag: "🇷🇸", phone: "+381"}, 
        {name: "Seychelles", code: "SC", flag: "🇸🇨", phone: "+248"}, 
        {name: "Sierra Leone", code: "SL", flag: "🇸🇱", phone: "+232"}, 
        {name: "Slovakia", code: "SK", flag: "🇸🇰", phone: "+421"}, 
        {name: "Slovenia", code: "SI", flag: "🇸🇮", phone: "+386"}, 
        {name: "Solomon Islands", code: "SB", flag: "🇸🇧", phone: "+677"}, 
        {name: "Somalia", code: "SO", flag: "🇸🇴", phone: "+252"}, 
        {name: "South Africa", code: "ZA", flag: "🇿🇦", phone: "+27"}, 
        {name: "South Korea", code: "KR", flag: "🇰🇷", phone: "+82"}, 
        {name: "South Sudan", code: "SS", flag: "🇸🇸", phone: "+211"}, 
        {name: "Spain", code: "ES", flag: "🇪🇸", phone: "+34"}, 
        {name: "Sri Lanka", code: "LK", flag: "🇱🇰", phone: "+94"}, 
        {name: "Sudan", code: "SD", flag: "🇸🇩", phone: "+249"}, 
        {name: "Suriname", code: "SR", flag: "🇸🇷", phone: "+597"}, 
        {name: "Sweden", code: "SE", flag: "🇸🇪", phone: "+46"}, 
        {name: "Switzerland", code: "CH", flag: "🇨🇭", phone: "+41"}, 
        {name: "Syria", code: "SY", flag: "🇸🇾", phone: "+963"}, 
        {name: "Taiwan", code: "TW", flag: "🇹🇼", phone: "+886"}, 
        {name: "Tajikistan", code: "TJ", flag: "🇹🇯", phone: "+992"}, 
        {name: "Tanzania", code: "TZ", flag: "🇹🇿", phone: "+255"}, 
        {name: "Timor-Leste", code: "TL", flag: "🇹🇱", phone: "+670"}, 
        {name: "Togo", code: "TG", flag: "🇹🇬", phone: "+228"}, 
        {name: "Tonga", code: "TO", flag: "🇹🇴", phone: "+676"}, 
        {name: "Trinidad and Tobago", code: "TT", flag: "🇹🇹", phone: "+1-868"}, 
        {name: "Tunisia", code: "TN", flag: "🇹🇳", phone: "+216"}, 
        {name: "Turkey", code: "TR", flag: "🇹🇷", phone: "+90"}, 
        {name: "Turkmenistan", code: "TM", flag: "🇹🇲", phone: "+993"}, 
        {name: "Tuvalu", code: "TV", flag: "🇹🇻", phone: "+688"}, 
        {name: "Uganda", code: "UG", flag: "🇺🇬", phone: "+256"}, 
        {name: "Ukraine", code: "UA", flag: "🇺🇦", phone: "+380"}, 
        {name: "United Arab Emirates", code: "AE", flag: "🇦🇪", phone: "+971"}, 
        {name: "Uruguay", code: "UY", flag: "🇺🇾", phone: "+598"}, 
        {name: "Uzbekistan", code: "UZ", flag: "🇺🇿", phone: "+998"}, 
        {name: "Vanuatu", code: "VU", flag: "🇻🇺", phone: "+678"}, 
        {name: "Vatican City", code: "VA", flag: "🇻🇦", phone: "+39"}, 
        {name: "Venezuela", code: "VE", flag: "🇻🇪", phone: "+58"}, 
        {name: "Yemen", code: "YE", flag: "🇾🇪", phone: "+967"}, 
        {name: "Zambia", code: "ZM", flag: "🇿🇲", phone: "+260"}, 
        {name: "Zimbabwe", code: "ZW", flag: "🇿🇼", phone: "+263"}
    ];

    const negaraSelect = document.getElementById('negara');
    const phoneCountrySelect = document.getElementById('phone_country_code');
    
    // Populate negara dengan bendera (menggunakan emoji dan kode negara)
    if (negaraSelect) {
        countryList.forEach(function(item) {
            const opt = document.createElement('option');
            opt.value = item.name;
            // Tambahkan kode negara di samping nama untuk fallback
            opt.text = '[' + item.code + '] ' + item.name;
            opt.setAttribute('data-phone', item.phone);
            opt.setAttribute('data-code', item.code.toLowerCase());
            negaraSelect.appendChild(opt);
        });
    }
    
    // Populate phone country codes dengan kode negara
    if (phoneCountrySelect) {
        phoneCountrySelect.innerHTML = '';
        countryList.forEach(function(item) {
            const opt = document.createElement('option');
            opt.value = item.phone;
            // Tambahkan kode negara
            opt.text = '[' + item.code + '] ' + item.phone;
            opt.setAttribute('data-country', item.name);
            opt.setAttribute('data-code', item.code.toLowerCase());
            phoneCountrySelect.appendChild(opt);
        });
        // Set default to Indonesia
        phoneCountrySelect.value = '+62';
    }
    
    // Auto-update phone code ketika negara berubah
    document.getElementById('negara').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const phoneCode = selectedOption.getAttribute('data-phone');
        if (phoneCode && phoneCountrySelect) {
            phoneCountrySelect.value = phoneCode;
        }
        refreshForm();
    });
    
    // Combine phone code dengan nomor saat submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const phoneCode = document.getElementById('phone_country_code').value;
        const phoneNumber = document.getElementById('nomor_telepon').value;
        document.getElementById('full_phone').value = phoneCode + phoneNumber;
    });
    
    // Load provinsi dari API Wilayah Indonesia
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(response => response.json())
        .then(provinces => {
            const provinsiSelect = document.getElementById('provinsi');
            provinces.forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov.id;
                opt.textContent = prov.name;
                opt.setAttribute('data-name', prov.name);
                provinsiSelect.appendChild(opt);
            });
        })
        .catch(error => console.error('Error loading provinces:', error));
    
    // Load kota/kabupaten ketika provinsi dipilih
    document.getElementById('provinsi').addEventListener('change', function() {
        const provId = this.value;
        const provName = this.options[this.selectedIndex].textContent;
        const kotaSelect = document.getElementById('kota_kabupaten');
        const provinsiNameInput = document.getElementById('provinsi_name');
        
        // Simpan nama provinsi ke hidden field untuk form submission
        if (provinsiNameInput) {
            provinsiNameInput.value = provName || '';
        }
        
        if (!provId) {
            kotaSelect.disabled = true;
            kotaSelect.innerHTML = '<option value="">Pilih Provinsi terlebih dahulu</option>';
            return;
        }
        
        kotaSelect.disabled = true;
        kotaSelect.innerHTML = '<option value="">Memuat kota/kabupaten...</option>';
        
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
            .then(response => response.json())
            .then(regencies => {
                kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                regencies.forEach(reg => {
                    const opt = document.createElement('option');
                    opt.value = reg.name;
                    opt.textContent = reg.name;
                    kotaSelect.appendChild(opt);
                });
                kotaSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading regencies:', error);
                kotaSelect.innerHTML = '<option value="">Error memuat data</option>';
            });
    });
});
</script>
@endsection