@extends('layouts.app')

@section('title', 'Book Event - ' . $event->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px; text-transform: uppercase;">
                        <i class="fas fa-calendar-check me-2"></i>Pemesanan Tiket Event
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <!-- Event Info -->
                    <div class="alert alert-info mb-4">
                        <h5 class="fw-bold mb-3">{{ $event->title }}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-calendar me-2" style="color: var(--mg-yellow);"></i>
                                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                                <strong>Waktu:</strong> {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} WIB
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-tag me-2" style="color: var(--mg-yellow);"></i>
                                <strong>Harga:</strong> Rp {{ number_format($event->price, 0, ',', '.') }}/tiket
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-users me-2" style="color: var(--mg-yellow);"></i>
                                <strong>Kapasitas:</strong> {{ $event->capacity }} orang
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('event.booking.store') }}" method="POST" id="eventBookingForm">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-bold fs-6">Nama Lengkap</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-person-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <input type="text" class="form-control border-2 @error('nama') is-invalid @enderror" 
                                    id="nama" name="nama" value="{{ old('nama') }}" 
                                    placeholder="Masukkan nama lengkap" required
                                    style="border-color: var(--mg-yellow);">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold fs-6">Email</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-envelope-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <input type="email" class="form-control border-2 @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    placeholder="contoh@email.com" required
                                    style="border-color: var(--mg-yellow);">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Negara Asal -->
                        <div class="mb-4">
                            <label for="negara" class="form-label fw-bold fs-6">Negara Asal</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-globe-americas" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <select class="form-select border-2 @error('negara') is-invalid @enderror" 
                                    id="negara" name="negara" required
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Negara</option>
                                </select>
                                @error('negara')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-4">
                            <label for="nomor_telepon" class="form-label fw-bold fs-6">Nomor Telepon</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-phone-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <input type="text" class="form-control border-2 @error('nomor_telepon') is-invalid @enderror" 
                                    id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" 
                                    placeholder="08123456789" required
                                    style="border-color: var(--mg-yellow);">
                                @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Pemesanan -->
                        <div class="mb-4">
                            <label for="jenis_pemesanan" class="form-label fw-bold fs-6">Jenis Pemesanan</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-ticket-detailed-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <select class="form-select border-2 @error('jenis_pemesanan') is-invalid @enderror" 
                                    id="jenis_pemesanan" name="jenis_pemesanan" required
                                    style="border-color: var(--mg-yellow);">
                                    <option value="">Pilih Jenis Pemesanan</option>
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
                            <label for="nama_rombongan" class="form-label fw-bold fs-6">Nama Rombongan / Instansi</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                    <i class="bi bi-buildings-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                </span>
                                <input type="text" class="form-control border-2" id="nama_rombongan" name="nama_rombongan" 
                                    placeholder="Nama sekolah / perusahaan" value="{{ old('nama_rombongan') }}"
                                    style="border-color: var(--mg-yellow);">
                            </div>
                        </div>

                        <!-- Jenis Pengunjung Dinamis -->
                        <div class="mb-4" id="jenis_pengunjung_group" style="display:none;">
                            <label class="form-label fw-bold fs-6">Jenis Pengunjung</label>

                            <!-- Individu -->
                            <div id="pengunjung_individu" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 5px solid var(--mg-yellow);">
                                <div class="mb-3">
                                    <label class="form-label fw-bold fs-6">Pilih Kategori Individu</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                            <i class="bi bi-person-badge-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                        </span>
                                        <select class="form-select shadow-sm border-2" id="kategori_individu" name="kategori_individu" 
                                            style="border-color: var(--mg-yellow);">
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
                                    <label class="form-label fw-bold fs-6">Apakah Anda Pelajar?</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                            <i class="bi bi-patch-question-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                        </span>
                                        <select class="form-select shadow-sm border-2" id="is_pelajar" name="is_pelajar" 
                                            style="border-color: var(--mg-yellow);">
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
                                    <label class="form-label fw-bold fs-6">Pilih Jenjang Pendidikan</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-2" style="border-color: var(--mg-yellow);">
                                            <i class="bi bi-mortarboard-fill" style="color: var(--mg-black); font-size: 1.5rem;"></i>
                                        </span>
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
                                    <label class="form-label fw-bold fs-6">Jumlah Pelajar</label>
                                    <div class="row g-3">
                                        @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                        <div class="col-6 col-md-4">
                                            <label class="fw-bold mb-2">{{ $v }}</label>
                                            <div class="input-group shadow-sm">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">−</button>
                                                <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                                <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_sub_{{ $k }}',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">+</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold fs-6">Jumlah Umum</label>
                                    <div class="input-group shadow-sm" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">−</button>
                                        <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_jumlah_umum" name="jumlah_umum" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_umum',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">+</button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold fs-6">Jumlah Asing</label>
                                    <div class="input-group shadow-sm" style="max-width:250px;">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',-1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">−</button>
                                        <input type="number" class="form-control text-center fw-bold border-2" id="rombongan_jumlah_asing" name="jumlah_asing" value="0" min="0" oninput="validateNumberInput(this)" style="border-color: var(--mg-yellow);">
                                        <button type="button" class="btn fw-bold" onclick="changeCount('rombongan_jumlah_asing',1)" style="background-color: var(--mg-black); color: var(--mg-yellow); border: 2px solid var(--mg-yellow); min-width: 45px; font-size: 2rem; line-height: 1;">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg fw-bold shadow-lg" 
                                style="background: var(--mg-yellow); color: var(--mg-black); border: none; border-radius: 0.75rem; padding: 1rem;">
                                <i class="fas fa-arrow-right me-2"></i>Lanjut ke Pembayaran
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
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
}

document.addEventListener('DOMContentLoaded', function() {
    const hargaSatuan = {{ $event->price }};

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
});
</script>
@endsection
