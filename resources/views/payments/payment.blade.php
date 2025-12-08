{{-- resources/views/payments/payment.blade.php --}}
@extends('layouts.app')

@section('title', 'Pembayaran Tiket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card payment-card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header dengan gradient matching tema -->
                <div class="card-header text-center py-4 position-relative" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <div class="payment-icon-wrapper mb-3">
                        <i class="bi bi-credit-card-2-front-fill" style="font-size: 4rem; color: var(--mg-black); text-shadow: 0 4px 8px rgba(0,0,0,0.2);"></i>
                    </div>
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">
                        PEMBAYARAN TIKET
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5 text-center" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <!-- Order ID -->
                    <div class="order-info mb-4 p-4 rounded-3 shadow-sm" style="background: rgba(255, 255, 255, 0.9); border-left: 5px solid var(--mg-yellow);">
                        <div class="label text-muted mb-2" style="font-size: 0.9rem; font-weight: 600; letter-spacing: 0.5px;">
                            <i class="bi bi-hash me-1" style="color: var(--mg-yellow);"></i>NOMOR PESANAN
                        </div>
                        <div class="order-id fw-bold mb-3" style="color: var(--mg-black); font-size: 1.5rem; letter-spacing: 1px;">
                            {{ $orderId }}
                        </div>
                        
                        <!-- Total Pembayaran -->
                        <div class="divider my-3" style="height: 2px; background: linear-gradient(90deg, transparent, var(--mg-yellow), transparent);"></div>
                        
                        <div class="label text-muted mb-2" style="font-size: 0.9rem; font-weight: 600; letter-spacing: 0.5px;">
                            <i class="bi bi-wallet2 me-1" style="color: var(--mg-yellow);"></i>TOTAL PEMBAYARAN
                        </div>
                        <div class="total-amount fw-bold" style="color: var(--mg-black); font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">
                            Rp {{ number_format(session('pending_booking.calculated.total_harga')) }}
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button id="pay-button" class="btn btn-payment btn-lg w-100 mb-4 shadow-lg" style="border-radius: 50px; padding: 1.2rem 2rem; font-weight: 800; letter-spacing: 1.5px; position: relative; overflow: hidden;">
                        <span class="btn-text">
                            <i class="bi bi-lock-fill me-2"></i>BAYAR SEKARANG
                        </span>
                        <div class="btn-shine"></div>
                    </button>

                    <!-- Security Info -->
                    <div class="security-info p-3 rounded-3" style="background: rgba(40, 167, 69, 0.1); border: 2px dashed #28a745;">
                        <i class="bi bi-shield-fill-check me-2" style="color: #28a745; font-size: 1.2rem;"></i>
                        <small class="text-muted" style="font-weight: 600;">
                            Pembayaran aman & terenkripsi melalui <strong>Midtrans</strong>
                        </small>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="payment-methods mt-4 p-4 rounded-3 shadow-sm" style="background: rgba(255, 255, 255, 0.9);">
                        <div class="mb-3" style="color: var(--mg-black); font-weight: 700; font-size: 0.95rem;">
                            <i class="bi bi-credit-card me-2" style="color: var(--mg-yellow);"></i>METODE PEMBAYARAN TERSEDIA
                        </div>
                        <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                            <div class="payment-badge">
                                <i class="bi bi-credit-card-fill" style="color: #1a1a1a;"></i>
                                <small>Scan Q-RIS</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-bank" style="color: #1a1a1a;"></i>
                                <small>Bank Transfer</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-phone-fill" style="color: #1a1a1a;"></i>
                                <small>E-Wallet</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-shop" style="color: #1a1a1a;"></i>
                                <small>Credit Card</small>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="text-decoration-none" style="color: var(--mg-black); font-weight: 600; transition: all 0.3s ease;">
                            <i class="bi bi-arrow-left-circle me-1"></i>Kembali ke Konfirmasi
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
    :root { 
        --mg-yellow: #FFD400; 
        --mg-black: #0b0b0b; 
    }
    
    .payment-card {
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
    
    .payment-icon-wrapper {
        animation: cardFlip 1s ease-out;
    }
    
    @keyframes cardFlip {
        0% {
            transform: rotateY(0deg);
        }
        50% {
            transform: rotateY(180deg);
        }
        100% {
            transform: rotateY(360deg);
        }
    }
    
    .order-info {
        transition: all 0.3s ease;
    }
    
    .order-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 212, 0, 0.3) !important;
    }
    
    .total-amount {
        animation: amountPulse 2s infinite;
    }
    
    @keyframes amountPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .btn-payment {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: white !important;
        border: 3px solid #34ce57 !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .btn-payment::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-payment:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-payment:hover {
        background: linear-gradient(135deg, var(--mg-black) 0%, #1a1a1a 100%) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-yellow) !important;
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 20px 50px rgba(40, 167, 69, 0.5) !important;
    }
    
    .btn-payment:active {
        transform: translateY(-2px) scale(1.01);
    }
    
    .btn-text {
        position: relative;
        z-index: 1;
    }
    
    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 3s infinite;
    }
    
    @keyframes shine {
        0% {
            left: -100%;
        }
        50%, 100% {
            left: 100%;
        }
    }
    
    .security-info {
        animation: securityBlink 3s infinite;
    }
    
    @keyframes securityBlink {
        0%, 90%, 100% {
            opacity: 1;
        }
        95% {
            opacity: 0.7;
        }
    }
    
    .payment-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 212, 0, 0.1);
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .payment-badge:hover {
        background: var(--mg-yellow);
        border-color: var(--mg-black);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(255, 212, 0, 0.4);
    }
    
    .payment-badge i {
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .payment-badge:hover i {
        transform: scale(1.2);
    }
    
    .payment-badge small {
        font-weight: 600;
        color: var(--mg-black);
        font-size: 0.75rem;
    }
    
    .divider {
        animation: dividerGlow 2s infinite;
    }
    
    @keyframes dividerGlow {
        0%, 100% {
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
    }
    
    /* Loading State */
    .btn-payment.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-payment.loading .btn-text::after {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        margin-left: 8px;
        vertical-align: middle;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .payment-icon-wrapper i {
            font-size: 3rem !important;
        }
        
        .order-id {
            font-size: 1.2rem !important;
        }
        
        .total-amount {
            font-size: 2rem !important;
        }
        
        .btn-payment {
            font-size: 1rem;
            padding: 1rem 1.5rem !important;
        }
        
        .payment-methods {
            padding: 1.25rem !important;
        }
        
        .payment-badge {
            padding: 0.5rem 0.75rem;
        }
        
        .payment-badge i {
            font-size: 1.2rem;
        }
    }
    
    @media (max-width: 576px) {
        .order-id {
            font-size: 1rem !important;
            word-break: break-all;
        }
        
        .total-amount {
            font-size: 1.75rem !important;
        }
        
        .payment-badge small {
            font-size: 0.65rem;
        }
    }
</style>
@endsection

@section('scripts')
<!-- MIDTRANS SNAP SANDBOX -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ \Midtrans\Config::$clientKey }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const btnText = payButton.querySelector('.btn-text');
        const originalText = btnText.innerHTML;
        
        payButton.onclick = function () {
            // Validasi snapToken
            const snapToken = '{{ $snapToken }}';
            if (!snapToken) {
                alert('Token pembayaran tidak ditemukan! Silakan coba lagi.');
                return;
            }

            // Disable button dan tambah loading state
            payButton.classList.add('loading');
            btnText.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';

            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href = "/payment/finish?order_id={{ $orderId }}&transaction_status=settlement";
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = "/payment/finish?order_id={{ $orderId }}&transaction_status=pending";
                },
                onError: function(result) {
                    console.error('Payment error:', result);
                    alert('Pembayaran gagal! Silakan coba lagi.');
                    
                    // Reset button
                    payButton.classList.remove('loading');
                    btnText.innerHTML = originalText;
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    alert('Anda menutup jendela pembayaran tanpa menyelesaikan transaksi.');
                    
                    // Reset button
                    payButton.classList.remove('loading');
                    btnText.innerHTML = originalText;
                }
            });
        };
    });
</script>
@endsection