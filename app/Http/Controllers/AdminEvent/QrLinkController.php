<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class QrLinkController extends Controller
{
    public function index()
    {
        // Ambil admin yang sedang login dan event-nya
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        if (!$event) {
            abort(404, 'Event tidak ditemukan untuk akun ini.');
        }

        // Ambil data tim/kandidat diurutkan berdasarkan nomor urut (bukan suara)
        $teams = Team::where('event_id', $event->id)
            ->orderBy('number', 'asc')
            ->get();

        return view('admin-event.qr-links', compact('event', 'admin', 'teams'));
    }
}
