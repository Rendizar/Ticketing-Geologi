@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="mb-3">Permintaan Berhasil Dikirim!</h2>
                    <p class="text-muted mb-4">Permintaan tiket khusus Anda telah kami terima dan sedang dalam proses verifikasi.</p>
                    
                    <div class="alert alert-info">
                        <strong>ID Permintaan Anda:</strong><br>
                        <h4 class="mb-0 mt-2">{{ $requestId }}</h4>
                        <small class="text-muted">Simpan ID ini untuk mengecek status</small>
                    </div>

                    <p class="mb-4">Kami akan mengirimkan email konfirmasi setelah permintaan Anda di-review oleh admin.</p>

                    <div class="d-grid gap-2">
                        <a href="{{ route('home') }}" class="btn btn-back btn-lg w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn-back {
        background: #ffffff !important;
        color: #1F2933 !important;
        border: 2px solid #E5E7EB !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-back:hover {
        background: #1F2933 !important;
        color: #FACC15 !important;
        border-color: #1F2933 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4) !important;
    }
</style>
