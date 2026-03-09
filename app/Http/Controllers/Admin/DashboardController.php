<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total Event yang terdaftar di platform
        $totalEvents = Event::count();

        // 2. Hitung Total Keuntungan Kotor (Gross Income) dari SEMUA event (hanya yang PAID)
        $totalPlatformIncome = Invoice::where('status', 'paid')->sum('amount');

        // 3. Hitung Total Suara yang sudah diproses sistem
        $totalPlatformVotes = Invoice::where('status', 'paid')->sum('vote_qty');

        // 4. Ambil 5 Event terbaru untuk ditampilkan di tabel sekilas
        $recentEvents = Event::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact('totalEvents', 'totalPlatformIncome', 'totalPlatformVotes', 'recentEvents'));
    }
}
