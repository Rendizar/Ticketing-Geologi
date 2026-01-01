{{-- resources/views/payments/payment.blade.php --}}
@extends('layouts.app')

@section('title', 'Pembayaran Tiket')

@section('page-title-key', 'payment_ticket_title')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card payment-card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header dengan tema Modern Geology -->
                <div class="card-header text-center py-4 position-relative" style="background: #1F2933; border: none;">
                    <div class="payment-icon-wrapper mb-3">
                        <i class="bi bi-credit-card-2-front-fill" style="font-size: 4rem; color: #FACC15;"></i>
                    </div>
                    <h3 class="mb-0" style="color: #ffffff; font-family: 'Merriweather', serif; font-weight: 700; letter-spacing: 0.5px;" data-lang-key="payment_ticket_title">
                        Pembayaran Tiket
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5 text-center" style="background: #F9FAFB;">
                    <!-- Order ID -->
                    <div class="order-info mb-4 p-4 rounded-3 shadow-sm" style="background: #ffffff; border-left: 4px solid #FACC15;">
                        <div class="label mb-2" style="font-size: 0.9rem; font-weight: 600; letter-spacing: 0.5px; color: #9CA3AF; font-family: 'Inter', sans-serif;">
                            <i class="bi bi-hash me-1" style="color: #9CA3AF;"></i><span data-lang-key="order_number">NOMOR PESANAN</span>
                        </div>
                        <div class="order-id fw-semibold mb-3" style="color: #1F2933; font-size: 1.5rem; letter-spacing: 1px; font-family: 'Inter', sans-serif;">
                            {{ $orderId }}
                        </div>
                        
                        <!-- Total Pembayaran -->
                        <div class="divider my-3" style="height: 1px; background: #E5E7EB;"></div>
                        
                        <div class="label mb-2" style="font-size: 0.9rem; font-weight: 600; letter-spacing: 0.5px; color: #9CA3AF; font-family: 'Inter', sans-serif;">
                            <i class="bi bi-wallet2 me-1" style="color: #9CA3AF;"></i><span data-lang-key="total_payment">TOTAL PEMBAYARAN</span>
                        </div>
                        <div class="total-amount" style="color: #FACC15; font-size: 2.5rem; font-weight: 700; font-family: 'Inter', sans-serif;">
                            Rp {{ number_format(session('pending_booking.calculated.total_harga')) }}
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button id="pay-button" class="btn btn-payment w-100 mb-4" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; position: relative; overflow: hidden;">
                        <span class="btn-text" data-lang-key="pay_now">
                            Bayar Sekarang
                        </span>
                    </button>

                    <!-- Security Info -->
                    <div class="security-info p-3 rounded-3" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10B981;">
                        <i class="bi bi-shield-fill-check me-2" style="color: #10B981; font-size: 1.2rem;"></i>
                        <small style="font-weight: 600; color: #1F2933; font-family: 'Inter', sans-serif;">
                            <span data-lang-key="payment_secure">Pembayaran aman & terenkripsi melalui</span> <strong>Midtrans</strong>
                        </small>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="payment-methods mt-4 p-4 rounded-3 shadow-sm" style="background: #ffffff;">
                        <div class="mb-3" style="color: #1F2933; font-weight: 600; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
                            <i class="bi bi-credit-card me-2" style="color: #1F2933;"></i><span data-lang-key="payment_methods_available">METODE PEMBAYARAN TERSEDIA</span>
                        </div>
                        <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                            <div class="payment-badge">
                                <i class="bi bi-credit-card-fill" style="color: #1F2933;"></i>
                                <small data-lang-key="scan_qris">Scan Q-RIS</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-bank" style="color: #1F2933;"></i>
                                <small data-lang-key="bank_transfer">Bank Transfer</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-phone-fill" style="color: #1F2933;"></i>
                                <small data-lang-key="e_wallet">E-Wallet</small>
                            </div>
                            <div class="payment-badge">
                                <i class="bi bi-shop" style="color: #1F2933;"></i>
                                <small data-lang-key="credit_card">Credit Card</small>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4 text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-back w-100" style="border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; text-decoration: none;">
                            <i class="fas fa-arrow-left me-2"></i><span data-lang-key="back_to_confirmation">Kembali ke Konfirmasi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Payment Popup -->
