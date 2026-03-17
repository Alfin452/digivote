<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Hanya menampilkan beberapa event di beranda (misal 3) untuk section kecil
        $activeEvents = Cache::remember('active_events_landing', 600, function () {
            return Event::where('status', 'live')
                ->latest()
                ->take(3)
                ->get();
        });

        return view('public.home', compact('activeEvents'));
    }

    public function howItWorks()
    {
        return view('public.cara-kerja');
    }

    public function liveEvents()
    {
        $events = Event::where('status', 'live')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('public.live-events', compact('events'));
    }
}
