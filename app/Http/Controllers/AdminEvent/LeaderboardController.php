<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;

class LeaderboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        if (!$event) {
            abort(404, 'Event tidak ditemukan.');
        }

        // Ambil semua kandidat beserta nama kategorinya, urutkan dari suara terbanyak
        $teams = Team::with('category')
            ->where('event_id', $event->id)
            ->orderByDesc('vote_count')
            ->get();

        return view('admin-event.leaderboard', compact('event', 'admin', 'teams'));
    }

    public function create()
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        // Ambil data kategori milik event ini untuk pilihan di dropdown form
        $categories = \App\Models\Category::where('event_id', $event->id)->get();

        return view('admin-event.create-team', compact('event', 'admin', 'categories'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        // 1. Validasi Input
        $request->validate([
            'number' => 'required|string|max:5',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
        ], [
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        // Cek apakah nomor urut sudah dipakai di event ini
        $exists = \App\Models\Team::where('event_id', $event->id)->where('number', $request->number)->exists();
        if ($exists) {
            return back()->withErrors(['number' => 'Nomor urut/peserta ini sudah digunakan.'])->withInput();
        }

        // 2. Proses Upload Gambar (Jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teams', 'public');
        }

        // 3. Simpan ke Database
        \App\Models\Team::create([
            'event_id' => $event->id,
            'category_id' => $request->category_id,
            'number' => $request->number,
            'name' => $request->name,
            'location' => $request->location,
            'image_path' => $imagePath,
            'vote_count' => 0,
        ]);

        // 4. Hapus Cache Publik agar peserta baru langsung muncul di halaman depan
        \Illuminate\Support\Facades\Cache::forget('teams_' . $event->id);

        return redirect()->route('admin-event.leaderboard')->with('success', 'Kandidat/Peserta berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        // Cari kandidat berdasarkan ID, dan pastikan kandidat itu milik event ini
        $team = \App\Models\Team::where('id', $id)->where('event_id', $event->id)->firstOrFail();
        $categories = \App\Models\Category::where('event_id', $event->id)->get();

        return view('admin-event.edit-team', compact('event', 'admin', 'team', 'categories'));
    }

    // Memproses update data
    public function update(Request $request, $id)
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;
        $team = \App\Models\Team::where('id', $id)->where('event_id', $event->id)->firstOrFail();

        $request->validate([
            'number' => 'required|string|max:5',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek apakah nomor urut sudah dipakai oleh KANDIDAT LAIN di event ini
        $exists = \App\Models\Team::where('event_id', $event->id)
            ->where('number', $request->number)
            ->where('id', '!=', $id) // Abaikan ID kandidat yang sedang diedit
            ->exists();

        if ($exists) {
            return back()->withErrors(['number' => 'Nomor urut/peserta ini sudah digunakan kandidat lain.'])->withInput();
        }

        // Proses Update Gambar (Jika ada gambar baru)
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($team->image_path) {
                Storage::disk('public')->delete($team->image_path);
            }
            // Simpan gambar baru
            $team->image_path = $request->file('image')->store('teams', 'public');
        }

        // Update data text
        $team->update([
            'category_id' => $request->category_id,
            'number' => $request->number,
            'name' => $request->name,
            'location' => $request->location,
        ]);

        // Bersihkan cache
        Cache::forget('teams_' . $event->id);

        return redirect()->route('admin-event.leaderboard')->with('success', 'Data kandidat berhasil diperbarui!');
    }

    // Menghapus data kandidat
    public function destroy($id)
    {
        $eventAdmin = \Illuminate\Support\Facades\Auth::guard('event_admin')->user();

        // Cari data tim/kandidat yang ingin dihapus
        $team = \App\Models\Team::where('event_id', $eventAdmin->event_id)->findOrFail($id);

        // CEK KEAMANAN: Apakah kandidat ini sudah punya riwayat transaksi/invoice?
        $hasTransactions = \App\Models\Invoice::where('team_id', $team->id)->exists();

        if ($hasTransactions) {
            // Tolak penghapusan dan kembalikan dengan pesan error merah
            return redirect()->route('admin-event.leaderboard')
                ->with('error', 'Gagal! Kandidat ini tidak bisa dihapus karena sudah memiliki riwayat transaksi/suara masuk. Data keuangan harus dijaga.');
        }

        // Jika aman (belum ada transaksi), hapus foto dari storage (jika ada)
        if ($team->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($team->image_path);
        }

        // Hapus kandidat dari database
        $team->delete();

        return redirect()->route('admin-event.leaderboard')->with('success', 'Kandidat beserta fotonya berhasil dihapus secara permanen!');
    }
}
