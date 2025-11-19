@extends('layouts.app')

@section('title', 'Submit Ticket')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mt-5 shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-header bg-warning text-dark" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h4 class="mb-0 text-center">Data Pemesanan Tiket </h4>
            </div>
            <div class="card-body p-4">
                <form action="/tickets" method="POST">
                    @csrf
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold"><i class="bi bi-person-circle text-warning"></i> Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-person-fill text-warning"></i></span>
                            <input type="text" class="form-control form-control-lg shadow-sm" id="nama" name="nama" placeholder="Masukkan nama lengkap" required style="border: 2px solid #FFD400;">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold"><i class="bi bi-envelope-at text-warning"></i> Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-envelope-fill text-warning"></i></span>
                            <input type="email" class="form-control form-control-lg shadow-sm" id="email" name="email" placeholder="contoh@email.com" required style="border: 2px solid #FFD400;">
                        </div>
                    </div>

                    <!-- Negara -->
                    <div class="mb-3">
                        <label for="negara" class="form-label fw-bold"><i class="bi bi-globe2 text-warning"></i> Negara Asal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-flag-fill text-warning"></i></span>
                            <select class="form-select form-select-lg shadow-sm" id="negara" name="negara" required style="border: 2px solid #FFD400;">
                                <option value="">Pilih Negara</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <label for="nom n_telepon" class="form-label fw-bold"><i class="bi bi-telephone-fill text-warning"></i> Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-phone-fill text-warning"></i></span>
                            <input type="text" class="form-control form-control-lg shadow-sm" id="nomor_telepon" name="nomor_telepon" placeholder="08123456789" required style="border: 2px solid #FFD400;">
                        </div>
                    </div>

                    <!-- Jenis Pemesanan -->
                    <div class="mb-3">
                        <label for="jenis_pemesanan" class="form-label fw-bold"><i class="bi bi-people-fill text-warning"></i> Jenis Pemesanan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-person-check-fill text-warning"></i></span>
                            <select class="form-select form-select-lg shadow-sm" id="jenis_pemesanan" name="jenis_pemesanan" required style="border: 2px solid #FFD400;">
                                <option value="">Pilih Jenis Pemesanan</option>
                                <option value="individu">Individu</option>
                                <option value="rombongan">Rombongan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Rombongan -->
                    <div class="mb-3" id="nama_rombongan_group" style="display:none;">
                        <label for="nama_rombongan" class="form-label fw-bold"><i class="bi bi-building text-warning"></i> Nama Rombongan / Instansi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning"><i class="bi bi-buildings-fill text-warning"></i></span>
                            <input type="text" class="form-control form-control-lg shadow-sm" id="nama_rombongan" name="nama_rombongan" placeholder="Nama sekolah / perusahaan" style="border: 2px solid #FFD400;">
                        </div>
                    </div>

                    <!-- Jenis Pengunjung Dinamis -->
                    <div class="mb-3" id="jenis_pengunjung_group" style="display:none;">
                        <label class="form-label fw-bold"><i class="bi bi-person-lines-fill text-warning"></i> Jenis Pengunjung</label>

                        <!-- Individu -->
                        <div id="pengunjung_individu" style="display:none;" class="border-start border-warning border-4 ps-3">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge"></i> Pilih Kategori Individu</label>
                                <select class="form-select shadow-sm" id="kategori_individu" name="kategori_individu">
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>

                            <!-- Asing -->
                            <div id="individu_asing" style="display:none;" class="alert alert-info border-start border-primary border-5">
                                <i class="bi bi-globe"></i> Kategori: Asing, Jumlah: 1
                                <input type="hidden" id="jumlah_asing" name="jumlah_asing" value="1">
                            </div>

                            <!-- Umum -->
                            <div id="individu_umum" style="display:none;">
                                <label class="form-label"><i class="bi bi-mortarboard-fill"></i> Apakah Anda Pelajar?</label>
                                <select class="form-select shadow-sm" id="is_pelajar" name="is_pelajar">
                                    <option value="">Pilih</option>
                                    <option value="pelajar">Ya, Pelajar</option>
                                    <option value="bukan">Tidak, Umum</option>
                                </select>
                            </div>

                            <div id="individu_umum_bukan" style="display:none;" class="alert alert-success mt-3">
                                <i class="bi bi-person-check"></i> Kategori: Umum (Bukan Pelajar), Jumlah: 1
                                <input type="hidden" id="jumlah_umum" name="jumlah_umum" value="1">
                            </div>

                            <div id="individu_umum_pelajar" style="display:none;" class="mt-3">
                                <label class="form-label"><i class="bi bi-book-fill"></i> Pilih Jenjang Pendidikan</label>
                                <select class="form-select shadow-sm" id="jenjang_pelajar" name="jenjang_pelajar">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="sub_tk">TK</option>
                                    <option value="sub_sd">SD</option>
                                    <option value="sub_smp">SMP</option>
                                    <option value="sub_sma">SMA</option>
                                    <option value="sub_kuliah">Kuliah</option>
                                </select>
                            </div>

                            <div id="individu_umum_pelajar_jumlah" style="display:none;" class="alert alert-warning mt-3">
                                <i class="bi bi-award-fill"></i> <span id="info_pelajar">Kategori: Pelajar, Jumlah: 1</span>
                                <input type="hidden" id="jumlah_pelajar" name="jumlah_pelajar" value="1">
                                <input type="hidden" id="sub_tk" name="sub_tk" value="0">
                                <input type="hidden" id="sub_sd" name="sub_sd" value="0">
                                <input type="hidden" id="sub_smp" name="sub_smp" value="0">
                                <input type="hidden" id="sub_sma" name="sub_sma" value="0">
                                <input type="hidden" id="sub_kuliah" name="sub_kuliah" value="0">
                            </div>
                        </div>

                        <!-- Rombongan -->
                        <div id="pengunjung_rombongan" style="display:none;" class="border-start border-success border-4 ps-3">
                            <!-- Tetap sama seperti sebelumnya, tapi tambah ikon kecil -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-people"></i> Jumlah Pelajar</label>
                                <div class="row">
                                    @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                    <div class="col-6 col-md-4 mb-2">
                                        <label><i class="bi bi-mortarboard"></i> {{ $v }}</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('sub_{{ $k }}',-1)">-</button>
                                            <input type="number" class="form-control form-control-sm text-center" id="sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" readonly>
                                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('sub_{{ $k }}',1)">+</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person"></i> Jumlah Umum</label>
                                <div class="input-group" style="max-width:200px;">
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('jumlah_umum',-1)">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" id="jumlah_umum" name="jumlah_umum" value="0" min="0" readonly>
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('jumlah_umum',1)">+</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-globe-americas"></i> Jumlah Asing</label>
                                <div class="input-group" style="max-width:200px;">
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('jumlah_asing',-1)">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" id="jumlah_asing" name="jumlah_asing" value="0" min="0" readonly>
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="changeCount('jumlah_asing',1)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Kunjungan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-warning">
                                Calendar
                            </span>
                            <input type="date" 
                                id="tanggal_kunjungan_raw" 
                                class="form-control form-control-lg" 
                                style="border: 2px solid #FFD400;" 
                                min="{{ date('Y-m-d') }}" 
                                required>
                            <input type="text" 
                                id="tanggal_kunjungan_display" 
                                class="form-control form-control-lg" 
                                placeholder="Pilih tanggal..." 
                                readonly 
                                style="background:white; border: 2px solid #FFD400;">
                            <!-- Yang dikirim ke server -->
                            <input type="hidden" 
                                id="tanggal_kunjungan" 
                                name="tanggal_kunjungan" 
                                required>
                        </div>
                    </div>

                    <!-- Lokasi Indonesia -->
                    <div id="lokasi_indonesia" style="display:none;">
                        <div class="mb-3">
                            <label for="kota_kabupaten" class="form-label fw-bold"><i class="bi bi-building"></i> Kota/Kabupaten</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-warning"><i class="bi bi-buildings text-warning"></i></span>
                                <select class="form-select form-select-lg shadow-sm" id="kota_kabupaten" name="kota_kabupaten" style="border: 2px solid #FFD400;">
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
                        <div class="mb-3">
                            <label for="provinsi" class="form-label fw-bold"><i class="bi bi-geo-alt-fill"></i> Provinsi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-warning"><i class="bi bi-map-fill text-warning"></i></span>
                                <select class="form-select form-select-lg shadow-sm" id="provinsi" name="provinsi" style="border: 2px solid #FFD400;">
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

                    <button type="submit" class="btn btn-ticket-yellow btn-lg w-100 mt-4 shadow">
                        <i class="bi bi-send-fill me-2"></i> Submit Tiket Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    :root { --mg-yellow: #FFD400; --mg-black: #0b0b0b; }
    .btn-ticket-yellow {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        border: 2px solid var(--mg-yellow) !important;
        font-weight: 700;
    }
    .btn-ticket-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endsection

<script>
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

    // Kosongkan dulu
    select.innerHTML = '<option value="">Pilih Kategori</option>';

    if (jenis !== 'individu') return;

    if (negara === 'Indonesia') {
        select.innerHTML += '<option value="umum">Umum</option>';
    } else if (negara) { // negara lain dan bukan kosong
        select.innerHTML += '<option value="asing">Asing</option>';
    }
}

