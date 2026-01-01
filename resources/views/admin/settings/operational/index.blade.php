@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengaturan Operasional Museum</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengaturan Operasional</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-clock me-1"></i>
            Atur Hari & Jam Operasional
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.operational.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Hari Operasional</label>
                    <p class="text-muted small">Pilih hari-hari museum buka untuk kunjungan</p>
                    
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

                    <div class="row">
                        @foreach($allDays as $value => $label)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="operational_days[]" 
                                        value="{{ $value }}" 
                                        id="day_{{ $value }}"
                                        {{ in_array($value, $selectedDays) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="day_{{ $value }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('operational_days')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Hari Jumat dan tanggal merah (libur nasional) akan otomatis dinonaktifkan untuk pemesanan pengunjung, meskipun dipilih di sini.
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="opening_time" class="form-label fw-bold">Jam Buka</label>
                        <input 
                            type="time" 
                            class="form-control @error('opening_time') is-invalid @enderror" 
                            id="opening_time" 
                            name="opening_time" 
                            value="{{ old('opening_time', $openingTime) }}"
                            required
                        >
                        @error('opening_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="closing_time" class="form-label fw-bold">Jam Tutup</label>
                        <input 
                            type="time" 
                            class="form-control @error('closing_time') is-invalid @enderror" 
                            id="closing_time" 
                            name="closing_time" 
                            value="{{ old('closing_time', $closingTime) }}"
                            required
                        >
                        @error('closing_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pengaturan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <i class="fas fa-calendar-times me-1"></i>
            Informasi Hari Libur
        </div>
        <div class="card-body">
            <p class="mb-2"><strong>Hari yang tidak tersedia untuk booking:</strong></p>
            <ul>
                <li>Setiap hari <strong>Jumat</strong></li>
                <li><strong>Libur Nasional Indonesia</strong> (tanggal merah)</li>
            </ul>
            <p class="text-muted small mb-0">
                <i class="fas fa-lightbulb me-1"></i>
                Pengunjung tidak dapat memilih hari-hari tersebut saat melakukan pemesanan tiket, bahkan jika hari tersebut dicentang sebagai hari operasional.
            </p>
        </div>
    </div>
</div>
@endsection
