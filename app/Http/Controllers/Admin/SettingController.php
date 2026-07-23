<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan form pengaturan sistem.
     */
    public function index()
    {
        // Load existing settings
        $settings = [
            'admin_whatsapp' => Setting::get('admin_whatsapp', '628123456789'),
            'admin_wa_text' => Setting::get('admin_wa_text', 'Halo Admin SIBENGKEL, saya butuh bantuan mengenai akun saya.'),
            'superadmin_wa_text' => Setting::get('superadmin_wa_text', 'Halo Super Admin SIBENGKEL, saya staf/mekanik butuh reset password akun.'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan.
     */
    public function update(Request $request)
    {
        $request->validate([
            'admin_whatsapp' => 'required|string|max:20',
            'admin_wa_text' => 'required|string',
            'superadmin_wa_text' => 'required|string',
        ]);

        $settingsToSave = $request->only(['admin_whatsapp', 'admin_wa_text', 'superadmin_wa_text']);

        foreach ($settingsToSave as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan Kontak Admin berhasil diperbarui.');
    }
}
