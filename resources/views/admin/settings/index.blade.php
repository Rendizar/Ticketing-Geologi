@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<!-- Particles Background -->
<div id="particles-js"></div>

<div class="container-fluid settings-content">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="brand-text mb-3">
                <i class="fas fa-cog me-3"></i>Pengaturan Sistem
            </h1>
            <p class="subtitle-text"><strong>Kelola Pengaturan Museum Geologi Bandung</strong></p>
        </div>
    </div>

    <!-- Floating Notifications -->
    <div class="floating-notifications">
        @if(session('success'))
            <div class="alert-success-custom alert-floating">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="alert-close-btn" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error-custom alert-floating">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="alert-close-btn" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error-custom alert-floating">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="alert-close-btn" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Tabs Navigation -->
    <div class="settings-tabs mb-4">
        <div class="tab-container">
            <button class="settings-tab-item active" data-tab="ticket-prices">
                <i class="fas fa-tag me-2"></i>Harga Tiket
            </button>
            <button class="settings-tab-item" data-tab="operational">
                <i class="fas fa-clock me-2"></i>Hari & Jam Operasional
            </button>
            <button class="settings-tab-item" data-tab="security">
                <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content-wrapper">
        
        <!-- TICKET PRICES TAB -->
        <div class="settings-tab-pane active" id="ticket-prices">
            <div class="detail-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <i class="fas fa-ticket-alt me-2"></i>
                        Kategori & Harga Tiket
                    </div>
                    @if(App\Helpers\HolidayHelper::canUpdatePrice())
                        <span class="status-badge-unlock">
                            <i class="fas fa-unlock me-1"></i>Bisa Edit Harga
                            @if(App\Helpers\HolidayHelper::isFriday())
                                (Hari Jumat)
                            @elseif(App\Helpers\HolidayHelper::getHolidayName())
                                ({{ App\Helpers\HolidayHelper::getHolidayName() }})
                            @endif
                        </span>
                    @else
                        <span class="status-badge-lock">
                            <i class="fas fa-lock me-1"></i>Edit Harga Terkunci
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @if(!App\Helpers\HolidayHelper::canUpdatePrice())
                        <div class="alert-warning-custom mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> {{ App\Helpers\HolidayHelper::getUpdateRestrictionMessage() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update-prices') }}" method="POST" class="settings-form">
                        @csrf
                        @method('PUT')

                        <div class="table-responsive">
                            <table class="table table-settings">
                                <thead>
                                    <tr>
                                        <th width="30%"><i class="fas fa-list me-1"></i> Kategori</th>
                                        <th width="40%"><i class="fas fa-money-bill-wave me-1"></i> Harga (Rp)</th>
                                        <th width="30%"><i class="fas fa-info-circle me-1"></i> Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr class="category-row">
                                            <td>
                                                <strong>{{ $category->name }}</strong>
                                                @if(in_array($category->code, ['pelajar', 'umum', 'asing']))
                                                    <span class="badge-main-category">Kategori Utama</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="price-input-group">
                                                    <span class="price-prefix">Rp</span>
                                                    <input 
                                                        type="number" 
                                                        name="prices[{{ $category->id }}]" 
                                                        class="price-input" 
                                                        value="{{ old('prices.' . $category->id, $category->price) }}"
                                                        min="0"
                                                        step="1000"
                                                        {{ !App\Helpers\HolidayHelper::canUpdatePrice() ? 'readonly' : '' }}
                                                        required
                                                    >
                                                </div>
                                            </td>
                                            <td class="category-description">
                                                {{ $category->description ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label-custom">Alasan Perubahan Harga (Opsional)</label>
                            <textarea 
                                class="textarea-custom" 
                                id="reason" 
                                name="reason" 
                                rows="3" 
                                placeholder="Contoh: Penyesuaian harga sesuai inflasi tahun 2026"
                                {{ !App\Helpers\HolidayHelper::canUpdatePrice() ? 'readonly' : '' }}
                            ></textarea>
                        </div>

                        <div class="action-buttons">
                            <button 
                                type="submit" 
                                class="btn-save"
                                {{ !App\Helpers\HolidayHelper::canUpdatePrice() ? 'disabled' : '' }}
                            >
                                <i class="fas fa-save me-2"></i>Simpan Perubahan Harga
                            </button>
                            <button type="reset" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>

                    <!-- Price History Summary -->
                    <div class="price-history-section">
                        <div class="history-header">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Perubahan Harga Terakhir</h5>
                            <a href="{{ route('admin.settings.all-price-history') }}" class="btn-view-history">
                                <i class="bi bi-clock-history me-2"></i>Lihat Semua Riwayat Harga
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-history">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Harga Lama</th>
                                        <th>Harga Baru</th>
                                        <th>Tanggal</th>
                                        <th>Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentHistory as $history)
                                        <tr class="history-row">
                                            <td class="fw-semibold">{{ $history->ticketCategory->name }}</td>
                                            <td><span class="price-old">Rp {{ number_format($history->old_price, 0, ',', '.') }}</span></td>
                                            <td><span class="price-new">Rp {{ number_format($history->new_price, 0, ',', '.') }}</span></td>
                                            <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $history->admin->nama_lengkap ?? 'Admin' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center empty-state">
                                                <i class="fas fa-inbox display-6 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Belum ada perubahan harga</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OPERATIONAL TAB -->
        <div class="settings-tab-pane" id="operational">
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="fas fa-clock me-2"></i>
                    Atur Hari & Jam Operasional Museum
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update-operational') }}" method="POST" class="settings-form">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-calendar-check me-2"></i>Hari Operasional
                            </label>
                            <p class="form-description">Pilih hari-hari museum buka untuk kunjungan</p>
                            
                            @php
                                $selectedDays = explode(',', $operationalDays);
                                $allDays = [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa',
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat',
                                    'saturday' => 'Sabtu',
                                    'sunday' => 'Minggu'
                                ];
                            @endphp

                            <div class="days-grid">
                                @foreach($allDays as $value => $label)
                                    <div class="day-checkbox-wrapper">
                                        <input 
                                            class="day-checkbox" 
                                            type="checkbox" 
                                            name="operational_days[]" 
                                            value="{{ $value }}" 
                                            id="day_{{ $value }}"
                                            {{ in_array($value, $selectedDays) ? 'checked' : '' }}
                                        >
                                        <label class="day-label" for="day_{{ $value }}">
                                            <i class="fas fa-calendar-day me-2"></i>{{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('operational_days')
                                <div class="error-message">{{ $message }}</div>
                            @enderror

                            <div class="alert-info-custom mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan:</strong> Hari Jumat dan tanggal merah (libur nasional) akan otomatis dinonaktifkan untuk pemesanan pengunjung, meskipun dipilih di sini.
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="opening_time" class="form-label-custom">
                                    <i class="fas fa-clock me-2"></i>Jam Buka
                                </label>
                                <input 
                                    type="time" 
                                    class="time-input @error('opening_time') is-invalid @enderror" 
                                    id="opening_time" 
                                    name="opening_time" 
                                    value="{{ old('opening_time', $openingTime) }}"
                                    required
                                >
                                @error('opening_time')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="closing_time" class="form-label-custom">
                                    <i class="fas fa-clock me-2"></i>Jam Tutup
                                </label>
                                <input 
                                    type="time" 
                                    class="time-input @error('closing_time') is-invalid @enderror" 
                                    id="closing_time" 
                                    name="closing_time" 
                                    value="{{ old('closing_time', $closingTime) }}"
                                    required
                                >
                                @error('closing_time')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-2"></i>Simpan Pengaturan Operasional
                            </button>
                            <button type="reset" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-calendar-times me-2"></i>
                    Informasi Hari Libur
                </div>
                <div class="card-body">
                    <p class="mb-3"><strong>Hari yang tidak tersedia untuk booking:</strong></p>
                    <div class="holiday-info">
                        <div class="holiday-item">
                            <i class="fas fa-ban text-danger me-2"></i>
                            <span>Setiap hari <strong>Jumat</strong></span>
                        </div>
                        <div class="holiday-item">
                            <i class="fas fa-ban text-danger me-2"></i>
                            <span><strong>Libur Nasional Indonesia</strong> (tanggal merah)</span>
                        </div>
                    </div>
                    <div class="alert-info-custom mt-3 mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Pengunjung tidak dapat memilih hari-hari tersebut saat melakukan pemesanan tiket, bahkan jika hari tersebut dicentang sebagai hari operasional.
                    </div>
                </div>
            </div>
        </div>

        <!-- SECURITY TAB -->
        <div class="settings-tab-pane" id="security">
            <!-- CHANGE USERNAME -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-edit me-2"></i>
                    Ubah Username Admin
                </div>
                <div class="card-body">
                    <div class="alert-info-custom mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Username digunakan untuk login ke sistem admin.
                    </div>

                    <form action="{{ route('admin.settings.change-username') }}" method="POST" class="settings-form" id="usernameForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="current_username" class="form-label-custom">
                                        <i class="fas fa-user me-2"></i>Username Saat Ini
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control-custom" 
                                        id="current_username" 
                                        value="{{ Auth::guard('admin')->user()->nama }}" 
                                        disabled
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="new_username" class="form-label-custom">
                                        <i class="fas fa-user-tag me-2"></i>Username Baru
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control-custom @error('new_username') is-invalid @enderror" 
                                        id="new_username" 
                                        name="new_username" 
                                        value="{{ old('new_username') }}"
                                        required
                                        minlength="3"
                                        maxlength="50"
                                        placeholder="Masukkan username baru"
                                    >
                                    @error('new_username')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Minimal 3 karakter, maksimal 50 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="password_confirmation" class="form-label-custom">
                                        <i class="fas fa-lock me-2"></i>Password untuk Konfirmasi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control-custom @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        required
                                        placeholder="Masukkan password Anda"
                                    >
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-2"></i>Ubah Username
                            </button>
                            <button type="reset" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CHANGE PASSWORD -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <i class="fas fa-key me-2"></i>
                    Ubah Password Admin
                </div>
                <div class="card-body">
                    <div class="alert-info-custom mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tips Keamanan:</strong> Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol. Minimal 8 karakter.
                    </div>

                    <form action="{{ route('admin.settings.change-password') }}" method="POST" class="settings-form" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="current_password" class="form-label-custom">
                                        <i class="fas fa-lock me-2"></i>Password Saat Ini
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control-custom @error('current_password') is-invalid @enderror" 
                                        id="current_password" 
                                        name="current_password" 
                                        required
                                    >
                                    @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="new_password" class="form-label-custom">
                                        <i class="fas fa-key me-2"></i>Password Baru
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control-custom @error('new_password') is-invalid @enderror" 
                                        id="new_password" 
                                        name="new_password" 
                                        required
                                    >
                                    @error('new_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom mb-4">
                                    <label for="new_password_confirmation" class="form-label-custom">
                                        <i class="fas fa-check-double me-2"></i>Konfirmasi Password Baru
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control-custom" 
                                        id="new_password_confirmation" 
                                        name="new_password_confirmation" 
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="password-requirements mb-4">
                            <div class="requirements-header">
                                <i class="fas fa-shield-alt me-2"></i>
                                <strong>Password harus memenuhi kriteria berikut:</strong>
                            </div>
                            <ul class="requirements-list">
                                <li><i class="fas fa-check-circle text-muted me-2"></i>Minimal 8 karakter</li>
                                <li><i class="fas fa-check-circle text-muted me-2"></i>Mengandung huruf besar (A-Z)</li>
                                <li><i class="fas fa-check-circle text-muted me-2"></i>Mengandung huruf kecil (a-z)</li>
                                <li><i class="fas fa-check-circle text-muted me-2"></i>Mengandung angka (0-9)</li>
                                <li><i class="fas fa-check-circle text-muted me-2"></i>Mengandung simbol (!@#$%^&*)</li>
                            </ul>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-2"></i>Ubah Password
                            </button>
                            <button type="reset" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>

                        <div class="alert-warning-custom mt-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Setelah password berhasil diubah, Anda akan otomatis logout dan harus login kembali dengan password baru.
                        </div>
                    </form>
                </div>
            </div>

            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-user-shield me-2"></i>
                    Informasi Akun Admin
                </div>
                <div class="card-body">
                    <div class="info-item-custom">
                        <div class="info-label">
                            <i class="fas fa-user me-2"></i>Username
                        </div>
                        <div class="info-value">{{ Auth::guard('admin')->user()->nama }}</div>
                    </div>
                    <div class="info-item-custom">
                        <div class="info-label">
                            <i class="fas fa-clock me-2"></i>Terakhir Login
                        </div>
                        <div class="info-value">
                            @if(Auth::guard('admin')->user()->terakhir_login)
                                {{ \Carbon\Carbon::parse(Auth::guard('admin')->user()->terakhir_login)->format('d F Y, H:i') }} WIB
                            @else
                                Belum ada data
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Auto-switch to security tab if there are errors or success messages from security forms
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide floating notifications after 8 seconds
    const floatingAlerts = document.querySelectorAll('.alert-floating');
    floatingAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100px)';
            alert.style.transition = 'all 0.5s ease-out';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 8000);
    });

    @if($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_username') || $errors->has('password_confirmation') || session('success'))
        // Switch to security tab
        const securityTab = document.querySelector('[data-tab="security"]');
        const securityPane = document.getElementById('security');
        
        if (securityTab && securityPane) {
            // Remove active from all tabs
            document.querySelectorAll('.settings-tab-item').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.settings-tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            
            // Activate security tab
            securityTab.classList.add('active');
            securityPane.classList.add('active');
            
            // Scroll to security tab
            securityPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    @endif
});
</script>

@endsection

@section('styles')
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

    .settings-content {
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

    /* Floating Notifications */
    .floating-notifications {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 450px;
        width: 100%;
    }

    .alert-floating {
        position: relative;
        padding-right: 3.5rem;
        animation: slideInRight 0.5s ease-out;
        margin-bottom: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .alert-close-btn {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .alert-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.1);
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Alert Styles */
    .alert-success-custom {
        background: #10B981;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 1.25rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .alert-error-custom {
        background: #DC2626;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 1.25rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
    }

    .alert-warning-custom {
        background: #F59E0B;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 1.25rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .alert-info-custom {
        background: rgba(31, 41, 51, 0.1);
        border: 2px solid rgba(31, 41, 51, 0.2);
        border-radius: 1rem;
        padding: 1rem;
        color: var(--primary-color);
        font-weight: 500;
    }

    /* Settings Tabs */
    .settings-tabs {
        animation: fadeIn 0.8s ease-out;
    }

    .tab-container {
        display: flex;
        gap: 0.75rem;
        background: var(--bg-white);
        padding: 0.75rem;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .settings-tab-item {
        flex: 1;
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.03);
        border: none;
        border-radius: 0.75rem;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .settings-tab-item:hover {
        background: rgba(31, 41, 51, 0.1);
        transform: translateY(-2px);
    }

    .settings-tab-item.active {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    /* Tab Content */
    .tab-content-wrapper {
        animation: fadeIn 1s ease-out;
    }

    .settings-tab-pane {
        display: none;
    }

    .settings-tab-pane.active {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    /* Detail Card */
    .detail-card {
        background: var(--bg-white) !important;
        border: 2px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
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

    /* Status Badges */
    .status-badge-unlock {
        background: #10B981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        display: inline-block;
    }

    .status-badge-lock {
        background: #F59E0B;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        display: inline-block;
    }

    /* Table Styling */
    .table-settings {
        margin-bottom: 0;
    }

    .table-settings thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-settings thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-settings tbody tr.category-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-settings tbody tr.category-row:hover {
        background: rgba(31, 41, 51, 0.05);
        transform: translateX(5px);
    }

    .table-settings tbody td {
        vertical-align: middle;
        padding: 1rem;
    }

    .badge-main-category {
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: 0.5rem;
        display: inline-block;
    }

    .category-description {
        color: var(--mg-muted);
        font-size: 0.9rem;
    }

    /* Price Input */
    .price-input-group {
        display: flex;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .price-prefix {
        background: var(--primary-color);
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .price-input {
        border: none;
        padding: 0.75rem 1rem;
        flex: 1;
        font-size: 1rem;
        font-weight: 600;
    }

    .price-input:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 0;
    }

    .price-input[readonly] {
        background: #f5f5f5;
        color: var(--mg-muted);
    }

    /* Form Elements */
    .form-label-custom {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-description {
        color: var(--mg-muted);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .textarea-custom {
        width: 100%;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .textarea-custom:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(31, 41, 51, 0.15);
    }

    .textarea-custom[readonly] {
        background: #f5f5f5;
        color: var(--mg-muted);
    }

    /* Days Grid */
    .days-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .day-checkbox-wrapper {
        position: relative;
    }

    .day-checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .day-label {
        display: block;
        background: rgba(0, 0, 0, 0.03);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        padding: 1rem;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .day-checkbox:checked + .day-label {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    .day-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Time Input */
    .time-input {
        width: 100%;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .time-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(31, 41, 51, 0.15);
    }

    .error-message {
        color: #DC2626;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid rgba(0, 0, 0, 0.05);
    }

    .btn-save {
        background: #10B981;
        color: white;
        border: 2px solid #10B981;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-save:hover:not(:disabled) {
        background: #FFFFFF;
        color: #10B981;
        border-color: #10B981;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-save:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-cancel {
        background: #FFFFFF;
        color: #DC2626;
        border: 2px solid #DC2626;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel:hover {
        background: #DC2626;
        color: #FFFFFF;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
    }

    .btn-back {
        background: #FFFFFF;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        background: #FFFFFF;
        color: #FACC15;
        border-color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.4);
    }

    /* Price History Section */
    .price-history-section {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .history-header h5 {
        margin: 0;
        color: var(--primary-color);
        font-weight: 700;
    }

    .btn-view-history {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-view-history:hover {
        background: #FFFFFF;
        color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 41, 51, 0.4);
    }

    /* History Table */
    .table-history {
        margin-bottom: 0;
    }

    .table-history thead tr {
        background: rgba(31, 41, 51, 0.1);
    }

    .table-history thead th {
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 0.75rem;
    }

    .table-history tbody tr.history-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-history tbody tr.history-row:hover {
        background: rgba(31, 41, 51, 0.05);
    }

    .table-history tbody td {
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    .price-old {
        color: #DC2626;
        font-weight: 600;
        text-decoration: line-through;
    }

    .price-new {
        color: #10B981;
        font-weight: 700;
    }

    /* Holiday Info */
    .holiday-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .holiday-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: rgba(239, 68, 68, 0.05);
        border-left: 4px solid #DC2626;
        border-radius: 0.5rem;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1rem !important;
        text-align: center;
    }

    .empty-state i {
        display: block;
        margin-bottom: 0.5rem;
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

        .tab-container {
            flex-direction: column;
        }

        .settings-tab-item {
            width: 100%;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-save,
        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .history-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-view-history {
            width: 100%;
            justify-content: center;
        }

        .floating-notifications {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: 100%;
        }

        .alert-floating {
            font-size: 0.9rem;
        }
    }
</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

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

// Tab Switching
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.settings-tab-item');
    const panes = document.querySelectorAll('.settings-tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-tab');

            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');

            // Hide all panes
            panes.forEach(p => p.classList.remove('active'));

            // Show target pane
            document.getElementById(target).classList.add('active');
        });
    });

    // Auto-refresh CSRF token setiap 30 menit
    setInterval(function() {
        fetch('{{ route('admin.dashboard') }}', {
            method: 'GET',
            credentials: 'same-origin'
        }).then(response => response.text())
          .then(html => {
              const parser = new DOMParser();
              const doc = parser.parseFromString(html, 'text/html');
              const newToken = doc.querySelector('meta[name="csrf-token"]');
              if (newToken) {
                  document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken.getAttribute('content'));
                  document.querySelectorAll('input[name="_token"]').forEach(input => {
                      input.value = newToken.getAttribute('content');
                  });
              }
          });
    }, 1800000);

    // Handle form submission with better error handling
    const forms = document.querySelectorAll('.settings-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-save');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }
        });
    });
});
</script>

@endsection

