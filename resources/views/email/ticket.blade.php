<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Museum Geologi - {{ $booking->booking_id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; margin: 0; padding: 20px; background: #f0f0f0; }
        .ticket { max-width: 600px; margin: 40px auto; background: white; border: 6px solid #006633; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #006633, #009966); color: white; padding: 40px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 38px; font-weight: bold; }
        .header p { margin: 10px 0 0; font-size: 20px; }
        .content { padding: 40px; }
        .code { text-align: center; font-size: 32px; font-weight: bold; color: #006633; margin: 30px 0; letter-spacing: 5px; background: #f0f8f0; padding: 20px; border-radius: 15px; }
        .info { background: #f8fff8; padding: 25px; border-radius: 15px; margin: 30px 0; border: 3px dashed #006633; }
        .info table { width: 100%; font...
        .info td { padding: 12px 0; font-size: 18px; }
        .info td:first-child { font-weight: bold; width: 40%; }
        .qr { text-align: center; margin: 40px 0; padding: 20px; background: #f8f9fa; border-radius: 15px; }
        .barcode { text-align: center; margin: 40px 0; font-family: 'Libre Barcode 128 Text', monospace; font-size: 70px; letter-spacing: 8px; color: #000; background: white; padding: 20px; border: 2px solid #006633; border-radius: 10px; }
        .footer { background: #006633; color: white; text-align: center; padding: 30px; font-size: 16px; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
</head>
<body>
<div class="ticket">
    <div class="header">
        <h1>MUSEUM GEOLOGI BANDUNG</h1>
        <p>Tiket Kunjungan Resmi</p>
    </div>

    <div class="content">
        <div class="code">{{ $booking->booking_id }}</div>

        <div class="info">
            <table>
                <tr><td>Nama Pemesan</td><td>: {{ $booking->nama }}</td></tr>
                <tr><td>Email</td><td>: {{ $booking->email }}</td></tr>
                <tr><td>Tanggal Kunjungan</td><td>: {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}</td></tr>
                <tr><td>Jenis Kunjungan</td><td>: {{ ucfirst($booking->jenis_pemesanan) }} @if($booking->nama_rombongan)- {{ $booking->nama_rombongan }} @endif</td></tr>
                <tr><td>Total Pengunjung</td><td>: {{ $booking->jumlah_pelajar + $booking->jumlah_umum + $booking->jumlah_asing }} orang</td></tr>
                <tr><td>Total Bayar</td><td>: <strong>Rp {{ number_format($booking->jumlah_pelajar * 3000 + $booking->jumlah_umum * 5000 + $booking->jumlah_asing * 25000) }}</strong></td></tr>
            </table>
        </div>

        <!-- QR CODE PASTI JALAN 100% -->
        <div class="qr">
            @php
                $qrcode = new \chillerlan\QRCode\QRCode;
                $data = $qrcode->render($booking->booking_id);
            @endphp
            <img src="{{ $data }}" alt="QR Code" style="width:240px; height:240px;">
            <p style="margin-top:20px; color:#006633; font-size:18px;"><strong>Scan saat tiba di museum</strong></p>
        </div>

        <!-- BARCODE CANTIK -->
        <div class="barcode">
            *{{ $booking->booking_id }}*
        </div>
    </div>

    <div class="footer">
        Tiket ini sah dan diterbitkan otomatis oleh sistem<br>
        Museum Geologi Bandung • museumgeologi@heritage.id • (022) 721 0000<br>
        Terima kasih atas kunjungan Anda!
    </div>
</div>
</body>
</html>