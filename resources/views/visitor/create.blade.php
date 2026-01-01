@extends('layouts.app')

@section('title', 'Submit Ticket')

@section('content')
<div class="row justify-content-center mb-5 pb-5">
    <div class="col-md-10 col-lg-8">
        <div class="card mt-5 shadow-lg border-0 ticket-form-card" style="border-radius: 20px; overflow: hidden;">
            <!-- Header dengan tema Modern Geology -->
            <div class="card-header text-center py-4" style="background: #1F2933; border: none;">
                <h3 class="mb-0" style="color: #ffffff; font-family: 'Merriweather', serif; font-weight: 700; letter-spacing: 0.5px;" data-lang-key="ticket_title">
                    Data Pemesanan Tiket
                </h3>
            </div>
            
            <div class="card-body p-4 p-md-5" style="background: #F9FAFB;">
                <!-- Tampilkan Error Validation -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Terjadi Kesalahan Validasi:
                        </h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Info Kapasitas Harian -->
                <div class="alert border-0 shadow-sm mb-4" style="background: #FFC107; border-radius: 1rem;">
                    <div class="d-flex align-items-center text-dark">
                        <i class="bi bi-people-fill me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h6 class="mb-1 fw-bold" data-lang-key="form_max_capacity_title">Kapasitas Maksimal Per Hari</h6>
                            <p class="mb-0 small">
                                <i class="bi bi-info-circle-fill me-1"></i>
                                <span data-lang-key="form_max_capacity_desc">Museum dapat menerima maksimal <strong>2.500 pengunjung per hari</strong>. Pastikan booking Anda sebelum kuota penuh!</span>
                            </p>
                        </div>
                    </div>
                </div>

                <form id="bookingForm" action="{{ route('tickets.store') }}" method="POST" novalidate>
                    @csrf
                    
                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-semibold" data-lang-key="ticket_name">
                            Nama Lengkap
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-person-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" class="form-control modern-ticket-input" id="nama" name="nama" 
                                placeholder="Masukkan nama lengkap" data-lang-placeholder="ticket_name_placeholder" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold" data-lang-key="ticket_email">
                            Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-envelope-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="email" class="form-control modern-ticket-input" id="email" name="email" 
                                placeholder="contoh@email.com" data-lang-placeholder="ticket_email_placeholder" required>
                        </div>
                    </div>

                    <!-- Negara -->
                    <div class="mb-4">
                        <label for="negara" class="form-label fw-semibold" data-lang-key="ticket_country">
                            Negara Asal
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-globe-americas" style="color: #9CA3AF;"></i>
                            </span>
                            <select class="form-select modern-ticket-input" id="negara" name="negara" required>
                                <option value="" data-lang-key="form_select_country">Pilih Negara</option>
                            </select>
                        </div>
                    </div>

                    <!-- Provinsi (untuk Indonesia) -->
                    <div class="mb-4" id="provinsi_group" style="display:none;">
                        <label for="provinsi" class="form-label fw-semibold" data-lang-key="ticket_province">
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

                    <!-- Jenis Pemesanan -->
                    <div class="mb-4">
                        <label for="jenis_pemesanan" class="form-label fw-semibold" data-lang-key="ticket_booking_type">
                            Jenis Pemesanan
                        </label>
                        <div class="alert alert-info border-0 shadow-sm mb-3" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6 !important; border-radius: 0.75rem;">
                            <small>
                                <i class="bi bi-info-circle-fill me-1"></i>
                                <strong data-lang-key="form_booking_rules">Aturan Booking:</strong><br>
                                • <span data-lang-key="form_max_capacity_rule"><strong>Kapasitas maksimal: 2.500 pengunjung/hari</strong></span><br>
                                • <span data-lang-key="form_individual_rule"><strong>Individu</strong> (1-19 orang): Tidak dibatasi jam kunjungan</span><br>
                                • <span data-lang-key="form_group_rule"><strong>Rombongan</strong> (≥20 orang): Wajib memilih slot waktu per jam</span><br>
                                <em class="text-muted" data-lang-key="form_auto_determine">*Sistem akan otomatis menentukan jenis pemesanan berdasarkan total pengunjung</em>
                            </small>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-ticket-detailed-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <select class="form-select modern-ticket-input" id="jenis_pemesanan" name="jenis_pemesanan" required>
                                <option value="" data-lang-key="form_select_booking_type">Pilih Jenis Pemesanan</option>
                                <option value="individu">Individu (1-19 orang)</option>
                                <option value="rombongan">Rombongan (≥20 orang)</option>
                                <option value="tiket_khusus">Tiket Khusus (Gratis)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Rombongan -->
                    <div class="mb-4" id="nama_rombongan_group" style="display:none;">
                        <label for="nama_rombongan" class="form-label fw-semibold" data-lang-key="ticket_group_name">
                            Nama Rombongan / Instansi
                        </label>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-buildings-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" class="form-control modern-ticket-input" id="nama_rombongan" name="nama_rombongan" 
                                placeholder="Nama sekolah / perusahaan" data-lang-placeholder="ticket_group_name_placeholder">
                        </div>
                    </div>

                    <!-- Jenis Pengunjung Dinamis -->
                    <div class="mb-4" id="jenis_pengunjung_group" style="display:none;">
                        <label class="form-label fw-semibold" data-lang-key="ticket_visitor_count">
                            Jumlah Pengunjung
                        </label>

                        <!-- Individu (1-19 orang) -->
                        <div id="pengunjung_individu" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 4px solid #FACC15;">
                            <div class="alert alert-warning border-0 shadow-sm mb-3" style="background: rgba(251, 191, 36, 0.1); border-left: 4px solid #FACC15 !important;">
                                <small>
                                    <i class="bi bi-info-circle-fill me-1"></i>
                                    <span data-lang-key="form_individual_alert"><strong>Individu:</strong> Maksimal 19 orang total. Sistem akan otomatis alihkan ke Rombongan jika ≥20 orang.</span>
                                </small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold" data-lang-key="student_count">
                                    Jumlah Pelajar
                                </label>
                                <div class="row g-3">
                                    @foreach(['tk'=>'TK','sd'=>'SD','smp'=>'SMP','sma'=>'SMA','kuliah'=>'Kuliah'] as $k=>$v)
                                    <div class="col-6 col-md-4">
                                        <label class="fw-semibold mb-2 small">
                                            {{ $v }}
                                        </label>
                                        <div class="input-group modern-counter">
                                            <button type="button" class="btn btn-counter" onclick="changeCount('individu_sub_{{ $k }}',-1)">
                                                −
                                            </button>
                                            <input type="number" class="form-control text-center fw-semibold counter-input" id="individu_sub_{{ $k }}" name="sub_{{ $k }}" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();">
                                            <button type="button" class="btn btn-counter" onclick="changeCount('individu_sub_{{ $k }}',1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" data-lang-key="general_count">
                                    Jumlah Umum
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('individu_jumlah_umum',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="individu_jumlah_umum" name="jumlah_umum" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('individu_jumlah_umum',1)">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" data-lang-key="foreign_count">
                                    Jumlah Asing
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('individu_jumlah_asing',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="individu_jumlah_asing" name="jumlah_asing" value="0" min="0" max="19" oninput="validateNumberInput(this); checkIndividuLimit();">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('individu_jumlah_asing',1)">
                                        +
                                    </button>
                                </div>
                            </div>
                            
                            <div class="alert border-0 shadow-sm" id="individu_total_display" style="background: #1F2933; color: white;">
                                <strong data-lang-key="total_visitors">Total Pengunjung:</strong> <span id="individu_total">0</span> <span data-lang-key="visitors">orang</span>
                            </div>
                        </div>

                        <!-- Rombongan -->
                        <div id="pengunjung_rombongan" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 4px solid #10B981;">
                            <div class="mb-4">
                                <label class="form-label fw-semibold" data-lang-key="student_count">
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
                                            <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_sub_{{ $k }}" name="rombongan_sub_{{ $k }}" value="0" min="0" oninput="validateNumberInput(this)">
                                            <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_sub_{{ $k }}',1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" data-lang-key="general_count">
                                    Jumlah Umum
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_umum',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_jumlah_umum" name="rombongan_jumlah_umum" value="0" min="0" oninput="validateNumberInput(this)">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_umum',1)">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" data-lang-key="foreign_count">
                                    Jumlah Asing
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_asing',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="rombongan_jumlah_asing" name="rombongan_jumlah_asing" value="0" min="0" oninput="validateNumberInput(this)">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('rombongan_jumlah_asing',1)">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tiket Khusus -->
                        <div id="pengunjung_tiket_khusus" style="display:none;" class="p-4 rounded-3 shadow-sm" style="background: rgba(255,255,255,0.7); border-left: 4px solid #EF4444;">
                            <div class="alert alert-warning mb-4" style="border-left: 4px solid #F59E0B;">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Langkah-Langkah Mendapatkan Dokumen Approval
                                </h6>
                                <ol class="mb-0 ps-3">
                                    <li class="mb-2">
                                        <strong>Hubungi Customer Service</strong><br>
                                        <small>Silakan hubungi Customer Service kami melalui WhatsApp untuk mengajukan permintaan tiket khusus.</small>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Isi Form Pendataan</strong><br>
                                        <small>Customer Service akan memberikan form pendataan yang harus Anda isi melalui WhatsApp.</small>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Tunggu Konfirmasi</strong><br>
                                        <small>Customer Service akan meninjau permintaan Anda dan memberikan konfirmasi apakah permintaan diterima atau ditolak.</small>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Terima Dokumen Approval</strong><br>
                                        <small>Jika diterima, Customer Service akan mengirimkan dokumen approval (PDF) kepada Anda.</small>
                                    </li>
                                    <li class="mb-0">
                                        <strong>Upload Dokumen Approval</strong><br>
                                        <small>Masukkan dokumen approval PDF yang diterima pada kolom di bawah ini untuk melanjutkan pemesanan.</small>
                                    </li>
                                </ol>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Kategori Khusus <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-star-fill" style="color: #9CA3AF;"></i>
                                    </span>
                                    <select class="form-select modern-ticket-input" id="kategori_khusus" name="kategori_khusus">
                                        <option value="">Pilih Kategori Khusus</option>
                                        <option value="lansia">Lansia (60+ tahun)</option>
                                        <option value="disabilitas">Disabilitas</option>
                                        <option value="panti_asuhan">Panti Asuhan</option>
                                        <option value="peserta_diklat">Peserta Diklat</option>
                                        <option value="tamu_negara">Tamu Negara</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4" id="keterangan_lainnya_group" style="display:none;">
                                <label class="form-label fw-semibold">
                                    Keterangan (Jelaskan Kategori Anda) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon" style="align-items: flex-start; padding-top: 0.75rem;">
                                        <i class="bi bi-chat-left-text-fill" style="color: #9CA3AF;"></i>
                                    </span>
                                    <textarea class="form-control modern-ticket-input" id="keterangan" name="keterangan" rows="3" placeholder="Jelaskan kategori pengunjung Anda dan alasan memerlukan tiket khusus..."></textarea>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jelaskan secara detail kategori pengunjung Anda dan mengapa memerlukan tiket khusus gratis.
                                </small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Jumlah Pengunjung <span class="text-danger">*</span>
                                </label>
                                <div class="input-group modern-counter" style="max-width:250px;">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('jumlah_pengunjung_khusus',-1)">
                                        −
                                    </button>
                                    <input type="number" class="form-control text-center fw-semibold counter-input" id="jumlah_pengunjung_khusus" name="jumlah_pengunjung" value="1" min="1" oninput="validateNumberInput(this)">
                                    <button type="button" class="btn btn-counter" onclick="changeCount('jumlah_pengunjung_khusus',1)">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Upload Dokumen Approval (PDF) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-file-pdf-fill" style="color: #DC2626;"></i>
                                    </span>
                                    <input type="file" class="form-control modern-ticket-input" id="bukti_dokumen" name="bukti_dokumen" accept=".pdf">
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Upload dokumen approval yang telah diberikan oleh Customer Service. Maksimal 5MB.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold" data-lang-key="visit_date_label">
                            Tanggal Kunjungan
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text modern-input-icon">
                                        <i class="bi bi-calendar3" style="color: #9CA3AF;"></i>
                                    </span>
                                    <input type="date" id="tanggal_kunjungan_raw" class="form-control modern-ticket-input" 
                                        min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <input type="text" id="tanggal_kunjungan_display" class="form-control modern-ticket-input" 
                                    data-lang-placeholder="form_select_date"
                                    placeholder="Pilih tanggal..." readonly 
                                    style="background:white;">
                            </div>
                        </div>
                        <input type="hidden" id="tanggal_kunjungan" name="tanggal_kunjungan" required>
                    </div>

                    <!-- Slot Waktu (untuk Rombongan ≥20 orang) -->
                    <div class="mb-4" id="slot_waktu_group" style="display:none;">
                        <label class="form-label fw-semibold" data-lang-key="visit_time_slot_label">
                            Pilih Slot Waktu Kunjungan <span class="text-danger">*</span>
                        </label>
                        <div class="alert alert-warning border-0 shadow-sm mb-3" style="background: rgba(251, 191, 36, 0.1); border-left: 4px solid #FACC15 !important; border-radius: 0.75rem;">
                            <small>
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                <span data-lang-key="visit_time_slot_required"><strong>Rombongan ≥20 orang wajib memilih slot waktu.</strong><br>
                                Kuota tersedia per slot akan ditampilkan setelah memilih tanggal.</span>
                            </small>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text modern-input-icon">
                                <i class="bi bi-clock-fill" style="color: #9CA3AF;"></i>
                            </span>
                            <select class="form-select modern-ticket-input" id="slot_waktu" name="slot_waktu">
                                <option value="" data-lang-key="visit_time_slot_placeholder">Pilih Slot Waktu</option>
                                <option value="08:00-09:00">08:00 - 09:00</option>
                                <option value="09:00-10:00">09:00 - 10:00</option>
                                <option value="10:00-11:00">10:00 - 11:00</option>
                                <option value="11:00-12:00">11:00 - 12:00</option>
                                <option value="12:00-13:00">12:00 - 13:00</option>
                                <option value="13:00-14:00">13:00 - 14:00</option>
                                <option value="14:00-15:00">14:00 - 15:00</option>
                                <option value="15:00-16:00">15:00 - 16:00</option>
                            </select>
                        </div>
                        <small class="text-muted" id="kuota_info"></small>
                    </div>

                    <button type="button" id="submitBtn" onclick="window.handleFormSubmit && window.handleFormSubmit(event)" class="btn btn-ticket-modern btn-lg w-100 mt-4" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; position: relative; z-index: 9999; pointer-events: auto; cursor: pointer;">
                        <span data-lang-key="submit_ticket">Submit Tiket</span>
                    </button>
                </form>

                <!-- Back to Home Button -->
                <div class="mt-3">
                    <a href="{{ url('/') }}" class="btn btn-back btn-lg w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                        <i class="fas fa-arrow-left me-2"></i><span data-lang-key="back_to_home">Kembali ke Beranda</span>
                    </a>
                </div>
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
    
    /* Choices.js customization - Match with other inputs */
    .choices {
        margin-bottom: 0 !important;
        width: 100% !important;
    }
    
    .choices__inner {
        border: 1px solid #E5E7EB !important;
        border-radius: 12px !important;
        padding: 0.75rem 1rem !important;
        background: #ffffff !important;
        min-height: 48px !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
        width: 100% !important;
    }
    
    .input-group .choices {
        flex: 1 1 auto !important;
        width: 1% !important;
    }
    
    .input-group .choices__inner {
        border-left: none !important;
        border-radius: 0 12px 12px 0 !important;
    }
    
    .choices[data-type*="select-one"] .choices__inner {
        padding-bottom: 0.75rem !important;
    }
    
    .choices__inner:focus,
    .is-focused .choices__inner,
    .is-open .choices__inner {
        border-color: #FACC15 !important;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1) !important;
    }
    
    .choices__list--dropdown {
        border: 1px solid #E5E7EB !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        margin-top: 4px !important;
        width: 100% !important;
        z-index: 1050 !important;
    }
    
    .choices__list--dropdown .choices__item--selectable {
        padding: 0.75rem 1rem !important;
        font-size: 1rem !important;
    }
    
    .choices__list--single {
        padding: 0 !important;
    }
    
    .choices__item {
        font-size: 1rem !important;
    }
    
    /* Ensure dropdown doesn't overflow */
    .choices[data-type*="select-one"]::after {
        border-color: #9CA3AF transparent transparent !important;
        margin-top: -2.5px !important;
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
// === GLOBAL VARIABLES ===
// Country list - defined globally at the very top
const countryList = [
    {name: "Indonesia", code: "ID", phone: "+62"}, 
    {name: "Malaysia", code: "MY", phone: "+60"}, 
    {name: "Singapore", code: "SG", phone: "+65"}, 
    {name: "Thailand", code: "TH", phone: "+66"}, 
    {name: "Vietnam", code: "VN", phone: "+84"}, 
    {name: "Australia", code: "AU", phone: "+61"}, 
    {name: "United States", code: "US", phone: "+1"}, 
    {name: "United Kingdom", code: "GB", phone: "+44"}, 
    {name: "China", code: "CN", phone: "+86"}, 
    {name: "Japan", code: "JP", phone: "+81"}, 
    {name: "South Korea", code: "KR", phone: "+82"}, 
    {name: "India", code: "IN", phone: "+91"}, 
    {name: "Philippines", code: "PH", phone: "+63"}, 
    {name: "Germany", code: "DE", phone: "+49"}, 
    {name: "France", code: "FR", phone: "+33"}, 
    {name: "Italy", code: "IT", phone: "+39"}, 
    {name: "Spain", code: "ES", phone: "+34"}, 
    {name: "Netherlands", code: "NL", phone: "+31"}, 
    {name: "Belgium", code: "BE", phone: "+32"}, 
    {name: "Switzerland", code: "CH", phone: "+41"}, 
    {name: "Canada", code: "CA", phone: "+1"}, 
    {name: "Brazil", code: "BR", phone: "+55"}, 
    {name: "Mexico", code: "MX", phone: "+52"}, 
    {name: "Argentina", code: "AR", phone: "+54"}, 
    {name: "Saudi Arabia", code: "SA", phone: "+966"}, 
    {name: "United Arab Emirates", code: "AE", phone: "+971"}, 
    {name: "Turkey", code: "TR", phone: "+90"}, 
    {name: "Egypt", code: "EG", phone: "+20"}, 
    {name: "South Africa", code: "ZA", phone: "+27"},
    {name: "New Zealand", code: "NZ", phone: "+64"},
    {name: "Russia", code: "RU", phone: "+7"},
    {name: "Pakistan", code: "PK", phone: "+92"},
    {name: "Bangladesh", code: "BD", phone: "+880"},
    {name: "Nigeria", code: "NG", phone: "+234"},
    {name: "Other", code: "XX", phone: "+00"}
];

// Province list for Indonesia
const provinsiList = [
    "Aceh", "Sumatera Utara", "Sumatera Barat", "Riau", "Kepulauan Riau", "Jambi",
    "Sumatera Selatan", "Kepulauan Bangka Belitung", "Bengkulu", "Lampung",
    "DKI Jakarta", "Jawa Barat", "Banten", "Jawa Tengah", "DI Yogyakarta", "Jawa Timur",
    "Bali", "Nusa Tenggara Barat", "Nusa Tenggara Timur",
    "Kalimantan Barat", "Kalimantan Tengah", "Kalimantan Selatan", "Kalimantan Timur", "Kalimantan Utara",
    "Sulawesi Utara", "Gorontalo", "Sulawesi Tengah", "Sulawesi Barat", "Sulawesi Selatan", "Sulawesi Tenggara",
    "Maluku", "Maluku Utara", "Papua", "Papua Barat", "Papua Tengah", "Papua Pegunungan", "Papua Selatan", "Papua Barat Daya"
];

// === HELPER FUNCTIONS ===

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

// Fungsi +/- jumlah (individu dan rombongan)
function changeCount(id, delta) {
    const input = document.getElementById(id);
    let val = parseInt(input.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    
    // Cek limit untuk individu
    if (id.startsWith('individu_')) {
        const max = parseInt(input.getAttribute('max')) || 19;
        if (val > max) val = max;
        input.value = val;
        checkIndividuLimit();
        return;
    }
    
    input.value = val;
    checkTotalPengunjungDanSlotWaktu();
}

// Fungsi untuk cek limit total individu (maks 19)
function checkIndividuLimit() {
    const fields = ['individu_sub_tk', 'individu_sub_sd', 'individu_sub_smp', 
                    'individu_sub_sma', 'individu_sub_kuliah', 'individu_jumlah_umum', 
                    'individu_jumlah_asing'];
    
    let total = 0;
    fields.forEach(fieldId => {
        const elem = document.getElementById(fieldId);
        if (elem) {
            total += parseInt(elem.value) || 0;
        }
    });
    
    // Update display
    const totalDisplay = document.getElementById('individu_total');
    if (totalDisplay) {
        totalDisplay.textContent = total;
    }
    
    // Jika melebihi 19, kurangi dari field terakhir yang diubah
    if (total > 19) {
        alert('Maksimal 19 orang untuk Individu. Sistem akan otomatis alihkan ke Rombongan jika ≥20 orang.');
        // Reset input terakhir yang melebihi - TANPA REKURSIF!
        fields.forEach(fieldId => {
            const elem = document.getElementById(fieldId);
            if (elem && document.activeElement === elem) {
                let currentVal = parseInt(elem.value) || 0;
                elem.value = Math.max(0, currentVal - (total - 19));
            }
        });
        // Update display sekali lagi tanpa rekursif
        const newTotal = fields.reduce((sum, fieldId) => {
            const elem = document.getElementById(fieldId);
            return sum + (elem ? (parseInt(elem.value) || 0) : 0);
        }, 0);
        if (totalDisplay) {
            totalDisplay.textContent = newTotal;
        }
    }
    
    // Trigger pengecekan slot waktu
    checkTotalPengunjungDanSlotWaktu();
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
    const formBooking = document.querySelector('form');

    document.getElementById('nama_rombongan_group').style.display = (jenis === 'rombongan') ? '' : 'none';

    const jenisGroup = document.getElementById('jenis_pengunjung_group');
    const pengIndividu = document.getElementById('pengunjung_individu');
    const pengRombongan = document.getElementById('pengunjung_rombongan');
    const pengTiketKhusus = document.getElementById('pengunjung_tiket_khusus');

    // Handle Tiket Khusus mode
    if (jenis === 'tiket_khusus') {
        // Change form action to special tickets route
        formBooking.action = "{{ route('special-tickets.store') }}";
        formBooking.enctype = "multipart/form-data";
        
        jenisGroup.style.display = '';
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = 'none';
        pengTiketKhusus.style.display = '';
        
        // Disable individu & rombongan inputs
        disableInputsInElement(pengIndividu);
        disableInputsInElement(pengRombongan);
        
        // Make tiket khusus fields required
        document.getElementById('kategori_khusus').setAttribute('required', 'required');
        document.getElementById('jumlah_pengunjung_khusus').setAttribute('required', 'required');
        document.getElementById('bukti_dokumen').setAttribute('required', 'required');
        return;
    }

    // Regular booking mode
    formBooking.action = "{{ route('booking.store') }}";
    formBooking.removeAttribute('enctype');
    
    // Remove required from tiket khusus fields
    if (pengTiketKhusus) {
        pengTiketKhusus.style.display = 'none';
        disableInputsInElement(pengTiketKhusus);
        document.getElementById('kategori_khusus').removeAttribute('required');
        document.getElementById('jumlah_pengunjung_khusus').removeAttribute('required');
        document.getElementById('bukti_dokumen').removeAttribute('required');
    }

    if (jenis === 'individu' || jenis === 'rombongan') {
        jenisGroup.style.display = '';
    } else {
        jenisGroup.style.display = 'none';
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = 'none';
        disableInputsInElement(pengIndividu);
        disableInputsInElement(pengRombongan);
        return;
    }

    if (jenis === 'individu') {
        pengIndividu.style.display = '';
        pengRombongan.style.display = 'none';
        
        // Enable individu inputs, disable rombongan
        enableInputsInElement(pengIndividu);
        disableInputsInElement(pengRombongan);
        
        hideAllIndividuDetails();
        updateKategoriIndividuOptions();
    } else {
        pengIndividu.style.display = 'none';
        pengRombongan.style.display = '';
        
        // Disable individu inputs, enable rombongan
        disableInputsInElement(pengIndividu);
        enableInputsInElement(pengRombongan);
    }
}

// Helper functions to enable/disable inputs
function disableInputsInElement(element) {
    if (!element) return;
    const inputs = element.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // PERBAIKAN: Jangan hapus attribute 'name', cukup reset value ke 0 dan hide saja
        // Ini agar tidak konflik dengan backend validation
        if (input.type === 'number') {
            input.value = 0;
        } else if (input.tagName === 'SELECT') {
            input.value = '';
        } else if (input.type === 'file') {
            input.value = '';
        }
        // PENTING: Remove atribut required agar HTML5 validation tidak error
        input.removeAttribute('required');
        // Tetap simpan untuk tracking, tapi JANGAN hapus name attribute
        input.setAttribute('data-disabled', 'true');
    });
}

function enableInputsInElement(element) {
    if (!element) return;
    const inputs = element.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // PERBAIKAN: Restore dari disabled state
        input.removeAttribute('data-disabled');
    });
}

