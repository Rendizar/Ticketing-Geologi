<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Models\TicketPriceHistory;
use App\Models\OperationalSetting;
use App\Helpers\HolidayHelper;

class SettingsController extends Controller
{
    /**
     * Show unified settings page
     */
    public function index()
    {
        // Kategori tiket
        $categories = TicketCategory::orderBy('sort_order')->get();
        
        // Riwayat perubahan harga terakhir (5 terakhir)
        $recentHistory = TicketPriceHistory::with(['ticketCategory', 'admin'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Operational settings
        $operationalDays = OperationalSetting::getSetting('operational_days', 'monday,tuesday,wednesday,thursday,saturday,sunday');
        $openingTime = OperationalSetting::getSetting('opening_time', '09:00');
        $closingTime = OperationalSetting::getSetting('closing_time', '16:00');
        
        return view('admin.settings.index', compact(
            'categories',
            'recentHistory',
            'operationalDays',
            'openingTime',
            'closingTime'
        ));
    }

    /**
     * Update ticket prices
     */
    public function updatePrices(Request $request)
    {
        $request->validate([
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:500'
        ]);

        $adminId = session('admin_id', null);
        $updatedCount = 0;

        foreach ($request->prices as $categoryId => $newPrice) {
            $category = TicketCategory::find($categoryId);
            
            if (!$category) continue;

            $oldPrice = $category->price;

            // Cek apakah harga berubah
            if ($oldPrice != $newPrice) {
                // VALIDASI: Hanya boleh ubah harga pada hari Jumat atau libur nasional
                if (!HolidayHelper::canUpdatePrice()) {
                    return back()
                        ->withInput()
                        ->with('error', HolidayHelper::getUpdateRestrictionMessage());
                }

                // Update harga
                $category->update(['price' => $newPrice]);

                // Simpan history
                TicketPriceHistory::create([
                    'ticket_category_id' => $category->id,
                    'old_price' => $oldPrice,
                    'new_price' => $newPrice,
                    'changed_by' => $adminId,
                    'reason' => $request->reason
                ]);

                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            return redirect()
                ->route('admin.settings.index')
                ->with('success', "Berhasil memperbarui {$updatedCount} kategori harga tiket!");
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('info', 'Tidak ada perubahan harga yang dilakukan.');
    }

    /**
     * Update operational settings
     */
    public function updateOperational(Request $request)
    {
        $request->validate([
            'operational_days' => 'required|array|min:1',
            'operational_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
        ], [
            'operational_days.required' => 'Pilih minimal 1 hari operasional',
            'operational_days.min' => 'Pilih minimal 1 hari operasional',
            'closing_time.after' => 'Jam tutup harus lebih dari jam buka'
        ]);

        // Simpan operational days
        OperationalSetting::setSetting(
            'operational_days',
            implode(',', $request->operational_days),
            'Hari-hari museum buka untuk kunjungan'
        );

        // Simpan opening time
        OperationalSetting::setSetting(
            'opening_time',
            $request->opening_time,
            'Jam buka museum'
        );

        // Simpan closing time
        OperationalSetting::setSetting(
            'closing_time',
            $request->closing_time,
            'Jam tutup museum'
        );

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan operasional berhasil diperbarui!');
    }

    /**
     * Show all price history for all categories
     */
    public function allPriceHistory()
    {
        $priceHistory = TicketPriceHistory::with(['ticketCategory', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.settings.all-price-history', compact('priceHistory'));
    }
}
