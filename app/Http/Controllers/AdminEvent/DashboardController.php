<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Invoice;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data admin yang sedang login beserta event-nya
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        // Jika entah kenapa admin ini tidak punya event, lempar error 404
        if (!$event) {
            abort(404, 'Event tidak ditemukan untuk akun ini.');
        }

        // 1. Ambil Leaderboard Kandidat (Urut berdasarkan suara terbanyak)
        $leaderboard = Team::where('event_id', $event->id)
            ->orderByDesc('vote_count')
            ->get();

        // 2. Hitung Total Suara Masuk
        $totalVotes = $leaderboard->sum('vote_count');

        // 3. Hitung Total Pemasukan dari Xendit (hanya yang berstatus 'paid')
        $totalIncome = Invoice::where('event_id', $event->id)
            ->where('status', 'paid')
            ->sum('amount');

        $todayIncome = Invoice::where('event_id', $event->id)
            ->where('status', 'paid')
            ->whereDate('paid_at', Carbon::today())
            ->sum('amount');

        // Lalu kirimkan via compact('event', 'totalVotes', 'totalIncome', 'leaderboard', 'todayIncome');
        return view('admin-event.dashboard', compact('event', 'admin', 'leaderboard', 'totalVotes', 'totalIncome', 'todayIncome'));
    }
}
