@extends('layouts.app')

@section('title', 'Pembayaran Event Ticket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-5" style="background: #1F2933; border: none;">
                    <div class="mb-3">
                        <i class="fas fa-credit-card" style="font-size: 3.5rem; color: #10B981;"></i>
                    </div>
                    <h3 class="mb-0" style="font-family: 'Merriweather', serif; font-weight: 700; color: #ffffff; font-size: 1.75rem;" data-lang-key="event_payment_title">
                        Pembayaran Event Ticket
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5 text-center" style="background: #F9FAFB;">
                    <!-- Order ID -->
                    <div class="mb-4 p-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px;">
                        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 600; color: #6c6c6c;">
                            <i class="fas fa-hashtag me-1" style="color: #FACC15;"></i><span data-lang-key="event_payment_order_number">NOMOR PESANAN</span>
                        </div>
                        <div class="fw-bold mb-3" style="color: #1F2933; font-size: 1.5rem;">
                            {{ $orderId }}
                        </div>
                        
                        <hr style="border-color: #e5e7eb;">
                        
                        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 600; color: #6c6c6c;">
                            <i class="fas fa-wallet me-1" style="color: #FACC15;"></i><span data-lang-key="event_payment_total">TOTAL PEMBAYARAN</span>
                        </div>
                        <div class="fw-bold" style="color: #10B981; font-size: 2.5rem;">
                            Rp {{ number_format(session('pending_event_booking.total_harga')) }}
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button id="pay-button" class="btn btn-lg w-100 mb-4 fw-bold btn-pay-now" 
                        style="background: #10B981; color: #ffffff; border: 2px solid #10B981; border-radius: 12px; padding: 0.875rem 2rem; font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: 0.5px; cursor: pointer; transition: all 0.3s ease;">
                        <span data-lang-key="event_payment_pay_now">BAYAR SEKARANG</span>
                    </button>

                    <!-- Security Info -->
                    <div class="p-3" style="background: #d1fae5; border: 1px solid #86efac; border-radius: 12px;">
                        <i class="fas fa-shield-alt me-2" style="color: #10B981; font-size: 1.2rem;"></i>
                        <small class="fw-bold" style="color: #065f46;">
                            <span data-lang-key="event_payment_secure">Pembayaran aman & terenkripsi melalui</span> <strong>Midtrans</strong>
                        </small>
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
            <i class="fas fa-times"></i>
        </button>
        <div class="popup-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 class="popup-title" data-lang-key="event_payment_success_title">Pembayaran Berhasil!</h3>
        <p class="popup-message" data-lang-key="event_payment_success_message">Terima kasih, pembayaran Anda telah berhasil diproses. Silahkan cek email anda untuk tiketnya!</p>
        <div class="popup-timer">
            <span data-lang-key="event_payment_closing_in">Menutup dalam</span> <span id="popupTimer">10</span> <span data-lang-key="event_payment_seconds">detik...</span>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    var snapToken = '{{ $snapToken }}';
    var orderId = '{{ $orderId }}';
    
    window.addEventListener('load', function() {
        var payButton = document.getElementById('pay-button');
        if (!payButton) return;
        
        // Check if snap loaded, fallback to redirect if not
        if (typeof snap === 'undefined') {
            console.warn('Snap not loaded, using redirect fallback');
            payButton.onclick = function() {
                window.location.href = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' + snapToken;
            };
            return;
        }
        
        payButton.onclick = function() {
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuka...';
            
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    showSuccessPopup();
                    setTimeout(function() {
                        window.location.href = '{{ route("event.payment.finish") }}?order_id=' + orderId + '&transaction_status=settlement';
                    }, 10000);
                },
                onPending: function(result) {
                    window.location.href = '{{ route("event.payment.finish") }}?order_id=' + orderId + '&transaction_status=pending';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    payButton.innerHTML = 'BAYAR SEKARANG';
                },
                onClose: function() {
                    payButton.innerHTML = 'BAYAR SEKARANG';
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

<style>
    .btn-pay-now:hover {
        background: #1F2933 !important;
        color: #FACC15 !important;
        border-color: #1F2933 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(31, 41, 51, 0.4);
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
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
@endsection
