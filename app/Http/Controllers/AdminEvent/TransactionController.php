<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class TransactionController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('event_admin')->user();
        $event = $admin->event;

        if (!$event) {
            abort(404, 'Event tidak ditemukan untuk akun ini.');
        }

        // Ambil data transaksi beserta data tim (kandidat) yang didukung.
        $transactions = Invoice::with('team')
            ->where('event_id', $event->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin-event.transactions', compact('event', 'admin', 'transactions'));
    }
}