// Show/hide provinsi field when Indonesia is selected
function toggleProvinsi() {
    const negara = document.getElementById('negara').value;
    const provinsiGroup = document.getElementById('provinsi_group');
    if (provinsiGroup) {
        provinsiGroup.style.display = (negara === 'Indonesia') ? '' : 'none';
    }
}

// Populate provinsi dropdown
function populateProvinsi() {
    const provinsiSelect = document.getElementById('provinsi');
    if (provinsiSelect) {
        // Clear existing options except the first one
        provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
        
        // Add all provinces
        provinsiList.forEach(function(provinsi) {
            const opt = document.createElement('option');
            opt.value = provinsi;
            opt.text = provinsi;
            provinsiSelect.appendChild(opt);
        });
        
        // Update hidden field when selection changes
        provinsiSelect.addEventListener('change', function() {
            document.getElementById('provinsi_name').value = this.value;
        });
    }
}

// Initialize Choices.js for flag icons
function initCountrySelects() {
    const negaraSelect = document.getElementById('negara');
    const phoneCountrySelect = document.getElementById('phone_country_code');
    
    // Check if Choices is loaded
    if (typeof Choices === 'undefined') {
        console.error('Choices.js not loaded - using fallback');
        return;
    }
    
    console.log('Initializing Choices.js for country selects');
    
    // Populate negara dengan bendera
    if (negaraSelect) {
        // Destroy existing instance if any
        if (window.negaraChoicesInstance) {
            window.negaraChoicesInstance.destroy();
        }
        
        const negaraChoices = [];
        countryList.forEach(function(item) {
            negaraChoices.push({
                value: item.name,
                label: '[' + item.code + '] ' + item.name,
                customProperties: {
                    phone: item.phone,
                    code: item.code
                }
            });
        });
        
        try {
            window.negaraChoicesInstance = new Choices(negaraSelect, {
                searchEnabled: true,
                itemSelectText: '',
                choices: negaraChoices,
                allowHTML: false,
                shouldSort: false,
                placeholderValue: 'Pilih Negara'
            });
            console.log('Negara Choices.js initialized successfully');
        } catch(e) {
            console.error('Error initializing Negara Choices.js:', e);
        }
    }
    
    // Populate phone country codes dengan bendera
    if (phoneCountrySelect) {
        // Destroy existing instance if any
        if (window.phoneChoicesInstance) {
            window.phoneChoicesInstance.destroy();
        }
        
        const phoneChoices = [];
        countryList.forEach(function(item) {
            phoneChoices.push({
                value: item.phone,
                label: '[' + item.code + '] ' + item.phone,
                customProperties: {
                    country: item.name,
                    code: item.code
                }
            });
        });
        
        try {
            window.phoneChoicesInstance = new Choices(phoneCountrySelect, {
                searchEnabled: true,
                itemSelectText: '',
                choices: phoneChoices,
                allowHTML: true,
                shouldSort: false
            });
            
            // Set default to Indonesia
            window.phoneChoicesInstance.setChoiceByValue('+62');
            console.log('Phone Choices.js initialized successfully');
        } catch(e) {
            console.error('Error initializing Phone Choices.js:', e);
        }
    }
}

