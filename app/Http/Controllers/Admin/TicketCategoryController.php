<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Models\TicketPriceHistory;
use App\Helpers\HolidayHelper;
use Illuminate\Support\Str;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of ticket categories
     */
    public function index()
    {
        $categories = TicketCategory::orderBy('sort_order')->get();
        return view('admin.settings.ticket-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new ticket category
     */
    public function create()
    {
        return view('admin.settings.ticket-categories.create');
    }

    /**
     * Store a newly created ticket category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_categories,name',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $category = TicketCategory::create([
            'name' => $request->name,
            'code' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()
            ->route('admin.settings.ticket-categories.index')
            ->with('success', 'Kategori tiket berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified ticket category
     */
    public function edit($id)
    {
        $ticketCategory = TicketCategory::findOrFail($id);
        
        // Info untuk restriction
        $canUpdatePrice = HolidayHelper::canUpdatePrice();
        $updateRestrictionMessage = HolidayHelper::getUpdateRestrictionMessage();
        $holidayName = HolidayHelper::getHolidayName();
        
        return view('admin.settings.ticket-categories.edit', compact(
            'ticketCategory', 
            'canUpdatePrice', 
            'updateRestrictionMessage',
            'holidayName'
        ));
    }

    /**
     * Update the specified ticket category
     */
    public function update(Request $request, $id)
    {
        $ticketCategory = TicketCategory::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ticket_categories,name,' . $ticketCategory->id,
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'reason' => 'nullable|string|max:500'
        ]);

        $oldPrice = $ticketCategory->price;
        $newPrice = $request->price;

        // CEK: Apakah harga berubah?
        if ($oldPrice != $newPrice) {
            // VALIDASI: Hanya boleh ubah harga pada hari Jumat atau libur nasional
            if (!HolidayHelper::canUpdatePrice()) {
                return back()
                    ->withInput()
                    ->with('error', HolidayHelper::getUpdateRestrictionMessage());
            }
        }

        // Update kategori
        $ticketCategory->update([
            'name' => $request->name,
            'code' => Str::slug($request->name),
            'price' => $newPrice,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0
        ]);

        // Simpan history jika harga berubah
        if ($oldPrice != $newPrice) {
            TicketPriceHistory::create([
                'ticket_category_id' => $ticketCategory->id,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'changed_by' => session('admin_id', null),
                'reason' => $request->reason
            ]);
        }

        return redirect()
            ->route('admin.settings.ticket-categories.index')
            ->with('success', 'Kategori tiket berhasil diperbarui!');
    }

    /**
     * Remove the specified ticket category
     */
    public function destroy($id)
    {
        $ticketCategory = TicketCategory::findOrFail($id);
        $ticketCategory->delete();

        return redirect()
            ->route('admin.settings.ticket-categories.index')
            ->with('success', 'Kategori tiket berhasil dihapus!');
    }

    /**
     * Show price history for a ticket category
     */
    public function priceHistory($id)
    {
        $ticketCategory = TicketCategory::findOrFail($id);
        $history = $ticketCategory->priceHistory()
            ->with('admin')
            ->latest()
            ->get();

        return view('admin.settings.ticket-categories.history', compact('ticketCategory', 'history'));
    }
}

