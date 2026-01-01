@extends('layouts.admin')
@section('title', 'Edit Kategori Tiket')
@section('content')
<div id="particles-js"></div>
<div class="container-fluid dashboard-content">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="brand-text mb-2">
                <i class="bi bi-pencil-square me-3"></i>Edit Kategori Tiket
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.ticket-categories.index') }}">Pengaturan Tiket</a></li>
                    <li class="breadcrumb-item active">Edit {{ $ticketCategory->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Error Messages --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading"><i class="bi bi-exclamation-octagon me-2"></i>Tidak Dapat Mengubah Harga</h5>
                    <p class="mb-0">{{ session('error') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Info Hari Ini --}}
            @if($canUpdatePrice)
                @if($holidayName)
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Hari ini {{ $holidayName }}.</strong> Anda dapat mengubah harga tiket.
                    </div>
                @else
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Hari ini hari Jumat.</strong> Anda dapat mengubah harga tiket.
                    </div>
                @endif
            @else
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Perhatian:</strong> {{ $updateRestrictionMessage }}
                    <br><small class="text-muted">Anda tetap bisa mengubah informasi lain (nama, deskripsi, status), namun perubahan harga akan ditolak.</small>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.ticket-categories.update', $ticketCategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $ticketCategory->name) }}" 
                                   placeholder="Contoh: Pelajar SD"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">
                                Harga Tiket (Rp) <span class="text-danger">*</span>
                                @if(!$canUpdatePrice)
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="bi bi-lock"></i> Terkunci
                                    </span>
                                @endif
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror {{ !$canUpdatePrice ? 'bg-light' : '' }}" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $ticketCategory->price) }}" 
                                       min="0"
                                       step="1000"
                                       placeholder="10000"
                                       required
                                       @if(!$canUpdatePrice) readonly @endif>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if(!$canUpdatePrice)
                                <small class="text-danger">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Harga hanya dapat diubah pada hari Jumat atau hari libur nasional.
                                </small>
                            @endif
                            @if($ticketCategory->price != old('price', $ticketCategory->price))
                                <div class="alert alert-warning mt-2" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Harga akan berubah dari <strong>Rp {{ number_format($ticketCategory->price, 0, ',', '.') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3" id="reasonField" style="display: none;">
                            <label for="reason" class="form-label">Alasan Perubahan Harga</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" 
                                      name="reason" 
                                      rows="2"
                                      placeholder="Jelaskan alasan perubahan harga (opsional)">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Deskripsi singkat tentang kategori ini (opsional)">{{ old('description', $ticketCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Urutan Tampilan</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $ticketCategory->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Semakin kecil angka, semakin atas urutannya.</small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active"
                                       {{ old('is_active', $ticketCategory->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan kategori ini
                                </label>
                            </div>
                            <small class="form-text text-muted">Kategori yang tidak aktif tidak akan muncul di form pemesanan.</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.settings.ticket-categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi History -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Informasi
                    </h5>
                    <ul class="mb-0">
                        <li>Perubahan harga akan dicatat dalam riwayat perubahan harga.</li>
                        <li>Harga lama pada transaksi yang sudah ada tidak akan berubah.</li>
                        <li>Lihat <a href="{{ route('admin.settings.ticket-categories.history', $ticketCategory->id) }}">riwayat perubahan harga</a> untuk kategori ini.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-content {
    position: relative;
    z-index: 1;
    padding: 30px;
}

#particles-js {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
}

.brand-text {
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card {
    border: none;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');
    const reasonField = document.getElementById('reasonField');
    const originalPrice = {{ $ticketCategory->price }};

    priceInput.addEventListener('input', function() {
        if (parseFloat(this.value) !== originalPrice) {
            reasonField.style.display = 'block';
        } else {
            reasonField.style.display = 'none';
        }
    });

    // Check on load
    if (parseFloat(priceInput.value) !== originalPrice) {
        reasonField.style.display = 'block';
    }
});
</script>
@endsection
