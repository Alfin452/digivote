<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query dengan relasi
        $query = Invoice::with(['event', 'team']);

        // 2. Fitur Pencarian (Cari berdasarkan Nama Pemilih, Xendit ID, atau Nama Event)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('voter_name', 'like', "%{$search}%")
                    ->orWhere('xendit_id', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eventQuery) use ($search) {
                        $eventQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Filter Status (Paid, Pending, dll)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Fitur Pengurutan (Sort)
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_desc':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_asc':
                $query->orderBy('amount', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $transactions = $query->paginate(15);

        // Summary Cards (Tetap dihitung dari total keseluruhan, bukan yang terfilter)
        $totalIncome = Invoice::where('status', 'paid')->sum('amount');
        $totalPending = Invoice::where('status', 'pending')->sum('amount');

        return view('admin.transactions.index', compact('transactions', 'totalIncome', 'totalPending'));
    }
}