<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OperationalSetting;

class OperationalSettingController extends Controller
{
    /**
     * Show operational settings form
     */
    public function index()
    {
        $operationalDays = OperationalSetting::getSetting('operational_days', 'monday,tuesday,wednesday,thursday,saturday,sunday');
        $openingTime = OperationalSetting::getSetting('opening_time', '09:00');
        $closingTime = OperationalSetting::getSetting('closing_time', '16:00');

        return view('admin.settings.operational.index', compact('operationalDays', 'openingTime', 'closingTime'));
    }

    /**
     * Update operational settings
     */
    public function update(Request $request)
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
            ->route('admin.settings.operational.index')
            ->with('success', 'Pengaturan operasional berhasil diperbarui!');
    }
}