// Logika utama saat jenis pemesanan / negara berubah
function refreshForm() {
    const jenis = document.getElementById('jenis_pemesanan').value;
    const negara = document.getElementById('negara').value;

    // Nama rombongan
    document.getElementById('nama_rombongan_group').style.display = (jenis === 'rombongan') ? '' : 'none';

    // Jenis pengunjung group
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
        updateKategoriIndividuOptions(); // penting!
    } else { // rombongan
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = '';
    }

    // Lokasi Indonesia
    document.getElementById('lokasi_indonesia').style.display = (negara === 'Indonesia') ? '' : 'none';
}

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

    // reset semua sub
    ['sub_tk','sub_sd','sub_smp','sub_sma','sub_kuliah'].forEach(id => {
        document.getElementById(id).value = 0;
    });

    if (val) {
        document.getElementById(val).value = 1;
        const text = this.options[this.selectedIndex].text;
        document.getElementById('info_pelajar').textContent = `Kategori: Pelajar ${text}, Jumlah: 1`;
    }
});

// Format tanggal DD/MM/YYYY
document.getElementById('tanggal_kunjungan_raw').addEventListener('change', function() {
    const raw = this.value; // format: 2025-12-25
    if (!raw) return;

    const date = new Date(raw);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const display = date.toLocaleDateString('id-ID', options); // 25 Desember 2025

    document.getElementById('tanggal_kunjungan_display').value = display;
    document.getElementById('tanggal_kunjungan').value = raw; // yang dikirim: 2025-12-25
});

