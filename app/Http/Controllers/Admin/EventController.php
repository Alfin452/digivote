<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi Query Builder
        $query = Event::query();

        // 2. Filter Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('org', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter Urutan (Sort)
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_vote', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price_per_vote', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 5. Eksekusi Query dan Paginate (10 data per halaman)
        $events = $query->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'org' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'min_vote' => 'required|numeric|min:1',
            // PERBAIKAN: Sesuaikan dengan enum di database
            'status' => 'required|in:draft,soon,live,done',
            'started_at' => 'required|date',
            'ended_at' => 'required|date|after_or_equal:started_at',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $slug = Str::slug($request->name);
        $count = Event::where('slug', 'like', $slug . '%')->count();
        $finalSlug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('events', 'public');
        }

        $event = Event::create([
            'name' => $request->name,
            'slug' => $finalSlug,
            'org' => $request->org,
            'description' => $request->description,
            'price_per_vote' => $request->price_per_vote,
            'min_vote' => $request->min_vote,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'status' => $request->status, // Mengirim status yang benar
            'logo_path' => $logoPath,
        ]);

        Category::create([
            'event_id' => $event->id,
            'name' => 'Umum',
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diciptakan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'org' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'min_vote' => 'required|numeric|min:1',
            'status' => 'required|in:draft,soon,live,done',
            'started_at' => 'required|date',
            'ended_at' => 'required|date|after_or_equal:started_at',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Siapkan data yang akan diupdate
        $data = [
            'name' => $request->name,
            'org' => $request->org,
            'description' => $request->description,
            'price_per_vote' => $request->price_per_vote,
            'min_vote' => $request->min_vote,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'status' => $request->status,
        ];

        // Jika user mengunggah logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama dari storage jika ada
            if ($event->logo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->logo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->logo_path);
            }
            // Simpan logo baru dan masukkan ke array data
            $data['logo_path'] = $request->file('logo')->store('events', 'public');
        }

        // Eksekusi update
        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil diperbarui!');
    }

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
