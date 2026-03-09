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
    public function index()
    {
        $events = Event::orderByDesc('created_at')->paginate(10);
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
            'org' => 'required|string|max:255', // Validasi ORG ditambahkan
            'description' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'status' => 'required|in:draft,active,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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
            'org' => $request->org, // Menyimpan ORG
            'description' => $request->description,
            'price_per_vote' => $request->price_per_vote,
            'min_vote' => 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
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
            'org' => 'required|string|max:255', // Validasi ORG ditambahkan
            'description' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'status' => 'required|in:draft,active,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($event->logo_path) {
                Storage::disk('public')->delete($event->logo_path);
            }
            $event->logo_path = $request->file('logo')->store('events', 'public');
        }

        $event->update([
            'name' => $request->name,
            'org' => $request->org, // Update ORG
            'description' => $request->description,
            'price_per_vote' => $request->price_per_vote,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

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
