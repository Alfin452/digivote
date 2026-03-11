<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlatformSetting;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua setting dan ubah menjadi format array [ 'key' => 'value' ]
        $settings = PlatformSetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'fee_percent' => 'required|numeric|min:0|max:100',
            'default_price_per_vote' => 'required|numeric|min:0',
            'xendit_webhook_secret' => 'nullable|string|max:255',
        ]);

        $keys = [
            'platform_name',
            'fee_percent',
            'default_price_per_vote',
            'xendit_webhook_secret'
        ];

        // Looping untuk update atau buat baru jika belum ada
        foreach ($keys as $key) {
            if ($request->has($key)) {
                PlatformSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->input($key)]
                );
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan Platform berhasil diperbarui!');
    }
}
