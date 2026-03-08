<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProcessVotePayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle(): void
    {
        $data = $this->payload;

        // Pastikan status dari Xendit adalah PAID [cite: 348]
        if (!isset($data['status']) || $data['status'] !== 'PAID') {
            return;
        }

        // Cari invoice berdasarkan ID dari Xendit
        $invoice = Invoice::where('xendit_id', $data['id'])->first();

        // Mencegah double-vote (Idempotency): Hanya proses jika statusnya masih pending
        if ($invoice && $invoice->status === 'pending') {
            DB::transaction(function () use ($invoice, $data) {
                // 1. Update status invoice jadi paid
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'xendit_payload' => $data
                ]);

                // 2. Tambah vote_count secara atomic [cite: 370, 395]
                Team::where('id', $invoice->team_id)
                    ->increment('vote_count', $invoice->vote_qty);

                // 3. Hapus cache agar leaderboard di halaman depan langsung terupdate [cite: 372-373]
                Cache::forget('vote_count_' . $invoice->event_id);
                Cache::forget('teams_' . $invoice->event_id);
            });
        }
    }
}
