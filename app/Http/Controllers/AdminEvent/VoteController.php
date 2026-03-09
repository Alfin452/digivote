<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class VoteController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        if (!$event) {
            abort(404, 'Event tidak ditemukan.');
        }

        // Hanya ambil data yang statusnya PAID (Suara Sah)
        $validVotes = Invoice::with('team')
            ->where('event_id', $event->id)
            ->where('status', 'paid')
            ->orderByDesc('paid_at') // Urutkan dari waktu pembayaran/vote terbaru
            ->paginate(20);

        return view('admin-event.votes', compact('event', 'admin', 'validVotes'));
    }
}
