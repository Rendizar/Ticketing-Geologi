<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventBookingController extends Controller
{
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        
        // Check if event is still active and has capacity
        if (!$event->is_active) {
            return redirect()->route('home')->with('error', 'Event ini sudah tidak aktif.');
        }
        
        return view('event_bookings.create', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|min:10|max:15',
            'negara' => 'required|string',
            'kota_kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'jenis_pemesanan' => 'required|in:individu,rombongan',
            'nama_rombongan' => 'required_if:jenis_pemesanan,rombongan|nullable|string',
            // Fields untuk individu
            'kategori_individu' => 'nullable|string',
            'is_pelajar' => 'nullable|string',
            'jenjang_pelajar' => 'nullable|string',
            'jumlah_pelajar' => 'nullable|integer',
            'jumlah_umum' => 'nullable|integer',
            'jumlah_asing' => 'nullable|integer',
            // Fields untuk rombongan
            'sub_tk' => 'nullable|integer|min:0',
            'sub_sd' => 'nullable|integer|min:0',
            'sub_smp' => 'nullable|integer|min:0',
            'sub_sma' => 'nullable|integer|min:0',
            'sub_kuliah' => 'nullable|integer|min:0',
        ]);

        $event = Event::findOrFail($request->event_id);
        
        // Check event availability
        if (!$event->is_active) {
            return back()->with('error', 'Event ini sudah tidak aktif.');
        }

        // Calculate total tickets and determine category
        $jumlah_tiket = 0;
        $kategori = '';

        if ($request->jenis_pemesanan === 'individu') {
            $jumlah_tiket = 1; // Individu always 1 ticket
            
            // Determine category from the form logic
            if ($request->kategori_individu === 'asing' || $request->jumlah_asing > 0) {
                $kategori = 'asing';
            } elseif ($request->is_pelajar === 'pelajar' || $request->jumlah_pelajar > 0) {
                $kategori = 'pelajar';
            } elseif ($request->is_pelajar === 'bukan' || $request->jumlah_umum > 0) {
                $kategori = 'umum';
            }
        } else {
            // Rombongan - sum all tickets
            $jumlah_tiket = 
                ($request->sub_tk ?? 0) + 
                ($request->sub_sd ?? 0) + 
                ($request->sub_smp ?? 0) + 
                ($request->sub_sma ?? 0) + 
                ($request->sub_kuliah ?? 0) + 
                ($request->jumlah_umum ?? 0) + 
                ($request->jumlah_asing ?? 0);
            
            // Determine primary category (where most tickets are)
            $pelajar_total = ($request->sub_tk ?? 0) + ($request->sub_sd ?? 0) + 
                            ($request->sub_smp ?? 0) + ($request->sub_sma ?? 0) + ($request->sub_kuliah ?? 0);
            $umum_total = $request->jumlah_umum ?? 0;
            $asing_total = $request->jumlah_asing ?? 0;
            
            if ($pelajar_total >= $umum_total && $pelajar_total >= $asing_total) {
                $kategori = 'pelajar';
            } elseif ($umum_total >= $pelajar_total && $umum_total >= $asing_total) {
                $kategori = 'umum';
            } else {
                $kategori = 'asing';
            }
        }

        // Validate that at least 1 ticket is selected
        if ($jumlah_tiket < 1) {
            return back()->with('error', 'Silakan pilih minimal 1 tiket.')->withInput();
        }

        // Calculate total price
        $total_harga = $event->price * $jumlah_tiket;

        // Save to session for payment review
        session([
            'pending_event_booking' => [
                'event_id' => $event->id,
                'event_title' => $event->title,
                'event_date' => $event->event_date,
                'event_time' => $event->event_time,
                'nama' => $request->nama,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'negara' => $request->negara,
                'kota_kabupaten' => $request->kota_kabupaten,
                'provinsi' => $request->provinsi,
                'jenis_pemesanan' => $request->jenis_pemesanan,
                'nama_rombongan' => $request->nama_rombongan,
                'kategori' => $kategori,
                'jumlah_tiket' => $jumlah_tiket,
                'harga_satuan' => $event->price,
                'total_harga' => $total_harga,
                // Store breakdown for display
                'sub_tk' => $request->sub_tk ?? 0,
                'sub_sd' => $request->sub_sd ?? 0,
                'sub_smp' => $request->sub_smp ?? 0,
                'sub_sma' => $request->sub_sma ?? 0,
                'sub_kuliah' => $request->sub_kuliah ?? 0,
                'jumlah_umum' => $request->jumlah_umum ?? 0,
                'jumlah_asing' => $request->jumlah_asing ?? 0,
            ]
        ]);

        return redirect()->route('event.payment.review');
    }

    public function printTicket($booking_id)
    {
        $booking = EventBooking::where('booking_id', $booking_id)
            ->orWhere('unique_key', $booking_id)
            ->with('event')
            ->firstOrFail();

        if ($booking->payment_status !== 'paid') {
            return redirect()->route('home')->with('error', 'Tiket belum dibayar.');
        }

        return view('event_bookings.ticket', compact('booking'));
    }
}
