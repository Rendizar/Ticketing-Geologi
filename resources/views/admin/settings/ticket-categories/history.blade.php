@extends('layouts.admin')
@section('title', 'Riwayat Perubahan Harga')
@section('content')
<div id="particles-js"></div>
<div class="container-fluid dashboard-content">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="brand-text mb-2">
                <i class="bi bi-clock-history me-3"></i>Riwayat Perubahan Harga
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Pengaturan</a></li>
                    <li class="breadcrumb-item active">Riwayat {{ $ticketCategory->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $ticketCategory->name }}</h3>
                    <p class="text-muted mb-3"><code>{{ $ticketCategory->code }}</code></p>
                    <div class="display-6 text-success mb-2">
                        Rp {{ number_format($ticketCategory->price, 0, ',', '.') }}
                    </div>
                    <small class="text-muted">Harga Saat Ini</small>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-graph-up me-2"></i>Statistik Perubahan
                    </h5>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <h4 class="mb-0">{{ $history->count() }}</h4>
                                <small class="text-muted">Total Perubahan</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <h4 class="mb-0">
                                    @if($history->first())
                                        Rp {{ number_format($history->first()->old_price, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <small class="text-muted">Harga Awal</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <h4 class="mb-0">
                                    @if($history->last())
                                        {{ $history->last()->created_at->diffForHumans() }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <small class="text-muted">Terakhir Diubah</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-list-ul me-2"></i>Detail Riwayat Perubahan
                    </h5>

                    @if($history->count() > 0)
                        <div class="timeline">
                            @foreach($history as $item)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <span class="badge bg-danger me-2">Rp {{ number_format($item->old_price, 0, ',', '.') }}</span>
                                                    <i class="bi bi-arrow-right mx-2"></i>
                                                    <span class="badge bg-success">Rp {{ number_format($item->new_price, 0, ',', '.') }}</span>
                                                </h6>
                                                @if($item->new_price > $item->old_price)
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-arrow-up"></i> Naik {{ number_format((($item->new_price - $item->old_price) / $item->old_price) * 100, 1) }}%
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-arrow-down"></i> Turun {{ number_format((($item->old_price - $item->new_price) / $item->old_price) * 100, 1) }}%
                                                    </span>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $item->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                        
                                        @if($item->reason)
                                            <div class="alert alert-light mb-2">
                                                <strong><i class="bi bi-chat-left-text me-1"></i>Alasan:</strong> {{ $item->reason }}
                                            </div>
                                        @endif

                                        @if($item->admin)
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>Diubah oleh: <strong>{{ $item->admin->name ?? 'Admin' }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted">Belum ada perubahan harga untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Pengaturan
            </a>
            <a href="{{ route('admin.settings.ticket-categories.edit', $ticketCategory->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Kategori
            </a>
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

/* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: 3px solid white;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.3);
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 3px solid #667eea;
}

.timeline-content h6 {
    color: #495057;
}
</style>
@endsection
