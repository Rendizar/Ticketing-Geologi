@extends('layouts.admin')
@section('title', 'Pengaturan Harga Tiket')
@section('content')
<div id="particles-js"></div>
<div class="container-fluid dashboard-content">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="brand-text mb-2">
                        <i class="bi bi-gear-fill me-3"></i>Pengaturan Harga Tiket
                    </h1>
                    <p class="subtitle-text">Kelola kategori dan harga tiket secara dinamis</p>
                </div>
                <a href="{{ route('admin.settings.ticket-categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Nama Kategori</th>
                                    <th width="15%">Kode</th>
                                    <th width="15%">Harga</th>
                                    <th width="20%">Deskripsi</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Urutan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>
                                            <code>{{ $category->code }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                Rp {{ number_format($category->price, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $category->description ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-x-circle me-1"></i>Non-Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->sort_order }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.settings.ticket-categories.edit', $category->id) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('admin.settings.ticket-categories.history', $category->id) }}" 
                                                   class="btn btn-outline-info" 
                                                   title="Riwayat Harga">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>
                                                <form action="{{ route('admin.settings.ticket-categories.destroy', $category->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                <p>Belum ada kategori tiket.</p>
                                                <a href="{{ route('admin.settings.ticket-categories.create') }}" class="btn btn-primary mt-2">
                                                    <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Pertama
                                                </a>
                                            </div>
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

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-info">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Informasi Penting
                    </h5>
                    <ul class="mb-0">
                        <li>Perubahan harga akan tercatat dalam riwayat dan tidak akan mempengaruhi transaksi yang sudah ada.</li>
                        <li>Kategori yang dinonaktifkan tidak akan muncul di form pemesanan.</li>
                        <li>Urutan tampilan menentukan urutan kategori di halaman pemesanan (semakin kecil, semakin atas).</li>
                        <li>Kode kategori akan otomatis dibuat dari nama kategori (lowercase dan tanpa spasi).</li>
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

.subtitle-text {
    color: #6c757d;
    font-size: 1rem;
}

.card {
    border: none;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endsection
