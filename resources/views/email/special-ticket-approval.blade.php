<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Tiket Khusus Disetujui</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .header .emoji {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .content {
            padding: 40px 30px;
        }
        .success-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .success-box h3 {
            color: #059669;
            font-size: 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .success-box p {
            color: #065f46;
            line-height: 1.6;
            margin-top: 8px;
        }
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
            width: 180px;
            flex-shrink: 0;
        }
        .info-value {
            color: #1e293b;
            flex: 1;
        }
        .ticket-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .ticket-box h3 {
            color: #92400e;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .ticket-box .ticket-icon {
            font-size: 64px;
            margin: 15px 0;
        }
        .ticket-box p {
            color: #78350f;
            line-height: 1.6;
            margin-top: 10px;
        }
        .ticket-box .booking-id {
            background: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            color: #92400e;
            font-size: 18px;
            margin: 15px 0;
            letter-spacing: 1px;
        }
        .instructions {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .instructions h4 {
            color: #1e40af;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .instructions ul {
            margin-left: 20px;
            color: #1e3a8a;
            line-height: 1.8;
        }
        .instructions li {
            margin-bottom: 10px;
        }
        .important-notes {
            background: #fef2f2;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .important-notes h4 {
            color: #dc2626;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .important-notes ul {
            margin-left: 20px;
            color: #991b1b;
            line-height: 1.8;
        }
        .important-notes li {
            margin-bottom: 8px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 5px 0;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-approved {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-free {
            background: #fef3c7;
            color: #92400e;
        }
        .greeting {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="emoji">🎉</div>
            <h1>Museum Geologi Bandung</h1>
            <p>Permintaan Tiket Khusus Anda Disetujui!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-box">
                <h3>
                    <span>✅</span>
                    Selamat! Permintaan Anda Telah Disetujui
                </h3>
                <p>
                    Tiket khusus Anda telah berhasil diproses dan siap digunakan. 
                    Silakan unduh tiket PDF yang terlampir pada email ini.
                </p>
            </div>

            <p class="greeting">
                Halo <strong>{{ $specialRequest->nama }}</strong>,<br><br>
                Terima kasih telah mengajukan permintaan tiket khusus untuk mengunjungi Museum Geologi Bandung. 
                Kami dengan senang hati mengabarkan bahwa permintaan Anda telah <strong>disetujui</strong>!
            </p>

            <!-- Ticket Info Box -->
            <div class="ticket-box">
                <h3>🎫 Tiket Anda Siap Digunakan</h3>
                <div class="ticket-icon">🎟️</div>
                <div class="booking-id">{{ $booking->booking_id }}</div>
                <p>
                    <span class="badge badge-free">GRATIS - Rp 0</span><br><br>
                    Tiket dalam format PDF telah terlampir pada email ini.<br>
                    Silakan unduh dan simpan untuk dibawa saat kunjungan.
                </p>
            </div>

            <!-- Booking Details -->
            <div class="info-box">
                <h4 style="color: #1e293b; margin-bottom: 15px;">📋 Detail Tiket Khusus Anda:</h4>
                
                <div class="info-row">
                    <span class="info-label">ID Booking:</span>
                    <span class="info-value"><strong>{{ $booking->booking_id }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">ID Permintaan:</span>
                    <span class="info-value">{{ $specialRequest->request_id }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Kategori Khusus:</span>
                    <span class="info-value">
                        <strong>{{ \App\Models\SpecialTicketRequest::getKategoriLabel($specialRequest->kategori_khusus) }}</strong>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Jumlah Pengunjung:</span>
                    <span class="info-value">{{ $specialRequest->jumlah_pengunjung }} orang</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Tanggal Kunjungan:</span>
                    <span class="info-value">
                        <strong>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->isoFormat('dddd, D MMMM YYYY') }}</strong>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Total Pembayaran:</span>
                    <span class="info-value">
                        <span class="badge badge-free">GRATIS - Rp 0</span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="badge badge-approved">Disetujui & Siap Digunakan</span>
                    </span>
                </div>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h4>📱 Cara Menggunakan Tiket:</h4>
                <ul>
                    <li><strong>Unduh PDF tiket</strong> yang terlampir pada email ini</li>
                    <li><strong>Simpan tiket</strong> di smartphone atau cetak untuk dibawa saat kunjungan</li>
                    <li><strong>Tunjukkan tiket</strong> kepada petugas di pintu masuk museum</li>
                    <li><strong>Scan QR Code</strong> pada tiket untuk verifikasi</li>
                    <li>Tiket berlaku untuk <strong>{{ $specialRequest->jumlah_pengunjung }} orang</strong></li>
                </ul>
            </div>

            <!-- Important Notes -->
            <div class="important-notes">
                <h4>⚠️ Informasi Penting:</h4>
                <ul>
                    <li>Tiket hanya berlaku pada tanggal yang tertera: <strong>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->isoFormat('D MMMM YYYY') }}</strong></li>
                    <li>Jam operasional museum: <strong>Senin-Kamis: 08:00-15:30 WIB, Sabtu-Minggu: 08:00-13:30 WIB</strong></li>
                    <li>Museum <strong>TUTUP setiap hari Jumat</strong> dan hari libur nasional</li>
                    <li>Harap datang <strong>tepat waktu</strong> sesuai tanggal kunjungan</li>
                    <li>Bawa <strong>identitas diri</strong> yang sesuai dengan kategori tiket khusus</li>
                    <li>Patuhi protokol dan tata tertib selama berada di museum</li>
                </ul>
            </div>

            @if($specialRequest->admin_note)
            <div class="info-box" style="background: #fefce8; border-color: #facc15;">
                <h4 style="color: #854d0e; margin-bottom: 10px;">💬 Catatan dari Admin:</h4>
                <p style="color: #713f12; line-height: 1.6; white-space: pre-wrap;">{{ $specialRequest->admin_note }}</p>
            </div>
            @endif

            <p style="color: #475569; line-height: 1.8; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                Terima kasih atas minat Anda untuk mengunjungi Museum Geologi Bandung. 
                Kami menantikan kunjungan Anda dan berharap Anda mendapatkan pengalaman edukatif yang menyenangkan!
            </p>

            <p style="color: #475569; margin-top: 20px;">
                Salam hangat,<br>
                <strong>Tim Museum Geologi Bandung</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Museum Geologi Bandung</strong></p>
            <p>Jl. Diponegoro No.57, Cibeunying Kaler, Kota Bandung, Jawa Barat 40122</p>
            <p>Email: info@museumgeologi.com | Telepon: (022) 7213822</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