// Daftar negara ISO dan kode alpha-2
const countryList = [
    {name: "Indonesia", code: "ID"}, {name: "Malaysia", code: "MY"}, {name: "Singapore", code: "SG"}, {name: "Thailand", code: "TH"}, {name: "Vietnam", code: "VN"}, {name: "Australia", code: "AU"}, {name: "United States", code: "US"}, {name: "United Kingdom", code: "GB"}, {name: "Afghanistan", code: "AF"}, {name: "Albania", code: "AL"}, {name: "Algeria", code: "DZ"}, {name: "Andorra", code: "AD"}, {name: "Angola", code: "AO"}, {name: "Antigua and Barbuda", code: "AG"}, {name: "Argentina", code: "AR"}, {name: "Armenia", code: "AM"}, {name: "Austria", code: "AT"}, {name: "Azerbaijan", code: "AZ"}, {name: "Bahamas", code: "BS"}, {name: "Bahrain", code: "BH"}, {name: "Bangladesh", code: "BD"}, {name: "Barbados", code: "BB"}, {name: "Belarus", code: "BY"}, {name: "Belgium", code: "BE"}, {name: "Belize", code: "BZ"}, {name: "Benin", code: "BJ"}, {name: "Bhutan", code: "BT"}, {name: "Bolivia", code: "BO"}, {name: "Bosnia and Herzegovina", code: "BA"}, {name: "Botswana", code: "BW"}, {name: "Brazil", code: "BR"}, {name: "Brunei", code: "BN"}, {name: "Bulgaria", code: "BG"}, {name: "Burkina Faso", code: "BF"}, {name: "Burundi", code: "BI"}, {name: "Cabo Verde", code: "CV"}, {name: "Cambodia", code: "KH"}, {name: "Cameroon", code: "CM"}, {name: "Canada", code: "CA"}, {name: "Central African Republic", code: "CF"}, {name: "Chad", code: "TD"}, {name: "Chile", code: "CL"}, {name: "China", code: "CN"}, {name: "Colombia", code: "CO"}, {name: "Comoros", code: "KM"}, {name: "Congo", code: "CG"}, {name: "Costa Rica", code: "CR"}, {name: "Croatia", code: "HR"}, {name: "Cuba", code: "CU"}, {name: "Cyprus", code: "CY"}, {name: "Czechia", code: "CZ"}, {name: "Denmark", code: "DK"}, {name: "Djibouti", code: "DJ"}, {name: "Dominica", code: "DM"}, {name: "Dominican Republic", code: "DO"}, {name: "Ecuador", code: "EC"}, {name: "Egypt", code: "EG"}, {name: "El Salvador", code: "SV"}, {name: "Equatorial Guinea", code: "GQ"}, {name: "Eritrea", code: "ER"}, {name: "Estonia", code: "EE"}, {name: "Eswatini", code: "SZ"}, {name: "Ethiopia", code: "ET"}, {name: "Fiji", code: "FJ"}, {name: "Finland", code: "FI"}, {name: "France", code: "FR"}, {name: "Gabon", code: "GA"}, {name: "Gambia", code: "GM"}, {name: "Georgia", code: "GE"}, {name: "Germany", code: "DE"}, {name: "Ghana", code: "GH"}, {name: "Greece", code: "GR"}, {name: "Grenada", code: "GD"}, {name: "Guatemala", code: "GT"}, {name: "Guinea", code: "GN"}, {name: "Guinea-Bissau", code: "GW"}, {name: "Guyana", code: "GY"}, {name: "Haiti", code: "HT"}, {name: "Honduras", code: "HN"}, {name: "Hungary", code: "HU"}, {name: "Iceland", code: "IS"}, {name: "India", code: "IN"}, {name: "Iran", code: "IR"}, {name: "Iraq", code: "IQ"}, {name: "Ireland", code: "IE"}, {name: "Israel", code: "IL"}, {name: "Italy", code: "IT"}, {name: "Jamaica", code: "JM"}, {name: "Japan", code: "JP"}, {name: "Jordan", code: "JO"}, {name: "Kazakhstan", code: "KZ"}, {name: "Kenya", code: "KE"}, {name: "Kiribati", code: "KI"}, {name: "Kuwait", code: "KW"}, {name: "Kyrgyzstan", code: "KG"}, {name: "Laos", code: "LA"}, {name: "Latvia", code: "LV"}, {name: "Lebanon", code: "LB"}, {name: "Lesotho", code: "LS"}, {name: "Liberia", code: "LR"}, {name: "Libya", code: "LY"}, {name: "Liechtenstein", code: "LI"}, {name: "Lithuania", code: "LT"}, {name: "Luxembourg", code: "LU"}, {name: "Madagascar", code: "MG"}, {name: "Malawi", code: "MW"}, {name: "Maldives", code: "MV"}, {name: "Mali", code: "ML"}, {name: "Malta", code: "MT"}, {name: "Marshall Islands", code: "MH"}, {name: "Mauritania", code: "MR"}, {name: "Mauritius", code: "MU"}, {name: "Mexico", code: "MX"}, {name: "Micronesia", code: "FM"}, {name: "Moldova", code: "MD"}, {name: "Monaco", code: "MC"}, {name: "Mongolia", code: "MN"}, {name: "Montenegro", code: "ME"}, {name: "Morocco", code: "MA"}, {name: "Mozambique", code: "MZ"}, {name: "Myanmar", code: "MM"}, {name: "Namibia", code: "NA"}, {name: "Nauru", code: "NR"}, {name: "Nepal", code: "NP"}, {name: "Netherlands", code: "NL"}, {name: "New Zealand", code: "NZ"}, {name: "Nicaragua", code: "NI"}, {name: "Niger", code: "NE"}, {name: "Nigeria", code: "NG"}, {name: "North Korea", code: "KP"}, {name: "North Macedonia", code: "MK"}, {name: "Norway", code: "NO"}, {name: "Oman", code: "OM"}, {name: "Pakistan", code: "PK"}, {name: "Palau", code: "PW"}, {name: "Palestine", code: "PS"}, {name: "Panama", code: "PA"}, {name: "Papua New Guinea", code: "PG"}, {name: "Paraguay", code: "PY"}, {name: "Peru", code: "PE"}, {name: "Philippines", code: "PH"}, {name: "Poland", code: "PL"}, {name: "Portugal", code: "PT"}, {name: "Qatar", code: "QA"}, {name: "Romania", code: "RO"}, {name: "Russia", code: "RU"}, {name: "Rwanda", code: "RW"}, {name: "Saint Kitts and Nevis", code: "KN"}, {name: "Saint Lucia", code: "LC"}, {name: "Saint Vincent and the Grenadines", code: "VC"}, {name: "Samoa", code: "WS"}, {name: "San Marino", code: "SM"}, {name: "Sao Tome and Principe", code: "ST"}, {name: "Saudi Arabia", code: "SA"}, {name: "Senegal", code: "SN"}, {name: "Serbia", code: "RS"}, {name: "Seychelles", code: "SC"}, {name: "Sierra Leone", code: "SL"}, {name: "Slovakia", code: "SK"}, {name: "Slovenia", code: "SI"}, {name: "Solomon Islands", code: "SB"}, {name: "Somalia", code: "SO"}, {name: "South Africa", code: "ZA"}, {name: "South Korea", code: "KR"}, {name: "South Sudan", code: "SS"}, {name: "Spain", code: "ES"}, {name: "Sri Lanka", code: "LK"}, {name: "Sudan", code: "SD"}, {name: "Suriname", code: "SR"}, {name: "Sweden", code: "SE"}, {name: "Switzerland", code: "CH"}, {name: "Syria", code: "SY"}, {name: "Taiwan", code: "TW"}, {name: "Tajikistan", code: "TJ"}, {name: "Tanzania", code: "TZ"}, {name: "Timor-Leste", code: "TL"}, {name: "Togo", code: "TG"}, {name: "Tonga", code: "TO"}, {name: "Trinidad and Tobago", code: "TT"}, {name: "Tunisia", code: "TN"}, {name: "Turkey", code: "TR"}, {name: "Turkmenistan", code: "TM"}, {name: "Tuvalu", code: "TV"}, {name: "Uganda", code: "UG"}, {name: "Ukraine", code: "UA"}, {name: "United Arab Emirates", code: "AE"}, {name: "Uruguay", code: "UY"}, {name: "Uzbekistan", code: "UZ"}, {name: "Vanuatu", code: "VU"}, {name: "Vatican City", code: "VA"}, {name: "Venezuela", code: "VE"}, {name: "Yemen", code: "YE"}, {name: "Zambia", code: "ZM"}, {name: "Zimbabwe", code: "ZW"}
];

const negaraSelect = document.getElementById('negara');
if (negaraSelect) {
    countryList.forEach(function(item) {
        const opt = document.createElement('option');
        opt.value = item.name;
        opt.innerHTML = `<img src='https://flagcdn.com/16x12/${item.code.toLowerCase()}.png' style='margin-right:6px;vertical-align:middle;'> ${item.name}`;
        negaraSelect.appendChild(opt);
    });
}
</script>
@endsection