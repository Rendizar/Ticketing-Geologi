<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Tiket Khusus Ditolak</title>
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
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .alert-box {
            background: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .alert-box h3 {
            color: #dc2626;
            font-size: 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
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
        .reason-box {
            background: #fff9e6;
            border: 1px solid #facc15;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .reason-box h4 {
            color: #ca8a04;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .reason-box p {
            color: #713f12;
            line-height: 1.6;
            white-space: pre-wrap;
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
            margin-bottom: 10px;
            font-size: 16px;
        }
        .instructions ul {
            margin-left: 20px;
            color: #1e3a8a;
            line-height: 1.8;
        }
        .instructions li {
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
        .badge-rejected {
            background: #fecaca;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏛️ Museum Geologi Bandung</h1>
            <p>Notifikasi Permintaan Tiket Khusus</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert-box">
                <h3>
                    <span>⚠️</span>
                    Permintaan Tiket Khusus Anda Ditolak
                </h3>
                <p style="color: #7f1d1d; margin-top: 8px;">
                    Mohon maaf, permintaan tiket khusus Anda tidak dapat kami proses.
                </p>
            </div>

            <p style="color: #475569; line-height: 1.6; margin-bottom: 20px;">
                Halo <strong>{{ $specialRequest->nama }}</strong>,<br><br>
                Terima kasih atas minat Anda untuk mengunjungi Museum Geologi Bandung. 
                Setelah melakukan peninjauan, tim kami memutuskan untuk tidak dapat menyetujui 
                permintaan tiket khusus Anda dengan alasan berikut:
            </p>

            <!-- Reason Box -->
            <div class="reason-box">
                <h4>📋 Alasan Penolakan:</h4>
                <p>{{ $specialRequest->admin_note }}</p>
            </div>

            <!-- Request Details -->
            <div class="info-box">
                <h4 style="color: #1e293b; margin-bottom: 15px;">Detail Permintaan Anda:</h4>
                
                <div class="info-row">
                    <span class="info-label">ID Permintaan:</span>
                    <span class="info-value"><strong>{{ $specialRequest->request_id }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Kategori:</span>
                    <span class="info-value">
                        {{ \App\Models\SpecialTicketRequest::getKategoriLabel($specialRequest->kategori_khusus) }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Jumlah Pengunjung:</span>
                    <span class="info-value">{{ $specialRequest->jumlah_pengunjung }} orang</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Tanggal Kunjungan:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($specialRequest->tanggal_kunjungan)->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="badge badge-rejected">Ditolak</span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Ditinjau Pada:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($specialRequest->reviewed_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB</span>
                </div>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h4>💡 Langkah Selanjutnya:</h4>
                <ul>
                    <li>Anda dapat mengajukan permintaan tiket khusus yang baru dengan dokumen pendukung yang lebih lengkap</li>
                    <li>Pastikan dokumen yang diupload valid dan sesuai dengan kategori yang dipilih</li>
                    <li>Atau Anda dapat melakukan pemesanan tiket reguler melalui website kami</li>
                    <li>Untuk informasi lebih lanjut, hubungi customer service kami</li>
                </ul>
            </div>

            <p style="color: #475569; line-height: 1.6; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                Kami mengucapkan terima kasih atas pengertian Anda. Jika ada pertanyaan, 
                jangan ragu untuk menghubungi kami.
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
