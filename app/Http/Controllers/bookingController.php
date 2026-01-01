<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facades\Pdf;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TicketCategory;
use App\Mail\TicketMail;
use App\Helpers\HolidayHelper;
use Carbon\Carbon;

class BookingController extends Controller
{
    // INI YANG HARUS ADA — METHOD CREATE!
    public function create()
    {
        // Ambil HANYA kategori tiket yang AKTIF dari database
        $categories = TicketCategory::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();
        
        // Get disabled dates untuk date picker (Jumat & libur nasional)
        $disabledDates = HolidayHelper::getDisabledDates();
        
        return view('visitor.create', compact('categories', 'disabledDates'));
    }
    public function store(Request $request)
    {
        // 1. VALIDASI
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'email'             => 'required|email',
            'negara'            => 'required|string',
            'jenis_pemesanan'   => 'required|in:individu,rombongan',
            'nama_rombongan'    => 'nullable|string',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'slot_waktu'        => 'nullable|string',
            'provinsi'          => 'nullable|string',
            'nomor_telepon'     => 'nullable|string',
        ]);

        // 1.1 VALIDASI TANGGAL KUNJUNGAN - Tidak boleh Jumat atau libur nasional
        $tanggalKunjungan = Carbon::parse($request->tanggal_kunjungan);
        
        if (!HolidayHelper::canBookOnDate($tanggalKunjungan)) {
            $message = HolidayHelper::getBookingRestrictionMessage($tanggalKunjungan);
            return back()
                ->withInput()
                ->with('error', $message);
        }

        // 1.2 CEK KAPASITAS HARIAN (MAKSIMAL 2500 PENGUNJUNG PER HARI)
        // Ini dicek dulu sebelum hitung detail, untuk early warning
        $dailyQuota = \App\Models\DailyVisitorQuota::getOrCreate($request->tanggal_kunjungan, 2500);

        // 2. HITUNG JUMLAH PENGUNJUNG
        $jumlah_pelajar = $jumlah_umum = $jumlah_asing = 0;
        $sub_tk = $sub_sd = $sub_smp = $sub_sma = $sub_kuliah = 0;

        if ($request->jenis_pemesanan === 'individu') {
            // NEW: Counter-based input untuk individu (1-19 orang)
            $sub_tk = (int)($request->sub_tk ?? 0);
            $sub_sd = (int)($request->sub_sd ?? 0);
            $sub_smp = (int)($request->sub_smp ?? 0);
            $sub_sma = (int)($request->sub_sma ?? 0);
            $sub_kuliah = (int)($request->sub_kuliah ?? 0);
            
            $jumlah_pelajar = $sub_tk + $sub_sd + $sub_smp + $sub_sma + $sub_kuliah;
            $jumlah_umum  = (int)($request->jumlah_umum ?? 0);
            $jumlah_asing = (int)($request->jumlah_asing ?? 0);
            
            // Validasi maksimal 19 untuk individu
            $totalIndividu = $jumlah_pelajar + $jumlah_umum + $jumlah_asing;
            if ($totalIndividu > 19) {
                return back()->withInput()->with('error', 'Individu maksimal 19 orang. Untuk ≥20 orang, gunakan jenis pemesanan Rombongan.');
            }
        } else {
            // Counter-based input untuk rombongan (≥20 orang)
            // Input rombongan menggunakan prefix 'rombongan_' untuk menghindari konflik
            $sub_tk = (int)($request->rombongan_sub_tk ?? 0);
            $sub_sd = (int)($request->rombongan_sub_sd ?? 0);
            $sub_smp = (int)($request->rombongan_sub_smp ?? 0);
            $sub_sma = (int)($request->rombongan_sub_sma ?? 0);
            $sub_kuliah = (int)($request->rombongan_sub_kuliah ?? 0);
            
            $jumlah_pelajar = $sub_tk + $sub_sd + $sub_smp + $sub_sma + $sub_kuliah;
            $jumlah_umum  = (int)($request->rombongan_jumlah_umum ?? 0);
            $jumlah_asing = (int)($request->rombongan_jumlah_asing ?? 0);
        }

        // 2.1 VALIDASI: Minimal 1 pengunjung
        $totalPengunjung = $jumlah_pelajar + $jumlah_umum + $jumlah_asing;
        if ($totalPengunjung <= 0) {
            return back()->withInput()->with('error', 'Gagal! Anda harus mengisi jumlah pengunjung minimal 1 orang.');
        }

        // 2.15 VALIDASI KAPASITAS HARIAN MAKSIMAL 2500 PENGUNJUNG
        if (!$dailyQuota->hasAvailableCapacity($totalPengunjung)) {
            $available = $dailyQuota->getAvailableSlots();
            return back()->withInput()->with('error', "Kapasitas kunjungan pada tanggal " . $tanggalKunjungan->format('d F Y') . " sudah penuh. Sisa kuota: {$available} orang. Silakan pilih tanggal lain.");
        }

        // 2.2 TENTUKAN JENIS PEMESANAN BERDASARKAN JUMLAH
        // Aturan Baru: Individu = 1-19 orang, Rombongan = ≥20 orang
        $jenisPemesananAktual = $totalPengunjung >= 20 ? 'rombongan' : 'individu';
        $namaRombongan = $totalPengunjung >= 20 ? ($request->nama_rombongan ?? null) : null;

        // 2.3 VALIDASI SLOT WAKTU UNTUK ROMBONGAN
        $slotWaktu = null;
        if ($jenisPemesananAktual === 'rombongan') {
            if (!$request->slot_waktu) {
                return back()->withInput()->with('error', 'Rombongan (≥20 orang) wajib memilih slot waktu kunjungan!');
            }
            $slotWaktu = $request->slot_waktu;
            
            // Check kuota slot waktu
            $quotaRecord = \App\Models\DailyGroupQuota::getOrCreate(
                $request->tanggal_kunjungan,
                $slotWaktu,
                500 // Default quota per slot
            );
            
            if (!$quotaRecord->isAvailable($totalPengunjung)) {
                $available = $quotaRecord->getAvailableSlots();
                return back()->withInput()->with('error', "Slot waktu {$slotWaktu} hanya tersisa kuota untuk {$available} orang. Silakan pilih slot waktu lain.");
            }
        }

        // 2.4 AMBIL HARGA DARI DATABASE (SNAPSHOT SAAT BOOKING) - HANYA YANG AKTIF
        $categories = TicketCategory::where('is_active', 1)->get()->keyBy('code');
        
        $hargaPelajar = $categories->get('pelajar')?->price ?? 0;
        $hargaUmum = $categories->get('umum')?->price ?? 0;
        $hargaAsing = $categories->get('asing')?->price ?? 0;
        
        // Hitung total dengan harga dinamis
        $total_harga = ($jumlah_pelajar * $hargaPelajar) + 
                       ($jumlah_umum * $hargaUmum) + 
                       ($jumlah_asing * $hargaAsing);

        if ($total_harga <= 0) {
            return back()->withInput()->with('error', 'Gagal menghitung harga. Minimal ada 1 pengunjung!');
        }

        // 3. SIMPAN SEMENTARA DI SESSION
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
                    'jenis_pemesanan_aktual' => $jenisPemesananAktual,
                    'nama_rombongan'  => $namaRombongan,
                    'slot_waktu'      => $slotWaktu,
                    'total_pengunjung' => $totalPengunjung,
                    // Snapshot harga saat booking dibuat
                    'harga_pelajar_saat_booking' => $hargaPelajar,
                    'harga_umum_saat_booking'    => $hargaUmum,
                    'harga_asing_saat_booking'   => $hargaAsing,
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

        // Check in regular bookings only (reschedule hanya untuk tiket reguler)
        $regularBooking = \App\Models\Booking::where('booking_id', $bookingId)
            ->orWhere('unique_key', $bookingId)
            ->first();

        if ($regularBooking) {
            // Check if paid and not past visit date
            if ($regularBooking->status !== 'paid') {
                return back()->with('error', 'Tiket belum dibayar atau sudah expired.');
            }
            
            $tanggalKunjungan = \Carbon\Carbon::parse($regularBooking->tanggal_kunjungan);
            $today = \Carbon\Carbon::today();
            
            if ($tanggalKunjungan->isPast()) {
                return back()->with('error', 'Tanggal kunjungan sudah lewat, tidak bisa reschedule.');
            }
            
            // Validasi H-2: Reschedule maksimal dilakukan 2 hari sebelum jadwal kunjungan
            if ($today->diffInDays($tanggalKunjungan, false) < 2) {
                return back()->with('error', 'Reschedule hanya dapat dilakukan maksimal H-2 dari jadwal kunjungan Anda.');
            }

            return redirect()->route('tickets.reschedule.edit', ['booking_id' => $regularBooking->booking_id, 'type' => 'regular']);
        }

        // Event bookings tidak bisa di-reschedule
        $eventBooking = \App\Models\EventBooking::where('booking_id', $bookingId)
            ->orWhere('unique_key', $bookingId)
            ->first();

        if ($eventBooking) {
            return back()->with('error', 'Tiket event tidak dapat di-reschedule. Fitur reschedule hanya tersedia untuk tiket reguler.');
        }

        return back()->with('error', 'ID Tiket tidak ditemukan.');
    }

    public function rescheduleEdit(Request $request, $booking_id)
    {
        // Reschedule hanya untuk tiket reguler
        $booking = \App\Models\Booking::where('booking_id', $booking_id)->firstOrFail();
        return view('visitor.reschedule.edit-regular', compact('booking'));
    }

    public function rescheduleUpdate(Request $request)
    {
        // Reschedule hanya untuk tiket reguler
        $request->validate([
            'booking_id' => 'required|exists:bookings,booking_id',
            'new_date' => 'required|date|after_or_equal:today'
        ]);

        $booking = \App\Models\Booking::where('booking_id', $request->booking_id)->firstOrFail();
        $oldDate = \Carbon\Carbon::parse($booking->tanggal_kunjungan);
        $newDate = \Carbon\Carbon::parse($request->new_date);
        
        // Validasi: Tanggal baru harus lebih lambat dari tanggal awal (hanya bisa mundur)
        if ($newDate->lte($oldDate)) {
            return back()->with('error', 'Reschedule hanya dapat dilakukan untuk memundurkan jadwal kunjungan. Tanggal baru harus lebih lambat dari tanggal awal.');
        }

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
        Mail::to($booking->email)->send(new \App\Mail\TicketMail($booking, $path));

        return redirect()->route('tickets.reschedule.form')
            ->with('success', 'Tanggal kunjungan berhasil diubah ke: ' . \Carbon\Carbon::parse($request->new_date)->format('d F Y') . '. Email konfirmasi telah dikirim.');
    }
}