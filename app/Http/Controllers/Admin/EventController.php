<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // 1. Menampilkan daftar semua event
    public function index()
    {
        $events = Event::orderByDesc('created_at')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // 2. Menampilkan form tambah event baru
    public function create()
    {
        return view('admin.events.create');
    }

    // 3. Menyimpan data event baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_per_vote' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,draft',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('events', 'public');
        }

        Event::create([
            'name' => $request->name,
            // Generate slug otomatis dari nama event + timestamp agar selalu unik
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price_per_vote' => $request->price_per_vote,
            'status' => $request->status,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event baru berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit event
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // 5. Memperbarui data event
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_per_vote' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,draft',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($event->logo_path) {
                Storage::disk('public')->delete($event->logo_path);
            }
            // Simpan logo baru
            $event->logo_path = $request->file('logo')->store('events', 'public');
        }

        $event->update([
            'name' => $request->name,
            // Slug tidak diubah agar link publik yang sudah tersebar tidak rusak
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price_per_vote' => $request->price_per_vote,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil diperbarui!');
    }

    // 6. Menghapus event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->logo_path) {
            Storage::disk('public')->delete($event->logo_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}
