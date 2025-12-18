<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\EventBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facades\Pdf;
use App\Mail\TicketMail;

class PaymentController extends Controller
{
    public function __construct()
    {
        // GANTI DENGAN SERVER KEY & CLIENT KEY SANDBOX KAMU!
        Config::$serverKey = 'Mid-server-Wl1N_wLcJbmSsa1I4pZBSGoe';
        Config::$clientKey = 'Mid-client-6Z0HFXjsFWq9AAA-';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function review()
    {
        if (!session('pending_booking')) {
            return redirect()->route('home')->with('error', 'Sesi telah habis. Silakan isi ulang form.');
        }
        return view('payments.review');
    }

    public function initiate(Request $request)
    {
        $pending = session('pending_booking');
        if (!$pending) {
            
        return redirect()->route('tickets.create')
                         ->with('error', 'Data pemesanan hilang!');
        }
        $orderId = 'TKT-' . now()->format('Ymd-His') . '-' . strtoupper(substr(Str::uuid(), 0, 8));

        $transaction = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $pending['calculated']['total_harga'],
            ],
            'customer_details' => [
                'first_name' => $pending['form_data']['nama'],
                'email'      => $pending['form_data']['email'],
                'phone'      => $pending['form_data']['nomor_telepon'],
            ],
            'item_details' => [[
                'id'       => 'TICKET',
                'price'    => $pending['calculated']['total_harga'],
                'quantity' => 1,
                'name'     => 'Tiket Masuk - ' . ucfirst($pending['form_data']['jenis_pemesanan']),
            ]],
            'callbacks' => [
                'finish' => url('/payment/finish?order_id=' . $orderId),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            session(['current_order_id' => $orderId]); // untuk callback

            return view('payments.payment', compact('snapToken', 'orderId'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        if (in_array($status, ['capture', 'settlement'])) {
            $this->processSuccessPayment($orderId);
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        if (in_array($status, ['capture', 'settlement'])) {
            $this->processSuccessPayment($orderId);
            session()->flush(); // bersihkan semua session
            return redirect()->route('home')->with('success', 'Pembayaran berhasil! Tiket telah dikirim ke email Anda.');
        }

        session()->flush();
        return redirect()->route('home')->with('error', 'Pembayaran gagal atau dibatalkan.');
    }

    private function processSuccessPayment($orderId)
    {
        // Cegah double save
        if (Booking::where('booking_id', $orderId)->exists()) return;

        $pending = session('pending_booking');
        $data = $pending['form_data'];
        $calc = $pending['calculated'];

        // Ambil detail transaksi dari Midtrans (WAJIB!)
        $transaction = \Midtrans\Transaction::status($orderId);

        // Mapping payment_type Midtrans ke bahasa Indonesia yang rapi
        $paymentType = $transaction->payment_type ?? 'unknown';
        $metode = 'Unknown';

        switch ($paymentType) {
            case 'credit_card':
                $metode = 'Kartu Kredit';
                break;
            case 'gopay':
                $metode = 'GoPay';
                break;
            case 'shopeepay':
                $metode = 'ShopeePay';
                break;
            case 'qris':
                $metode = 'QRIS';
                break;
            case 'bank_transfer':
                // BCA, BNI, BRI, Permata, dll
                $bank = $transaction->va_numbers[0]->bank ?? strtoupper($transaction->bank ?? 'bank_transfer');
                $metode = 'Transfer Bank ' . strtoupper($bank);
                break;
            case 'cstore':
                $store = $transaction->store ?? 'Convenience Store';
                $metode = 'Indomaret/Alfamart (' . $store . ')';
                break;
            case 'echannel':
                $metode = 'Mandiri Bill';
                break;
            case 'bca_klikpay':
            case 'bca_klikbca':
            case 'bri_epay':
            case 'danamon_online':
                $metode = strtoupper(str_replace('_', ' ', $paymentType));
                break;
            default:
                $metode = ucwords(str_replace('_', ' ', $paymentType));
        }

        // Simpan Booking
        $booking = Booking::create([
            'booking_id'        => $orderId,
            'nama'              => $data['nama'],
            'email'             => $data['email'],
            'nomor_telepon'     => $data['nomor_telepon'],
            'negara'            => $data['negara'],
            'jenis_pemesanan'   => $data['jenis_pemesanan'],
            'nama_rombongan'    => $data['nama_rombongan'] ?? null,
            'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            'kota_kabupaten'    => $data['kota_kabupaten'] ?? null,
            'provinsi'          => $data['provinsi'] ?? null,
            'jumlah_pelajar'    => $calc['jumlah_pelajar'],
            'jumlah_umum'       => $calc['jumlah_umum'],
            'jumlah_asing'      => $calc['jumlah_asing'],
            'sub_tk'            => $calc['sub_tk'],
            'sub_sd'            => $calc['sub_sd'],
            'sub_smp'           => $calc['sub_smp'],
            'sub_sma'           => $calc['sub_sma'],
            'sub_kuliah'        => $calc['sub_kuliah'],
            'status'            => 'paid',
            'unique_key'        => Str::uuid(),
        ]);

        // Simpan Payment dengan metode_pembayaran yang BENAR!
        Payment::create([
            'booking_id'        => $booking->booking_id,
            'transaction_id'    => $orderId,
            'jumlah_pembayaran' => $calc['total_harga'],
            'metode_pembayaran' => $metode,               // ← INI YANG BARU!
            'status_pembayaran' => 'success',
            'dibayarkan_pada'   => now(),
        ]);

        // === GENERATE PDF TIKET CANTIK ===
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('email.ticket', compact('booking'));
        $pdf->setPaper('A4', 'portrait');

        // Buat folder kalau belum ada
        $directory = storage_path('app/public/tickets');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . "/{$orderId}.pdf";
        $pdf->save($path);

        // === KIRIM EMAIL DENGAN LAMPIRAN PDF ===
        \Mail::to($booking->email)->send(new \App\Mail\TicketMail($booking, $path));
    }

    // Event Booking Payment Methods
    public function eventReview()
    {
        if (!session('pending_event_booking')) {
            return redirect()->route('home')->with('error', 'Sesi telah habis. Silakan isi ulang form.');
        }
        return view('payments.event_review');
    }

    public function eventInitiate(Request $request)
    {
        $pending = session('pending_event_booking');
        if (!$pending) {
            return redirect()->route('home')->with('error', 'Data pemesanan hilang!');
        }

        $orderId = 'EVT-' . now()->format('Ymd-His') . '-' . strtoupper(substr(Str::uuid(), 0, 8));

        $transaction = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $pending['total_harga'],
            ],
            'customer_details' => [
                'first_name' => $pending['nama'],
                'email'      => $pending['email'],
                'phone'      => $pending['nomor_telepon'],
            ],
            'item_details' => [[
                'id'       => 'EVENT_TICKET',
                'price'    => $pending['harga_satuan'],
                'quantity' => $pending['jumlah_tiket'],
                'name'     => 'Tiket Event: ' . $pending['event_title'],
            ]],
            'callbacks' => [
                'finish' => url('/event/payment/finish?order_id=' . $orderId),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            session(['current_event_order_id' => $orderId]);

            return view('payments.event_payment', compact('snapToken', 'orderId'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function eventFinish(Request $request)
    {
        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        if (in_array($status, ['capture', 'settlement'])) {
            $this->processEventSuccessPayment($orderId);
            session()->forget(['pending_event_booking', 'current_event_order_id']);
            return redirect()->route('home')->with('success', 'Pembayaran berhasil! Tiket event telah dikirim ke email Anda.');
        }

        session()->forget(['pending_event_booking', 'current_event_order_id']);
        return redirect()->route('home')->with('error', 'Pembayaran gagal atau dibatalkan.');
    }

    private function processEventSuccessPayment($orderId)
    {
        if (EventBooking::where('booking_id', $orderId)->exists()) return;

        $pending = session('pending_event_booking');

        $transaction = \Midtrans\Transaction::status($orderId);
        $paymentType = $transaction->payment_type ?? 'unknown';

        // Mapping payment type ke bahasa Indonesia
        $metode = match($paymentType) {
            'credit_card'   => 'Kartu Kredit',
            'bank_transfer' => 'Transfer Bank',
            'echannel'      => 'Mandiri Bill',
            'gopay'         => 'GoPay',
            'shopeepay'     => 'ShopeePay',
            default         => ucwords(str_replace('_', ' ', $paymentType)),
        };

        $eventBooking = EventBooking::create([
            'booking_id'        => $orderId,
            'event_id'          => $pending['event_id'],
            'nama'              => $pending['nama'],
            'email'             => $pending['email'],
            'nomor_telepon'     => $pending['nomor_telepon'],
            'negara'            => $pending['negara'],
            'kota_kabupaten'    => $pending['kota_kabupaten'] ?? null,
            'provinsi'          => $pending['provinsi'] ?? null,
            'jenis_pemesanan'   => $pending['jenis_pemesanan'],
            'nama_rombongan'    => $pending['nama_rombongan'] ?? null,
            'kategori'          => $pending['kategori'],
            'jumlah_tiket'      => $pending['jumlah_tiket'],
            'total_harga'       => $pending['total_harga'],
            'payment_type'      => $paymentType,
            'transaction_id'    => $orderId,
            'payment_status'    => 'paid',
            'unique_key'        => Str::uuid(),
        ]);

        // Simpan Payment record untuk EVENT
        Payment::create([
            'booking_id'        => null, // NULL karena ini event booking
            'event_booking_id'  => $eventBooking->booking_id, // ID dari event_bookings
            'booking_type'      => 'event', // Tandai sebagai event booking
            'transaction_id'    => $orderId,
            'jumlah_pembayaran' => $pending['total_harga'],
            'metode_pembayaran' => $metode,
            'status_pembayaran' => 'success',
            'dibayarkan_pada'   => now(),
        ]);

        // === GENERATE PDF TIKET EVENT ===
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('email.event-ticket', compact('eventBooking'));
        $pdf->setPaper('A4', 'portrait');

        // Buat folder kalau belum ada
        $directory = storage_path('app/public/tickets');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . "/{$orderId}.pdf";
        $pdf->save($path);

        // === KIRIM EMAIL DENGAN LAMPIRAN PDF ===
        \Mail::to($eventBooking->email)->send(new \App\Mail\TicketMail($eventBooking, $path));

        // === KURANGI AVAILABLE SLOTS EVENT ===
        $event = Event::find($pending['event_id']);
        if ($event) {
            $event->reduceSlots($pending['jumlah_tiket']);
        }
    }
}