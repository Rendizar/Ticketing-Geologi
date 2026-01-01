<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialTicketRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TicketMail;
use App\Mail\SpecialTicketRejectionMail;
use App\Mail\SpecialTicketApprovalMail;
use Carbon\Carbon;

class SpecialTicketAdminController extends Controller
{
    /**
     * Display list of special ticket requests
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = SpecialTicketRequest::with('admin')->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $requests = $query->paginate(20);
        $pendingCount = SpecialTicketRequest::where('status', 'pending')->count();
        
        return view('admin.special-tickets.index', compact('requests', 'status', 'pendingCount'));
    }

    /**
     * Show detail and review page
     */
    public function show($id)
    {
        $request = SpecialTicketRequest::with('admin')->findOrFail($id);
        
        return view('admin.special-tickets.show', compact('request'));
    }

    /**
     * Approve request and create booking
     */
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500'
        ]);

        $specialRequest = SpecialTicketRequest::findOrFail($id);

        if ($specialRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya');
        }

        // Generate booking ID
        $bookingId = 'BKG-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        $uniqueKey = Str::uuid();

        // Get special category (tiket khusus Rp 0)
        $specialCategory = TicketCategory::where('code', 'khusus')->first();
        $hargaKhusus = $specialCategory ? $specialCategory->price : 0;

        // Create booking
        $booking = Booking::create([
            'booking_id' => $bookingId,
            'unique_key' => $uniqueKey,
            'nama' => $specialRequest->nama,
            'email' => $specialRequest->email,
            'nomor_telepon' => '-', // Tidak diperlukan untuk tiket khusus
            'negara' => $specialRequest->negara,
            'provinsi' => $specialRequest->provinsi,
            'jenis_pemesanan' => 'individu',
            'tanggal_kunjungan' => $specialRequest->tanggal_kunjungan,
            
            // Tiket Khusus category
            'jumlah_pelajar' => 0,
            'jumlah_umum' => 0,
            'jumlah_asing' => 0,
            'sub_tk' => 0,
            'sub_sd' => 0,
            'sub_smp' => 0,
            'sub_sma' => 0,
            'sub_kuliah' => 0,
            
            // Snapshot harga
            'harga_pelajar_saat_booking' => 0,
            'harga_umum_saat_booking' => 0,
            'harga_asing_saat_booking' => 0,
            'total_pembayaran' => 0, // Gratis
            
            'status' => 'paid', // Auto paid karena gratis
            'kategori_khusus' => $specialRequest->kategori_khusus,
            'jumlah_tiket_khusus' => $specialRequest->jumlah_pengunjung,
        ]);

        // Create payment record
        Payment::create([
            'booking_id' => $bookingId,
            'jumlah_pembayaran' => 0,
            'status_pembayaran' => 'success',
            'metode_pembayaran' => 'special_ticket',
            'transaction_id' => 'SPEC-' . $bookingId,
        ]);

        // Update special request
        $specialRequest->update([
            'status' => 'approved',
            'reviewed_by' => session('admin_id'),
            'admin_note' => $request->admin_note,
            'reviewed_at' => now(),
            'booking_id' => $bookingId,
        ]);

        // Generate PDF ticket
        $pdf = Pdf::loadView('email.ticket', ['booking' => $booking]);
        $pdf->setPaper('A4', 'portrait');

        $directory = storage_path('app/public/tickets');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . "/{$bookingId}.pdf";
        $pdf->save($path);

        // Send approval email with ticket PDF
        try {
            Mail::to($specialRequest->email)->send(new SpecialTicketApprovalMail($specialRequest, $booking, $path));
        } catch (\Exception $e) {
            // Log error but continue
        }

        return redirect()->route('admin.special-tickets.index')
            ->with('success', 'Permintaan tiket khusus berhasil di-approve dan tiket telah dikirim ke email pengunjung');
    }

    /**
     * Reject request
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_note' => 'required|string|max:500'
        ], [
            'admin_note.required' => 'Alasan penolakan wajib diisi'
        ]);

        $specialRequest = SpecialTicketRequest::findOrFail($id);

        if ($specialRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya');
        }

        $specialRequest->update([
            'status' => 'rejected',
            'reviewed_by' => session('admin_id'),
            'admin_note' => $request->admin_note,
            'reviewed_at' => now(),
        ]);

        // Send rejection email notification
        try {
            Mail::to($specialRequest->email)->send(new SpecialTicketRejectionMail($specialRequest));
        } catch (\Exception $e) {
            // Log error but continue
        }

        return redirect()->route('admin.special-tickets.index')
            ->with('success', 'Permintaan tiket khusus berhasil ditolak dan notifikasi telah dikirim ke email pengunjung');
    }
}

