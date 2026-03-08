<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function show(string $slug)
    {
        // 1. Ambil data event & cache selama 10 menit (600 detik)
        $event = Cache::remember(
            'event_' . $slug,
            600,
            fn() =>
            Event::with('categories')
                ->where('slug', $slug)
                ->where('status', 'live') // Hanya tampilkan event yang statusnya live
                ->firstOrFail()
        );

        // 2. Ambil data tim/kandidat & cache selama 1 jam (3600 detik)
        $teams = Cache::remember(
            'teams_' . $event->id,
            3600,
            fn() =>
            Team::with('category')
                ->where('event_id', $event->id)
                ->orderByDesc('vote_count') // Langsung urutkan dari suara terbanyak
                ->get()
        );

        return view('event.show', compact('event', 'teams'));
    }
}
