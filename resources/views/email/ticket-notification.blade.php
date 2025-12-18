<h1>Terima kasih, {{ $booking->nama }}!</h1>
<p>Pembayaran tiket kunjungan Anda telah berhasil.</p>
<p><strong>ID Tiket:</strong> {{ $booking->booking_id }}</p>
<p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}</p>
<p>Tiket dalam format PDF terlampir. Silakan download dan tunjukkan saat tiba di museum.</p>
<br>
<p>Terima kasih,<br>Tim Museum Geologi Bandung</p>