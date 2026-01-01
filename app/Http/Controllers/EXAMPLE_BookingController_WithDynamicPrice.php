<?php

/**
 * CONTOH IMPLEMENTASI: Cara Menggunakan Harga Dinamis
 * File ini BUKAN untuk dijalankan, hanya sebagai REFERENSI
 * 
 * Copy kode ini ke BookingController@store atau method serupa
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class BookingControllerExample extends Controller
{
    /**
     * Contoh implementasi dengan harga dinamis + snapshot
     */
    public function storeBooking(Request $request)
    {
        // LANGKAH 1: Ambil harga SAAT INI dari ticket_categories
        // Ini memastikan harga selalu up-to-date dari database
        $categories = TicketCategory::active()->get()->keyBy('code');
        
        $hargaPelajar = $categories->get('pelajar')?->price ?? 0;
        $hargaUmum = $categories->get('umum')?->price ?? 0;
        $hargaAsing = $categories->get('asing')?->price ?? 0;

        // LANGKAH 2: Hitung total berdasarkan harga saat ini
        $totalPembayaran = 
            ($request->jumlah_pelajar * $hargaPelajar) +
            ($request->jumlah_umum * $hargaUmum) +
            ($request->jumlah_asing * $hargaAsing);

        // LANGKAH 3: Generate booking ID
        $bookingId = 'BKG-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        // LANGKAH 4: Simpan booking dengan SNAPSHOT harga
        $booking = Booking::create([
            'booking_id' => $bookingId,
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'negara' => $request->negara,
            'jenis_pemesanan' => $request->jenis_pemesanan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            
            // Quantity
            'jumlah_pelajar' => $request->jumlah_pelajar ?? 0,
            'jumlah_umum' => $request->jumlah_umum ?? 0,
            'jumlah_asing' => $request->jumlah_asing ?? 0,
            
            // ⭐ SNAPSHOT HARGA - INI YANG PENTING!
            // Harga ini TIDAK AKAN BERUBAH walau admin update harga di ticket_categories
            'harga_pelajar_saat_booking' => $hargaPelajar,
            'harga_umum_saat_booking' => $hargaUmum,
            'harga_asing_saat_booking' => $hargaAsing,
            'total_pembayaran' => $totalPembayaran,
            
            'status' => 'pending',
            'unique_key' => \Illuminate\Support\Str::uuid(),
        ]);

        // LANGKAH 5: Simpan payment
        Payment::create([
            'booking_id' => $bookingId,
            'jumlah_pembayaran' => $totalPembayaran, // Gunakan total yang sama
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('payment.review', ['booking_id' => $bookingId]);
    }

    /**
     * Contoh menampilkan invoice/tiket dengan harga snapshot
     */
    public function printTicket($booking_id)
    {
        $booking = Booking::where('booking_id', $booking_id)->firstOrFail();

        // Gunakan harga SNAPSHOT, bukan harga current dari ticket_categories
        $data = [
            'booking' => $booking,
            'items' => []
        ];

        if ($booking->jumlah_pelajar > 0) {
            $data['items'][] = [
                'kategori' => 'Tiket Pelajar',
                'qty' => $booking->jumlah_pelajar,
                'harga' => $booking->harga_pelajar_saat_booking, // ← Snapshot
                'subtotal' => $booking->jumlah_pelajar * $booking->harga_pelajar_saat_booking
            ];
        }

        if ($booking->jumlah_umum > 0) {
            $data['items'][] = [
                'kategori' => 'Tiket Umum',
                'qty' => $booking->jumlah_umum,
                'harga' => $booking->harga_umum_saat_booking, // ← Snapshot
                'subtotal' => $booking->jumlah_umum * $booking->harga_umum_saat_booking
            ];
        }

        if ($booking->jumlah_asing > 0) {
            $data['items'][] = [
                'kategori' => 'Tiket Wisatawan Asing',
                'qty' => $booking->jumlah_asing,
                'harga' => $booking->harga_asing_saat_booking, // ← Snapshot
                'subtotal' => $booking->jumlah_asing * $booking->harga_asing_saat_booking
            ];
        }

        // Total = sum of all subtotals (atau langsung pakai $booking->total_pembayaran)
        $data['total'] = $booking->total_pembayaran;

        return view('booking.print-ticket', $data);
    }

    /**
     * Contoh laporan untuk membandingkan harga lama vs baru
     */
    public function reportPriceComparison()
    {
        $currentPrices = TicketCategory::active()->get()->keyBy('code');

        $bookings = Booking::with('payment')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) use ($currentPrices) {
                return [
                    'booking_id' => $booking->booking_id,
                    'nama' => $booking->nama,
                    'tanggal_booking' => $booking->created_at->format('d/m/Y'),
                    'tanggal_kunjungan' => $booking->tanggal_kunjungan,
                    
                    // Harga saat booking (snapshot)
                    'harga_pelajar_lama' => $booking->harga_pelajar_saat_booking,
                    'harga_umum_lama' => $booking->harga_umum_saat_booking,
                    'harga_asing_lama' => $booking->harga_asing_saat_booking,
                    
                    // Harga sekarang (current)
                    'harga_pelajar_sekarang' => $currentPrices->get('pelajar')?->price,
                    'harga_umum_sekarang' => $currentPrices->get('umum')?->price,
                    'harga_asing_sekarang' => $currentPrices->get('asing')?->price,
                    
                    // Selisih
                    'selisih_pelajar' => $currentPrices->get('pelajar')?->price - $booking->harga_pelajar_saat_booking,
                    
                    // Total yang dibayar (menggunakan harga lama)
                    'total_dibayar' => $booking->total_pembayaran,
                    
                    // Status
                    'status_harga' => $booking->harga_pelajar_saat_booking < $currentPrices->get('pelajar')?->price 
                        ? 'HEMAT (booking sebelum kenaikan)' 
                        : 'NORMAL',
                ];
            });

        return view('admin.reports.price-comparison', compact('bookings'));
    }
}
