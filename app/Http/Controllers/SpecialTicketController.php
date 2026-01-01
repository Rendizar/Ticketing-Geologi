<?php

namespace App\Http\Controllers;

use App\Models\SpecialTicketRequest;
use App\Helpers\HolidayHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SpecialTicketController extends Controller
{
    /**
     * Show form for special ticket request
     */
    public function create()
    {
        $disabledDates = HolidayHelper::getDisabledDates();
        
        return view('special-tickets.create', compact('disabledDates'));
    }

    /**
     * Store special ticket request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'negara' => 'required|string',
            'provinsi' => 'nullable|string',
            'kategori_khusus' => 'required|in:lansia,disabilitas,panti_asuhan,peserta_diklat,tamu_negara,lainnya',
            'jumlah_pengunjung' => 'required|integer|min:1|max:100',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'keterangan' => $request->kategori_khusus === 'lainnya' ? 'required|string|max:1000' : 'nullable|string|max:1000',
            'bukti_dokumen' => 'required|file|mimes:pdf|max:5120', // Max 5MB
        ], [
            'bukti_dokumen.required' => 'Dokumen bukti wajib diupload',
            'bukti_dokumen.mimes' => 'Dokumen harus berformat PDF',
            'bukti_dokumen.max' => 'Ukuran file maksimal 5MB',
            'keterangan.required' => 'Keterangan wajib diisi untuk kategori Lainnya',
        ]);

        // Validasi tanggal kunjungan
        $tanggalKunjungan = Carbon::parse($request->tanggal_kunjungan);
        
        if (!HolidayHelper::canBookOnDate($tanggalKunjungan)) {
            $message = HolidayHelper::getBookingRestrictionMessage($tanggalKunjungan);
            return back()
                ->withInput()
                ->with('error', $message);
        }

        // Upload PDF
        $file = $request->file('bukti_dokumen');
        $filename = time() . '_' . Str::slug($request->nama) . '.pdf';
        $path = $file->storeAs('special-tickets', $filename, 'public');

        // Generate request ID
        $requestId = 'STR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        // Create request
        $specialRequest = SpecialTicketRequest::create([
            'request_id' => $requestId,
            'nama' => $request->nama,
            'email' => $request->email,
            'negara' => $request->negara,
            'provinsi' => $request->provinsi,
            'kategori_khusus' => $request->kategori_khusus,
            'jumlah_pengunjung' => $request->jumlah_pengunjung,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'keterangan' => $request->keterangan,
            'bukti_dokumen' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('special-tickets.success')
            ->with('request_id', $requestId);
    }

    /**
     * Success page
     */
    public function success()
    {
        $requestId = session('request_id');
        
        if (!$requestId) {
            return redirect()->route('home');
        }

        return view('special-tickets.success', compact('requestId'));
    }

    /**
     * Check status
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'request_id' => 'required|string'
        ]);

        $specialRequest = SpecialTicketRequest::where('request_id', $request->request_id)->first();

        if (!$specialRequest) {
            return back()->with('error', 'ID Permintaan tidak ditemukan');
        }

        return view('special-tickets.status', compact('specialRequest'));
    }
}

