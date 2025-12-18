@extends('layouts.app')

@section('title', 'Submit Ticket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card mt-5 shadow-lg border-0 ticket-form-card" style="border-radius: 1.5rem; overflow: hidden;">
            <!-- Header dengan gradient matching tema -->
            <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">
                    <i class="fas fa-ticket-alt me-2"></i>Data Pemesanan Tiket
                </h3>
            </div>
            
            <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-bold fs-6">
                            Nama Lengkap
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-person-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <input type="text" class="form-control border-2 shadow-sm" id="nama" name="nama" 
                                placeholder="Masukkan nama lengkap" required 
                                style="border-color: var(--mg-yellow);">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold fs-6">
                            Email
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-envelope-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <input type="email" class="form-control border-2 shadow-sm" id="email" name="email" 
                                placeholder="contoh@email.com" required 
                                style="border-color: var(--mg-yellow);">
                        </div>
                    </div>

                    <!-- Negara -->
                    <div class="mb-4">
                        <label for="negara" class="form-label fw-bold fs-6">
                            Negara Asal
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-globe-americas" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <select class="form-select border-2 shadow-sm" id="negara" name="negara" required 
                                style="border-color: var(--mg-yellow);">
                                <option value="">Pilih Negara</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label for="nomor_telepon" class="form-label fw-bold fs-6">
                            Nomor Telepon
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-phone-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <input type="text" class="form-control border-2 shadow-sm" id="nomor_telepon" name="nomor_telepon" 
                                placeholder="08123456789" required 
                                style="border-color: var(--mg-yellow);">
                        </div>
                    </div>

                    <!-- Jenis Pemesanan -->
                    <div class="mb-4">
                        <label for="jenis_pemesanan" class="form-label fw-bold fs-6">
                            Jenis Pemesanan
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-ticket-detailed-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <select class="form-select border-2 shadow-sm" id="jenis_pemesanan" name="jenis_pemesanan" required 
                                style="border-color: var(--mg-yellow);">
                                <option value="">Pilih Jenis Pemesanan</option>
                                <option value="individu">Individu</option>
                                <option value="rombongan">Rombongan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Rombongan -->
                    <div class="mb-4" id="nama_rombongan_group" style="display:none;">
                        <label for="nama_rombongan" class="form-label fw-bold fs-6">
                            Nama Rombongan / Instansi
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-buildings-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <input type="text" class="form-control border-2 shadow-sm" id="nama_rombongan" name="nama_rombongan" 
                                placeholder="Nama sekolah / perusahaan" 
                                style="border-color: var(--mg-yellow);">
                        </div>
                    </div>

                    <!-- Jenis Pengunjung Dinamis -->
                    <div class="mb-4" id="jenis_pengunjung_group" style="display:none;">
                        <label class="form-label fw-bold fs-6">
                            Jenis Pengunjung
                        </label>

                        <!-- Individu -->
                        <div id="pengunjung_individu" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 5px solid var(--mg-yellow);">
                            <div class="mb-3">
                                <label class="form-label fw-bold fs-6">
                                    Pilih Kategori Individu
                                </label>
                                <select class="form-select shadow-sm border-2" id="kategori_individu" name="kategori_individu" 
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>

                            <!-- Asing -->
                            <div id="individu_asing" style="display:none;" class="alert alert-info border-start border-5 border-primary shadow-sm">
                                <strong>Kategori:</strong> Asing, <strong>Jumlah:</strong> 1
                                <input type="hidden" id="jumlah_asing" name="jumlah_asing" value="1">
                            </div>

                            <!-- Umum -->
                            <div id="individu_umum" style="display:none;">
                                <label class="form-label fw-bold fs-6">
                                    Apakah Anda Pelajar?
                                </label>
                                <select class="form-select shadow-sm border-2" id="is_pelajar" name="is_pelajar" 
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih</option>
                                    <option value="pelajar">Ya, Pelajar</option>
                                    <option value="bukan">Tidak, Umum</option>
                                </select>
                            </div>

                            <div id="individu_umum_bukan" style="display:none;" class="alert alert-success border-start border-5 border-success shadow-sm mt-3">
                                <strong>Kategori:</strong> Umum (Bukan Pelajar), <strong>Jumlah:</strong> 1
                                <input type="hidden" id="jumlah_umum" name="jumlah_umum" value="1">
                            </div>

                            <div id="individu_umum_pelajar" style="display:none;" class="mt-3">
                                <label class="form-label fw-bold fs-6">
                                    Pilih Jenjang Pendidikan
                                </label>
                                <select class="form-select shadow-sm border-2" id="jenjang_pelajar" name="jenjang_pelajar" 
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="sub_tk">TK</option>
                                    <option value="sub_sd">SD</option>
                                    <option value="sub_smp">SMP</option>
                                    <option value="sub_sma">SMA</option>
                                    <option value="sub_kuliah">Kuliah</option>
                                </select>
                            </div>

                            <div id="individu_umum_pelajar_jumlah" style="display:none;" class="alert border-start border-5 shadow-sm mt-3" style="background: #FFF3CD; border-color: var(--mg-yellow) !important;">
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
                        <div id="pengunjung_rombongan" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 5px solid #28a745;">
                            <div class="mb-4">
                                <label class="form-label fw-bold fs-6">
                                    Jumlah Pelajar
                                </label>
                                <div class="row g-3">
                                    @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                    <div class="col-6 col-md-4">
                                        <label class="fw-bold mb-2">
                                            {{ $v }}
                                        </label>
                                        <div class="input-group shadow-sm">
                                            <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                                −
                                            </button>
                                            <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                            <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold fs-6">
                                    Jumlah Umum
                                </label>
                                <div class="input-group shadow-sm" style="max-width:250px;">
                                    <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_jumlah_umum" name="jumlah_umum" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                    <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold fs-6">
                                    Jumlah Asing
                                </label>
                                <div class="input-group shadow-sm" style="max-width:250px;">
                                    <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_jumlah_asing" name="jumlah_asing" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                    <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div class="mb-4">
                        <label class="form-label fw-bold fs-6">
                            Tanggal Kunjungan
                        </label>
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                <i class="bi bi-calendar3" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                            </span>
                            <input type="date" id="tanggal_kunjungan_raw" class="form-control border-2" 
                                style="border-color: var(--mg-yellow);" min="{{ date('Y-m-d') }}" required>
                            <input type="text" id="tanggal_kunjungan_display" class="form-control border-2" 
                                placeholder="Pilih tanggal..." readonly 
                                style="background:white; border-color: var(--mg-yellow);">
                            <input type="hidden" id="tanggal_kunjungan" name="tanggal_kunjungan" required>
                        </div>
                    </div>

                    <!-- Lokasi Indonesia -->
                    <div id="lokasi_indonesia" style="display:none;">
                        <div class="mb-4">
                            <label for="kota_kabupaten" class="form-label fw-bold fs-6">
                                Kota/Kabupaten
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-buildings" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <select class="form-select border-2 shadow-sm" id="kota_kabupaten" name="kota_kabupaten" 
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Semarang">Semarang</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Medan">Medan</option>
                                    <option value="Makassar">Makassar</option>
                                    <option value="Denpasar">Denpasar</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="provinsi" class="form-label fw-bold fs-6">
                                Provinsi
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-map-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <select class="form-select border-2 shadow-sm" id="provinsi" name="provinsi" 
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Provinsi</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="DKI Jakarta">DKI Jakarta</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="DI Yogyakarta">DI Yogyakarta</option>
                                    <option value="Sumatera Utara">Sumatera Utara</option>
                                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ticket-yellow btn-lg w-100 mt-4 shadow-lg" style="border-radius: 50px; padding: 1rem 2rem; font-weight: 800; letter-spacing: 1px;">
                        SUBMIT TIKET
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root { 
        --mg-yellow: #FFD400; 
        --mg-black: #0b0b0b; 
    }
    
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
    
    .btn-ticket-yellow {
        background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%) !important;
        color: var(--mg-black) !important;
        border: 3px solid #FFD54F !important;
        font-weight: 800 !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 8px 25px rgba(255,193,7,0.4);
    }
    
    .btn-ticket-yellow:hover {
        background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-yellow) !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(255,193,7,0.6);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--mg-yellow) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 212, 0, 0.25) !important;
        outline: none !important;
    }
    .form-control, .form-select {
        border-bottom: none !important;
        box-shadow: none !important;
    }
    
    .input-group {
        border-bottom: none !important;
    }
    
    .input-group-text {
        background: white;
        border-color: var(--mg-yellow);
        border-bottom: none !important;
    }
    
    .btn-outline-warning {
        border-color: var(--mg-yellow) !important;
        color: var(--mg-yellow) !important;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .btn-outline-warning:hover {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        transform: scale(1.1);
    }
    
    label.form-label {
        color: var(--mg-black);
        margin-bottom: 0.5rem;
    }
    
    .alert {
        border-radius: 0.75rem;
        font-weight: 600;
    }
    
    /* Hover effect untuk tombol +/- */
    .input-group button:hover {
        background-color: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        transform: scale(1.1);
        transition: all 0.2s ease-in-out;
        box-shadow: 0 0 10px rgba(255, 212, 0, 0.5);
    }
    
    .input-group button {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    
    .input-group button:active {
        transform: scale(0.95);
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .input-group-lg > .form-control {
            font-size: 1rem;
        }
        
        .btn-ticket-yellow {
            font-size: 0.95rem;
            padding: 0.875rem 1.5rem;
        }
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

document.addEventListener('DOMContentLoaded', function() {
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

    // Populate country list
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
    if (negaraSelect) {
        countryList.forEach(function(item) {
            const opt = document.createElement('option');
            opt.value = item.name;
            opt.textContent = item.name;
            negaraSelect.appendChild(opt);
        });
    }
});
</script>
@endsection