// Fungsi untuk mengecek total pengunjung dan tampilkan slot waktu jika >= 20
// HARUS DI GLOBAL SCOPE agar bisa dipanggil dari onclick
function checkTotalPengunjungDanSlotWaktu() {
    const jenisPemesanan = document.getElementById('jenis_pemesanan').value;
    
    // Hitung total pengunjung berdasarkan counter inputs
    let totalPengunjung = 0;
    
    if (jenisPemesanan === 'individu') {
        // Hitung dari counter individu
        const individuFields = ['individu_sub_tk', 'individu_sub_sd', 'individu_sub_smp', 
                               'individu_sub_sma', 'individu_sub_kuliah', 'individu_jumlah_umum', 
                               'individu_jumlah_asing'];
        individuFields.forEach(fieldId => {
            const elem = document.getElementById(fieldId);
            if (elem) {
                totalPengunjung += parseInt(elem.value) || 0;
            }
        });
    } else if (jenisPemesanan === 'rombongan') {
        // Hitung dari counter rombongan
        const rombonganFields = ['rombongan_sub_tk', 'rombongan_sub_sd', 'rombongan_sub_smp', 
                                'rombongan_sub_sma', 'rombongan_sub_kuliah', 'rombongan_jumlah_umum', 
                                'rombongan_jumlah_asing'];
        rombonganFields.forEach(fieldId => {
            const elem = document.getElementById(fieldId);
            if (elem) {
                totalPengunjung += parseInt(elem.value) || 0;
            }
        });
    }
    
    // Tampilkan slot waktu dan nama rombongan jika >= 20 orang
    const slotWaktuGroup = document.getElementById('slot_waktu_group');
    const slotWaktuSelect = document.getElementById('slot_waktu');
    const namaRombonganGroup = document.getElementById('nama_rombongan_group');
    
    if (totalPengunjung >= 20) {
        if (slotWaktuGroup) slotWaktuGroup.style.display = '';
        if (slotWaktuSelect) slotWaktuSelect.setAttribute('required', 'required');
        if (namaRombonganGroup) namaRombonganGroup.style.display = '';
    } else {
        if (slotWaktuGroup) slotWaktuGroup.style.display = 'none';
        if (slotWaktuSelect) {
            slotWaktuSelect.removeAttribute('required');
            slotWaktuSelect.value = '';
        }
        if (namaRombonganGroup) namaRombonganGroup.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOMContentLoaded fired!');
    console.log('� CODE VERSION: 2025-01-20-v3 - Button type changed to button');
    console.log('�🔍 Starting form initialization...');
    
    // Populate provinsi dropdown immediately
    populateProvinsi();
    
    // Load Choices.js library first
    const choicesScript = document.createElement('script');
    choicesScript.src = 'https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js';
    choicesScript.onload = function() {
        console.log('Choices.js loaded successfully');
        // Initialize country selects after Choices.js is loaded
        setTimeout(function() {
            initCountrySelects();
        }, 100);
    };
    choicesScript.onerror = function() {
        console.error('Failed to load Choices.js - using fallback');
        // Fallback: populate with simple options
        populateCountryFallback();
    };
    document.head.appendChild(choicesScript);
    
    // Event listeners
    const jenisPemesananEl = document.getElementById('jenis_pemesanan');
    const negaraEl = document.getElementById('negara');
    
    if (jenisPemesananEl) {
        jenisPemesananEl.addEventListener('change', refreshForm);
    }
    
    if (negaraEl) {
        negaraEl.addEventListener('change', function() {
            refreshForm();
            toggleProvinsi();
        });
    }
    
    // PENTING: Panggil refreshForm() saat page load untuk disable field yang tidak diperlukan
    // Ini mencegah error HTML5 validation pada field yang hidden tapi required
    refreshForm();

    // Tambahkan event listener untuk setiap input jumlah pengunjung
    document.querySelectorAll('input[type="number"]').forEach(input => {
        if (input.id.includes('sub_') || input.id.includes('jumlah_')) {
            if (input.id.startsWith('individu_')) {
                input.addEventListener('input', checkIndividuLimit);
            } else if (input.id.startsWith('rombongan_')) {
                input.addEventListener('input', checkTotalPengunjungDanSlotWaktu);
            }
        }
    });

    // Kategori individu berubah
    const kategoriIndividuEl = document.getElementById('kategori_individu');
    if (kategoriIndividuEl) {
        kategoriIndividuEl.addEventListener('change', function() {
            hideAllIndividuDetails();
            const val = this.value;

            if (val === 'asing') {
                document.getElementById('individu_asing').style.display = '';
                document.getElementById('jumlah_asing').value = 1;
            } else if (val === 'umum') {
                document.getElementById('individu_umum').style.display = '';
            }
        });
    }

    // Pelajar / bukan
    const isPelajarEl = document.getElementById('is_pelajar');
    if (isPelajarEl) {
        isPelajarEl.addEventListener('change', function() {
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
    }

    // Jenjang pelajar
    const jenjangPelajarEl = document.getElementById('jenjang_pelajar');
    if (jenjangPelajarEl) {
        jenjangPelajarEl.addEventListener('change', function() {
            const val = this.value;
            const jumlahDiv = document.getElementById('individu_umum_pelajar_jumlah');
            if (jumlahDiv) jumlahDiv.style.display = val ? '' : 'none';

            ['sub_tk','sub_sd','sub_smp','sub_sma','sub_kuliah'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = 0;
            });

            if (val) {
                const targetEl = document.getElementById(val);
                if (targetEl) targetEl.value = 1;
                const text = this.options[this.selectedIndex].text;
                const infoEl = document.getElementById('info_pelajar');
                if (infoEl) infoEl.innerHTML = `<strong>Kategori:</strong> Pelajar ${text}, <strong>Jumlah:</strong> 1`;
            }
        });
    }

    // Format tanggal dan disable Jumat + libur nasional
    const disabledDates = @json($disabledDates ?? []);
    
    const tanggalRawInput = document.getElementById('tanggal_kunjungan_raw');
    const tanggalDisplayInput = document.getElementById('tanggal_kunjungan_display');
    const tanggalHiddenInput = document.getElementById('tanggal_kunjungan');
    
    if (tanggalRawInput) {
        console.log('Tanggal input found, attaching event listener');
        
        tanggalRawInput.addEventListener('change', function() {
            console.log('Tanggal changed:', this.value);
            const raw = this.value;
            if (!raw) return;

            // Parse date properly to avoid timezone issues
            const [year, month, day] = raw.split('-');
            const date = new Date(year, month - 1, day);

            // Cek apakah tanggal termasuk disabled
            if (disabledDates.includes(raw)) {
                const dayName = date.toLocaleDateString('id-ID', { weekday: 'long' });
                
                let message = 'Museum tutup pada tanggal yang Anda pilih.';
                if (dayName === 'Jumat') {
                    message = 'Museum tutup setiap hari Jumat. Silakan pilih tanggal lain.';
                } else {
                    message = 'Museum tutup pada tanggal ini (hari libur nasional). Silakan pilih tanggal lain.';
                }
                
                alert(message);
                this.value = '';
                if (tanggalDisplayInput) tanggalDisplayInput.value = '';
                if (tanggalHiddenInput) tanggalHiddenInput.value = '';
                return;
            }

            // Format tanggal ke bahasa Indonesia (contoh: 11 Januari 2026)
            const bulanIndonesia = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            const tanggal = parseInt(day);
            const namaBulan = bulanIndonesia[parseInt(month) - 1];
            const tahun = year;
            const display = `${tanggal} ${namaBulan} ${tahun}`;

            console.log('Formatted date:', display);
            console.log('Setting display value to:', display);
            console.log('Setting hidden value to:', raw);
            
            if (tanggalDisplayInput) {
                tanggalDisplayInput.value = display;
                console.log('Display input value after set:', tanggalDisplayInput.value);
            }
            if (tanggalHiddenInput) {
                tanggalHiddenInput.value = raw;
                console.log('Hidden input value after set:', tanggalHiddenInput.value);
            }
        });
    } else {
        console.error('tanggal_kunjungan_raw input not found!');
    }

    // === COUNTRY DROPDOWN POPULATION ===
    const negaraSelect = document.getElementById('negara');
    const phoneCountrySelect = document.getElementById('phone_country_code');
    
    // Populate negara dengan bendera (menggunakan emoji dan kode negara)
    // Fungsi fallback jika Choices.js tidak ter-load
    function populateCountryFallback() {
        console.log('Using fallback country population');
        if (negaraSelect) {
            negaraSelect.innerHTML = '<option value="" data-lang-key="form_select_country">Pilih Negara</option>';
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
    }
    
    // Initial population (fallback method) - execute immediately
    populateCountryFallback();
    
    // Auto-update phone code ketika negara berubah
    document.getElementById('negara').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const phoneCode = selectedOption.getAttribute('data-phone');
        if (phoneCode && phoneCountrySelect) {
            phoneCountrySelect.value = phoneCode;
        }
        refreshForm();
    });
    
    // STRATEGI ULTIMATE: Multiple attachment strategies
    const bookingForm = document.getElementById('bookingForm');
    const submitBtn = document.getElementById('submitBtn');
    console.log('🔍 Form:', bookingForm);
    console.log('🔍 Submit button:', submitBtn);
    console.log('🔍 Button type:', submitBtn ? submitBtn.type : 'NOT FOUND');
    console.log('🔍 Button computed style:', submitBtn ? window.getComputedStyle(submitBtn).pointerEvents : 'NOT FOUND');
    console.log('🔍 Button z-index:', submitBtn ? window.getComputedStyle(submitBtn).zIndex : 'NOT FOUND');
    
    if (submitBtn && bookingForm) {
        console.log('✅ Both found! Attaching MULTIPLE event listeners...');
        
        // HANDLER FUNCTION yang akan digunakan berkali-kali
        // PENTING: Assign ke window agar bisa diakses dari inline onclick
        window.handleFormSubmit = function(e) {
            console.log('🎯🎯🎯 WINDOW.HANDLEFORMSUBMIT CALLED!');
            return handleSubmit.call(submitBtn, e);
        };
        
        function handleSubmit(e) {
            // Prevent default IMMEDIATELY
            e.preventDefault();
            e.stopPropagation();
            console.log('=== SUBMIT BUTTON CLICKED ===');
            console.log('Button element:', this);
            console.log('Form element:', bookingForm);
            console.log('Form action:', bookingForm.action);
            console.log('Form method:', bookingForm.method);
            
            // Validasi: pastikan jenis pemesanan sudah dipilih
            const jenisPemesanan = document.getElementById('jenis_pemesanan').value;
            console.log('Jenis pemesanan:', jenisPemesanan);
            
            if (!jenisPemesanan) {
                alert('Silakan pilih Jenis Pemesanan terlebih dahulu');
                console.log('❌ BLOCKED: No jenis pemesanan');
                return false;
            }
            
            // Validasi: untuk individu dan rombongan, cek jumlah pengunjung
            if (jenisPemesanan === 'individu' || jenisPemesanan === 'rombongan') {
                let totalPengunjung = 0;
                const prefix = jenisPemesanan;
                
                // Hitung total dari semua field
                const fields = [
                    prefix + '_sub_tk', prefix + '_sub_sd', prefix + '_sub_smp',
                    prefix + '_sub_sma', prefix + '_sub_kuliah',
                    prefix + '_jumlah_umum', prefix + '_jumlah_asing'
                ];
                
                console.log('Checking fields for prefix:', prefix);
                fields.forEach(fieldId => {
                    const elem = document.getElementById(fieldId);
                    console.log('  Field:', fieldId, 'exists:', !!elem);
                    // PERBAIKAN: Cek data-disabled attribute instead of disabled property
                    if (elem && !elem.hasAttribute('data-disabled')) {
                        const val = parseInt(elem.value) || 0;
                        totalPengunjung += val;
                        console.log('    →', fieldId + ':', val, '(data-disabled:', elem.hasAttribute('data-disabled') + ')');
                    } else if (elem) {
                        console.log('    → SKIPPED (data-disabled)');
                    }
                });
                
                console.log('Total pengunjung:', totalPengunjung);
                
                if (totalPengunjung === 0) {
                    alert('Silakan isi jumlah pengunjung minimal 1 orang');
                    console.log('❌ BLOCKED: No pengunjung');
                    return false;
                }
                
                // Validasi slot waktu untuk rombongan >= 20
                if (totalPengunjung >= 20) {
                    const slotWaktu = document.getElementById('slot_waktu');
                    console.log('Slot waktu required. Value:', slotWaktu ? slotWaktu.value : 'element not found');
                    
                    if (!slotWaktu || !slotWaktu.value) {
                        alert('Untuk rombongan ≥20 orang, wajib memilih slot waktu kunjungan');
                        console.log('❌ BLOCKED: No slot waktu for >=20 people');
                        return false;
                    }
                }
            }
            
            // Check all required fields before submit
            const requiredFields = ['nama', 'email', 'negara', 'tanggal_kunjungan'];
            console.log('Checking required fields...');
            for (let fieldName of requiredFields) {
                const field = document.getElementById(fieldName);
                const value = field ? field.value : '';
                console.log('  Required field:', fieldName, '=', '"' + value + '"', 'exists:', !!field);
                
                if (!field || !field.value || field.value.trim() === '') {
                    alert('Mohon lengkapi semua field yang wajib diisi: ' + fieldName);
                    console.log('❌ BLOCKED: Missing required field:', fieldName);
                    return false;
                }
            }
            
            console.log('✅ All validations passed! Submitting form...');
            console.log('📤 Manually submitting form now...');
            // Submit form secara programmatic
            bookingForm.submit();
        }
        
        // EXPOSE ke window agar inline onclick bisa akses
        window.handleFormSubmit = function(e) {
            console.log('✅✅✅ INLINE ONCLICK TRIGGERED!');
            return handleSubmit.call(submitBtn, e);
        };
        
        // STRATEGI 1: addEventListener dengan bubble phase (default)
        submitBtn.addEventListener('click', handleSubmit);
        console.log('✅ Strategy 1: addEventListener (bubble) attached');
        
        // STRATEGI 2: addEventListener dengan capture phase
        submitBtn.addEventListener('click', handleSubmit, true);
        console.log('✅ Strategy 2: addEventListener (capture) attached');
        
        // STRATEGI 3: onclick property (will override any existing)
        submitBtn.onclick = handleSubmit;
        console.log('✅ Strategy 3: onclick property set');
        
        // STRATEGI 4: Test immediate clickability
        console.log('🧪 Testing button clickability...');
        submitBtn.addEventListener('mousedown', function() {
            console.log('🖱️ MOUSEDOWN detected on button!');
        });
        submitBtn.addEventListener('mouseup', function() {
            console.log('🖱️ MOUSEUP detected on button!');
        });
        
        console.log('✅ ALL event listeners attached successfully!');
    } else {
        console.error('❌ ERROR: Button or Form not found!', {submitBtn, bookingForm});
    }
    
    // Load provinsi dari API Wilayah Indonesia (lebih dinamis untuk pembaruan data)
    // Gunakan API sebagai primary source, fallback ke provinsiList jika gagal
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('API response not OK');
            }
            return response.json();
        })
        .then(provinces => {
            const provinsiSelect = document.getElementById('provinsi');
            if (provinsiSelect) {
                // Clear existing options except the first one
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                
                // Populate from API
                provinces.forEach(prov => {
                    const opt = document.createElement('option');
                    opt.value = prov.name;
                    opt.textContent = prov.name;
                    provinsiSelect.appendChild(opt);
                });
                
                console.log('Provinsi loaded from API successfully');
            }
        })
        .catch(error => {
            console.warn('Failed to load provinces from API, using fallback list:', error);
            // Fallback: gunakan provinsiList yang sudah didefinisikan
            populateProvinsi();
        });
    
    // Event listener untuk menyimpan nama provinsi ketika dipilih
    const provinsiEl = document.getElementById('provinsi');
    if (provinsiEl) {
        provinsiEl.addEventListener('change', function() {
            const provinsiNameInput = document.getElementById('provinsi_name');
            if (provinsiNameInput) {
                provinsiNameInput.value = this.value || '';
            }
        });
    }
    
    // Toggle keterangan field untuk kategori "lainnya"
    const kategoriKhususSelect = document.getElementById('kategori_khusus');
    const keteranganGroup = document.getElementById('keterangan_lainnya_group');
    const keteranganField = document.getElementById('keterangan');
    
    if (kategoriKhususSelect && keteranganGroup && keteranganField) {
        kategoriKhususSelect.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                keteranganGroup.style.display = '';
                keteranganField.setAttribute('required', 'required');
            } else {
                keteranganGroup.style.display = 'none';
                keteranganField.removeAttribute('required');
                keteranganField.value = '';
            }
        });
    }
});
</script>
@endsection
