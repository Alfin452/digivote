<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Team;
use App\Services\XenditService;
use Illuminate\Support\Facades\Cache;

class VoteController extends Controller
{
    // Menampilkan halaman form untuk input jumlah vote
    public function create(string $slug, Request $request)
    {
        $event = Cache::remember(
            'event_' . $slug,
            600,
            fn() =>
            Event::where('slug', $slug)->where('status', 'live')->firstOrFail()
        );

        $team = Team::where('event_id', $event->id)
            ->where('number', $request->query('kandidat'))
            ->firstOrFail();

        return view('event.vote', compact('event', 'team'));
    }

    // Menerima submit form dan membuat invoice
    public function store(Request $request, string $slug, XenditService $xenditService)
    {
        $request->validate([
            'team_number' => 'required|string',
            'vote_qty' => 'required|integer|min:1',
            'voter_name' => 'nullable|string|max:150',
        ]);

        $event = Cache::remember(
            'event_' . $slug,
            600,
            fn() =>
            Event::where('slug', $slug)->where('status', 'live')->firstOrFail()
        );

        $team = Team::where('event_id', $event->id)
            ->where('number', $request->team_number)
            ->firstOrFail();

        // Panggil service Xendit yang baru saja kita buat
        $invoice = $xenditService->createInvoice(
            $event,
            $team,
            $request->vote_qty,
            $request->voter_name ?? 'Anonymous'
        );

        // Arahkan pemilih langsung ke halaman pembayaran Xendit
        return redirect($invoice['invoice_url']);
    }
}
