@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i>Permintaan Tiket Khusus (Gratis)</h3>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Tiket Khusus diperuntukkan bagi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Lansia (≥60 Tahun)</li>
                            <li>Penyandang Disabilitas</li>
                            <li>Panti Asuhan</li>
                            <li>Peserta Diklat</li>
                            <li>Tamu Negara</li>
                        </ul>
                        <small class="text-muted">Permintaan akan diverifikasi oleh admin. Tiket akan dikirim via email setelah di-approve.</small>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('special-tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Negara & Provinsi -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="negara" class="form-label fw-semibold">Negara *</label>
                                <select class="form-select @error('negara') is-invalid @enderror" 
                                    id="negara" name="negara" required onchange="toggleProvinsi()">
                                    <option value="">Pilih Negara</option>
                                    <option value="Indonesia" {{ old('negara') == 'Indonesia' ? 'selected' : '' }}>🇮🇩 Indonesia</option>
                                    <option value="Malaysia" {{ old('negara') == 'Malaysia' ? 'selected' : '' }}>🇲🇾 Malaysia</option>
                                    <option value="Singapura" {{ old('negara') == 'Singapura' ? 'selected' : '' }}>🇸🇬 Singapura</option>
                                </select>
                                @error('negara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6" id="provinsi_wrapper" style="display: none;">
                                <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                <select class="form-select" id="provinsi" name="provinsi"></select>
                            </div>
                        </div>

                        <!-- Kategori Khusus -->
                        <div class="mb-4">
                            <label for="kategori_khusus" class="form-label fw-semibold">Kategori Khusus *</label>
                            <select class="form-select @error('kategori_khusus') is-invalid @enderror" 
                                id="kategori_khusus" name="kategori_khusus" required>
                                <option value="">Pilih Kategori</option>
                                <option value="lansia">Lansia (≥60 Tahun)</option>
                                <option value="disabilitas">Penyandang Disabilitas</option>
                                <option value="panti_asuhan">Panti Asuhan</option>
                                <option value="peserta_diklat">Peserta Diklat</option>
                                <option value="tamu_negara">Tamu Negara</option>
                            </select>
                            @error('kategori_khusus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Jumlah Pengunjung -->
                        <div class="mb-4">
                            <label for="jumlah_pengunjung" class="form-label fw-semibold">Jumlah Pengunjung *</label>
                            <input type="number" class="form-control @error('jumlah_pengunjung') is-invalid @enderror" 
                                id="jumlah_pengunjung" name="jumlah_pengunjung" value="{{ old('jumlah_pengunjung', 1) }}" 
                                min="1" max="100" required>
                            @error('jumlah_pengunjung')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div class="mb-4">
                            <label for="tanggal_kunjungan" class="form-label fw-semibold">Tanggal Kunjungan *</label>
                            <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                                id="tanggal_kunjungan" name="tanggal_kunjungan" 
                                value="{{ old('tanggal_kunjungan') }}" 
                                min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_kunjungan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Informasi tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        </div>

                        <!-- Upload Bukti Dokumen -->
                        <div class="mb-4">
                            <label for="bukti_dokumen" class="form-label fw-semibold">Upload Dokumen Bukti (PDF) *</label>
                            <input type="file" class="form-control @error('bukti_dokumen') is-invalid @enderror" 
                                id="bukti_dokumen" name="bukti_dokumen" accept=".pdf" required>
                            <small class="text-muted">Upload KTP/Surat Keterangan/Undangan (Max 5MB, format PDF)</small>
                            @error('bukti_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold">
                                <i class="bi bi-send me-2"></i>Kirim Permintaan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleProvinsi() {
    const negara = document.getElementById('negara').value;
    const provinsiWrapper = document.getElementById('provinsi_wrapper');
    
    if (negara === 'Indonesia') {
        provinsiWrapper.style.display = 'block';
        loadProvinsi();
    } else {
        provinsiWrapper.style.display = 'none';
    }
}

function loadProvinsi() {
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('provinsi');
            select.innerHTML = '<option value="">Pilih Provinsi</option>';
            data.forEach(prov => {
                select.innerHTML += `<option value="${prov.name}">${prov.name}</option>`;
            });
        });
}

// Check on load
if (document.getElementById('negara').value === 'Indonesia') {
    toggleProvinsi();
}
</script>
@endsection