<div id="successPaymentPopup" class="payment-popup">
    <div class="payment-popup-content">
        <button class="popup-close-btn" onclick="closeSuccessPopup()">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="popup-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="popup-title">Pembayaran Berhasil!</h3>
        <p class="popup-message">Terima kasih, pembayaran Anda telah berhasil diproses. Silahkan cek email anda untuk tiketnya!</p>
        <div class="popup-timer">
            Menutup dalam <span id="popupTimer">10</span> detik...
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Modern Geology Theme */
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
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(250, 204, 21, 0.2);
    }
    
    .btn-payment {
        background: #10B981;
        color: white;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-payment:hover {
        background: #1F2933;
        color: #FACC15;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
    }
    
    .btn-payment:active {
        transform: translateY(0);
    }
    
    .btn-text {
        position: relative;
        z-index: 1;
    }
    
    .payment-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #F9FAFB;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #E5E7EB;
    }
    
    .payment-badge:hover {
        background: #FACC15;
        border-color: #FACC15;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(250, 204, 21, 0.3);
    }
    
    .payment-badge i {
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .payment-badge:hover i {
        transform: scale(1.1);
    }
    
    .payment-badge small {
        font-weight: 600;
        color: #1F2933;
        font-size: 0.75rem;
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
    
    /* Success Payment Popup */
    .payment-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-out;
    }
    
    .payment-popup.show {
        display: flex;
    }
    
    .payment-popup-content {
        background: #ffffff;
        border-radius: 20px;
        padding: 3rem 2.5rem;
        max-width: 450px;
        width: 90%;
        text-align: center;
        position: relative;
        animation: slideInUp 0.4s ease-out;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .popup-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: none;
        color: #9CA3AF;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .popup-close-btn:hover {
        background: #F9FAFB;
        color: #1F2933;
        transform: rotate(90deg);
    }
    
    .popup-icon {
        margin-bottom: 1.5rem;
    }
    
    .popup-icon i {
        font-size: 5rem;
        color: #10B981;
        animation: scaleIn 0.5s ease-out;
    }
    
    .popup-title {
        font-family: 'Merriweather', serif;
        font-weight: 700;
        color: #1F2933;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }
    
    .popup-message {
        font-family: 'Inter', sans-serif;
        color: #9CA3AF;
        font-size: 1rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .popup-timer {
        font-family: 'Inter', sans-serif;
        color: #1F2933;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        background: #F9FAFB;
        border-radius: 12px;
        display: inline-block;
    }
    
    .popup-timer span {
        color: #FACC15;
        font-weight: 700;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
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
<!-- Midtrans Snap with Popup Mode -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ \Midtrans\Config::$clientKey }}"></script>
<script type="text/javascript">
    var snapToken = '{{ $snapToken }}';
    var orderId = '{{ $orderId }}';
    
    window.addEventListener('load', function() {
        var payButton = document.getElementById('pay-button');
        if (!payButton) return;
        
        var btnText = payButton.querySelector('.btn-text');
        var originalText = btnText ? btnText.innerHTML : '';
        
        // Check if snap loaded, fallback to redirect if not
        if (typeof snap === 'undefined') {
            console.warn('Snap not loaded, using redirect fallback');
            payButton.onclick = function() {
                window.location.href = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' + snapToken;
            };
            return;
        }
        
        payButton.onclick = function() {
            if (btnText) {
                btnText.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Membuka...';
            }
            
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    showSuccessPopup();
                    setTimeout(function() {
                        window.location.href = '/payment/finish?order_id=' + orderId + '&transaction_status=settlement';
                    }, 10000);
                },
                onPending: function(result) {
                    window.location.href = '/payment/finish?order_id=' + orderId + '&transaction_status=pending';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    if (btnText) btnText.innerHTML = originalText;
                },
                onClose: function() {
                    if (btnText) btnText.innerHTML = originalText;
                }
            });
        };
    });
    
    // Success Popup Functions
    var countdownInterval;
    
    function showSuccessPopup() {
        var popup = document.getElementById('successPaymentPopup');
        var timerSpan = document.getElementById('popupTimer');
        var countdown = 10;
        
        popup.classList.add('show');
        
        countdownInterval = setInterval(function() {
            countdown--;
            timerSpan.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                closeSuccessPopup();
            }
        }, 1000);
    }
    
    function closeSuccessPopup() {
        var popup = document.getElementById('successPaymentPopup');
        popup.classList.remove('show');
        clearInterval(countdownInterval);
    }
</script>
@endsection