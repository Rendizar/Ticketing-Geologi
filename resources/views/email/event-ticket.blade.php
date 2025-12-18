<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Event Museum Geologi - {{ $eventBooking->booking_id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; margin: 0; padding: 20px; background: #f0f0f0; }
        .ticket { max-width: 600px; margin: 40px auto; background: white; border: 6px solid #FFD700; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; padding: 40px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 38px; font-weight: bold; }
        .header p { margin: 10px 0 0; font-size: 20px; }
        .event-badge { background: #000; color: #FFD700; display: inline-block; padding: 8px 20px; border-radius: 25px; font-size: 16px; font-weight: bold; margin-top: 10px; }
        .content { padding: 40px; }
        .code { text-align: center; font-size: 32px; font-weight: bold; color: #FFA500; margin: 30px 0; letter-spacing: 5px; background: #FFF8DC; padding: 20px; border-radius: 15px; }
        .event-info { background: #FFE4B5; padding: 25px; border-radius: 15px; margin: 30px 0; border: 3px solid #FFD700; }
        .event-info h3 { margin: 0 0 15px 0; color: #FFA500; font-size: 24px; text-align: center; }
        .info { background: #f8fff8; padding: 25px; border-radius: 15px; margin: 30px 0; border: 3px dashed #006633; }
        .info table { width: 100%; }
        .info td { padding: 12px 0; font-size: 18px; }
        .info td:first-child { font-weight: bold; width: 40%; }
        .qr { text-align: center; margin: 40px 0; padding: 20px; background: #f8f9fa; border-radius: 15px; }
        .barcode { text-align: center; margin: 40px 0; font-family: 'Libre Barcode 128 Text', monospace; font-size: 70px; letter-spacing: 8px; color: #000; background: white; padding: 20px; border: 2px solid #FFD700; border-radius: 10px; }
        .footer { background: #000; color: #FFD700; text-align: center; padding: 30px; font-size: 16px; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
</head>
<body>
<div class="ticket">
    <div class="header">
        <h1>MUSEUM GEOLOGI BANDUNG</h1>
        <p>Tiket Event Spesial</p>
        <div class="event-badge">★ EVENT TICKET ★</div>
    </div>

    <div class="content">
        <div class="code">{{ $eventBooking->booking_id }}</div>

        <div class="event-info">
            <h3>{{ $eventBooking->event->title }}</h3>
            <table style="width:100%;">
                <tr><td style="padding:8px 0; font-size:16px;"><strong>📅 Tanggal Event</strong></td><td style="padding:8px 0; font-size:16px;">: {{ \Carbon\Carbon::parse($eventBooking->event->event_date)->format('d F Y') }}</td></tr>
                <tr><td style="padding:8px 0; font-size:16px;"><strong>🕐 Waktu Event</strong></td><td style="padding:8px 0; font-size:16px;">: {{ \Carbon\Carbon::parse($eventBooking->event->event_time)->format('H:i') }} WIB</td></tr>
                <tr><td style="padding:8px 0; font-size:16px;"><strong>📍 Lokasi</strong></td><td style="padding:8px 0; font-size:16px;">: {{ $eventBooking->event->location ?? 'Museum Geologi Bandung' }}</td></tr>
            </table>
        </div>

        <div class="info">
            <table>
                <tr><td>Nama Pemesan</td><td>: {{ $eventBooking->nama }}</td></tr>
                <tr><td>Email</td><td>: {{ $eventBooking->email }}</td></tr>
                <tr><td>Nomor Telepon</td><td>: {{ $eventBooking->nomor_telepon }}</td></tr>
                <tr><td>Negara</td><td>: {{ $eventBooking->negara }}</td></tr>
                <tr><td>Jenis Pemesanan</td><td>: {{ ucfirst($eventBooking->jenis_pemesanan) }} @if($eventBooking->nama_rombongan)- {{ $eventBooking->nama_rombongan }} @endif</td></tr>
                <tr><td>Kategori</td><td>: {{ ucfirst($eventBooking->kategori) }}</td></tr>
                <tr><td>Jumlah Tiket</td><td>: {{ $eventBooking->jumlah_tiket }} tiket</td></tr>
                <tr><td>Total Bayar</td><td>: <strong style="color:#FFA500;">Rp {{ number_format($eventBooking->total_harga, 0, ',', '.') }}</strong></td></tr>
            </table>
        </div>

        <!-- QR CODE -->
        <div class="qr">
            @php
                $qrcode = new \chillerlan\QRCode\QRCode;
                $data = $qrcode->render($eventBooking->booking_id);
            @endphp
            <img src="{{ $data }}" alt="QR Code" style="width:240px; height:240px;">
            <p style="margin-top:20px; color:#FFA500; font-size:18px;"><strong>Scan saat tiba di event</strong></p>
        </div>

        <!-- BARCODE -->
        <div class="barcode">
            *{{ $eventBooking->booking_id }}*
        </div>
    </div>

    <div class="footer">
        Tiket Event ini sah dan diterbitkan otomatis oleh sistem<br>
        Museum Geologi Bandung • museumgeologi@heritage.id • (022) 721 0000<br>
        Terima kasih telah mendaftar pada event kami!
    </div>
</div>
</body>
</html>
