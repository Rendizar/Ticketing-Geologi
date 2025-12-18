<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facades\Pdf;

class BookingController extends Controller
{
    // INI YANG HARUS ADA — METHOD CREATE!
    public function create()
    {
        return view('visitor.create'); // atau 'tickets.create' kalau view-nya di folder tickets
    }
    public function store(Request $request)
    {
        // 1. VALIDASI (sama seperti sebelumnya)
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'email'             => 'required|email',
            'negara'            => 'required|string',
            'nomor_telepon'     => 'required|string|min:10|max:15',
            'jenis_pemesanan'   => 'required|in:individu,rombongan',
            'nama_rombongan'    => 'required_if:jenis_pemesanan,rombongan|nullable|string',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'kota_kabupaten'    => 'nullable|string',
            'provinsi'          => 'nullable|string',
        ]);

        // 2. HITUNG JUMLAH & HARGA (sama persis)
        $jumlah_pelajar = $jumlah_umum = $jumlah_asing = 0;
        $sub_tk = $sub_sd = $sub_smp = $sub_sma = $sub_kuliah = 0;

        if ($request->jenis_pemesanan === 'individu') {
            if ($request->kategori_individu === 'asing') {
                $jumlah_asing = 1;
            } elseif ($request->kategori_individu === 'umum') {
                if ($request->is_pelajar === 'pelajar' && $request->jenjang_pelajar) {
                    $jumlah_pelajar = 1;
                    ${$request->jenjang_pelajar} = 1;
                } else {
                    $jumlah_umum = 1;
                }
            }
        } else {
            $jumlah_pelajar = (int)($request->sub_tk ?? 0) + (int)($request->sub_sd ?? 0) +
                              (int)($request->sub_smp ?? 0) + (int)($request->sub_sma ?? 0) +
                              (int)($request->sub_kuliah ?? 0);
            $jumlah_umum  = (int)($request->jumlah_umum ?? 0);
            $jumlah_asing = (int)($request->jumlah_asing ?? 0);

            $sub_tk = (int)($request->sub_tk ?? 0);
            $sub_sd = (int)($request->sub_sd ?? 0);
            $sub_smp = (int)($request->sub_smp ?? 0);
            $sub_sma = (int)($request->sub_sma ?? 0);
            $sub_kuliah = (int)($request->sub_kuliah ?? 0);
        }

        $total_harga = ($jumlah_pelajar * 3000) + ($jumlah_umum * 5000) + ($jumlah_asing * 25000);

        if ($total_harga <= 0) {
            return back()->with('error', 'Minimal ada 1 pengunjung!');
        }

        // 3. SIMPAN SEMENTARA DI SESSION (INI YANG BARU!)
        session([
            'pending_booking' => [
                'form_data' => $request->except('_token'),
                'calculated' => [
                    'total_harga'     => $total_harga,
                    'jumlah_pelajar'  => $jumlah_pelajar,
                    'jumlah_umum'     => $jumlah_umum,
                    'jumlah_asing'    => $jumlah_asing,
                    'sub_tk'          => $sub_tk,
                    'sub_sd'          => $sub_sd,
                    'sub_smp'         => $sub_smp,
                    'sub_sma'         => $sub_sma,
                    'sub_kuliah'      => $sub_kuliah,
                ]
            ]
        ]);

        // 4. REDIRECT KE HALAMAN REVIEW PEMBAYARAN
        return redirect()->route('payment.review');
    }

    // Reschedule Methods
    public function rescheduleForm()
    {
        return view('visitor.reschedule.form');
    }

    public function rescheduleCheck(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|string'
        ]);

        $bookingId = $request->booking_id;

        // Check in regular bookings
        $regularBooking = \App\Models\Booking::where('booking_id', $bookingId)
            ->orWhere('unique_key', $bookingId)
            ->first();

        if ($regularBooking) {
            // Check if paid and not past visit date
            if ($regularBooking->status !== 'paid') {
                return back()->with('error', 'Tiket belum dibayar atau sudah expired.');
            }
            
            if (\Carbon\Carbon::parse($regularBooking->tanggal_kunjungan)->isPast()) {
                return back()->with('error', 'Tanggal kunjungan sudah lewat, tidak bisa reschedule.');
            }

            return redirect()->route('tickets.reschedule.edit', ['booking_id' => $regularBooking->booking_id, 'type' => 'regular']);
        }

        // Check in event bookings
        $eventBooking = \App\Models\EventBooking::where('booking_id', $bookingId)
            ->orWhere('unique_key', $bookingId)
            ->with('event')
            ->first();

        if ($eventBooking) {
            if ($eventBooking->payment_status !== 'paid') {
                return back()->with('error', 'Tiket event belum dibayar atau sudah expired.');
            }
            
            if (\Carbon\Carbon::parse($eventBooking->event->event_date)->isPast()) {
                return back()->with('error', 'Event sudah berlangsung, tidak bisa reschedule.');
            }

            return redirect()->route('tickets.reschedule.edit', ['booking_id' => $eventBooking->booking_id, 'type' => 'event']);
        }

        return back()->with('error', 'ID Tiket tidak ditemukan.');
    }

    public function rescheduleEdit(Request $request, $booking_id)
    {
        $type = $request->query('type', 'regular');

        if ($type === 'event') {
            $booking = \App\Models\EventBooking::where('booking_id', $booking_id)
                ->with('event')
                ->firstOrFail();
            
            // Get available events (exclude past events)
            $availableEvents = \App\Models\Event::where('is_active', true)
                ->where('event_date', '>=', now())
                ->orderBy('event_date', 'asc')
                ->get();

            return view('visitor.reschedule.edit-event', compact('booking', 'availableEvents'));
        } else {
            $booking = \App\Models\Booking::where('booking_id', $booking_id)->firstOrFail();
            return view('visitor.reschedule.edit-regular', compact('booking'));
        }
    }

    public function rescheduleUpdate(Request $request)
    {
        $type = $request->input('type');

        if ($type === 'event') {
            $request->validate([
                'booking_id' => 'required|exists:event_bookings,booking_id',
                'new_event_id' => 'required|exists:events,id'
            ]);

            $booking = \App\Models\EventBooking::where('booking_id', $request->booking_id)->firstOrFail();
            $oldEvent = $booking->event;
            $newEvent = \App\Models\Event::findOrFail($request->new_event_id);

            // Check if event is still active and in future
            if (!$newEvent->is_active || \Carbon\Carbon::parse($newEvent->event_date)->isPast()) {
                return back()->with('error', 'Event yang dipilih tidak tersedia.');
            }

            // Calculate price difference if any
            $oldTotal = $booking->total_harga;
            $newTotal = $newEvent->price * $booking->jumlah_tiket;
            $priceDiff = $newTotal - $oldTotal;

            if ($priceDiff > 0) {
                return back()->with('error', 'Event baru lebih mahal. Hubungi admin untuk upgrade.');
            }

            // Update booking
            $booking->event_id = $request->new_event_id;
            $booking->save();

            // Reload booking with new event
            $booking->load('event');

            // Generate new PDF ticket
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('email.event-ticket', ['eventBooking' => $booking]);
            $pdf->setPaper('A4', 'portrait');

            $directory = storage_path('app/public/tickets');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $path = $directory . "/{$booking->booking_id}.pdf";
            $pdf->save($path);

            // Send email with new ticket
            \Mail::to($booking->email)->send(new \App\Mail\TicketMail($booking, $path));

            return redirect()->route('tickets.reschedule.form')
                ->with('success', 'Tiket event berhasil di-reschedule ke: ' . $newEvent->title . '. Email konfirmasi telah dikirim.');

        } else {
            $request->validate([
                'booking_id' => 'required|exists:bookings,booking_id',
                'new_date' => 'required|date|after_or_equal:today'
            ]);

            $booking = \App\Models\Booking::where('booking_id', $request->booking_id)->firstOrFail();
            $oldDate = $booking->tanggal_kunjungan;

            // Update tanggal kunjungan
            $booking->tanggal_kunjungan = $request->new_date;
            $booking->save();

            // Generate new PDF ticket with updated date
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('email.ticket', ['booking' => $booking]);
            $pdf->setPaper('A4', 'portrait');

            $directory = storage_path('app/public/tickets');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $path = $directory . "/{$booking->booking_id}.pdf";
            $pdf->save($path);

            // Send email with new ticket
            \Mail::to($booking->email)->send(new \App\Mail\TicketMail($booking, $path));

            return redirect()->route('tickets.reschedule.form')
                ->with('success', 'Tanggal kunjungan berhasil diubah ke: ' . \Carbon\Carbon::parse($request->new_date)->format('d F Y') . '. Email konfirmasi telah dikirim.');
        }
    }
}