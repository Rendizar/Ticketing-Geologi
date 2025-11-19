<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facades\Pdf;

class BookingController extends Controller {
    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|regex:/^\+62\d{9,12}$/',
            'jenis_pemesanan' => 'required|in:individu,rombongan',
            'nama_rombongan' => 'required_if:jenis_pemesanan,rombongan|string|nullable',
            'jumlah_pelajar' => 'integer|min:0',
            'sub_tk' => 'integer|min:0',
            // Validasi sub lainnya serupa...
            'jumlah_umum' => 'integer|min:0',
            'jumlah_asing' => 'integer|min:0',
            'tanggal_kunjungan' => 'required|date|after:today',
            'kota_kabupaten' => 'string|nullable',
            'kecamatan_provinsi' => 'string|nullable',
            'negara' => 'required|string',
        ]);

        // Kalkulasi total (di back-end)
        $total_pengunjung = $request->jumlah_pelajar + $request->jumlah_umum + $request->jumlah_asing;
        $total_harga = ($request->jumlah_pelajar * 3000) + ($request->jumlah_umum * 5000) + ($request->jumlah_asing * 25000);

        $booking = Booking::create($validated);

        // Buat payment record
        $payment = Payment::create([
            'booking_id' => $booking->booking_id,
            'jumlah_pembayaran' => $total_harga,
        ]);

        // Generate Snap token Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_id,
                'gross_amount' => $total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->nomor_telepon,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['snap_token' => $snapToken, 'booking_id' => $booking->booking_id]);
    }

    public function callback() {
        $notification = new Notification();

        $payment = Payment::where('transaction_id', $notification->order_id)->first();  // order_id = booking_id
        if ($payment) {
            $payment->transaction_id = $notification->transaction_id;
            $payment->metode_pembayaran = $notification->payment_type;
            $payment->status_pembayaran = ($notification->transaction_status == 'settlement') ? 'success' : 'failed';
            $payment->dibayarkan_pada = now();
            $payment->save();

            // Update booking status jika sukses
            if ($payment->status_pembayaran == 'success') {
                $booking = $payment->booking;
                // Generate unique key jika perlu
                $booking->update(['unique_key' => Str::uuid()]);
            }
        }

        return 'OK';
    }

    public function printTicket($booking_id) {
        $booking = Booking::findOrFail($booking_id);
        if ($booking->payment->status_pembayaran !== 'success') abort(403);

        $pdf = Pdf::loadView('tickets.show', compact('booking'));  // Asumsi view tickets/show.blade.php
        return $pdf->download('ticket.pdf');
    }
}
