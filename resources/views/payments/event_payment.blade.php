@extends('layouts.app')

@section('title', 'Pembayaran Event Ticket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%); border: none;">
                    <div class="mb-3">
                        <i class="bi bi-credit-card-2-front-fill" style="font-size: 4rem; color: var(--mg-black);"></i>
                    </div>
                    <h3 class="mb-0 fw-bold" style="color: var(--mg-black); letter-spacing: 1px;">
                        PEMBAYARAN EVENT TICKET
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5 text-center">
                    <!-- Order ID -->
                    <div class="mb-4 p-4 rounded-3 shadow-sm" style="background: rgba(255, 212, 0, 0.1); border-left: 5px solid var(--mg-yellow);">
                        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 600;">
                            <i class="bi bi-hash me-1" style="color: var(--mg-yellow);"></i>NOMOR PESANAN
                        </div>
                        <div class="fw-bold mb-3" style="color: var(--mg-black); font-size: 1.5rem;">
                            {{ $orderId }}
                        </div>
                        
                        <hr>
                        
                        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 600;">
                            <i class="bi bi-wallet2 me-1" style="color: var(--mg-yellow);"></i>TOTAL PEMBAYARAN
                        </div>
                        <div class="fw-bold" style="color: var(--mg-black); font-size: 2.5rem;">
                            Rp {{ number_format(session('pending_event_booking.total_harga')) }}
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button id="pay-button" class="btn btn-lg w-100 mb-4 fw-bold shadow-lg" 
                        style="background: var(--mg-yellow); color: var(--mg-black); border: none; border-radius: 50px; padding: 1.2rem; cursor: pointer;"
                        onmouseover="this.style.background='#FFB300'" 
                        onmouseout="this.style.background='var(--mg-yellow)'">
                        <i class="bi bi-lock-fill me-2"></i>BAYAR SEKARANG
                    </button>

                    <!-- Security Info -->
                    <div class="p-3 rounded-3" style="background: rgba(40, 167, 69, 0.1); border: 2px dashed #28a745;">
                        <i class="bi bi-shield-fill-check me-2" style="color: #28a745; font-size: 1.2rem;"></i>
                        <small class="text-muted fw-bold">
                            Pembayaran aman & terenkripsi melalui <strong>Midtrans</strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap with Popup Mode -->
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
            payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Membuka...';
            
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("event.payment.finish") }}?order_id=' + orderId + '&transaction_status=settlement';
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran!');
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    payButton.innerHTML = '<i class="bi bi-lock-fill me-2"></i>BAYAR SEKARANG';
                },
                onClose: function() {
                    payButton.innerHTML = '<i class="bi bi-lock-fill me-2"></i>BAYAR SEKARANG';
                }
            });
        };
    });
</script>
@endsection
