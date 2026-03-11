<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar: Ambil semua invoice beserta relasi event & kandidat (team)
        $query = Invoice::with(['event', 'team'])->orderByDesc('created_at');

        // Fitur Filter Status (Opsional, jika admin ingin melihat yang paid saja)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $transactions = $query->paginate(15);

        // Hitung total uang sukses (PAID) dari seluruh platform
        $totalIncome = Invoice::where('status', 'paid')->sum('amount');

        // Hitung total uang pending
        $totalPending = Invoice::where('status', 'pending')->sum('amount');

        return view('admin.transactions.index', compact('transactions', 'totalIncome', 'totalPending'));
    }
}
