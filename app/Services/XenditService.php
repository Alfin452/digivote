<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Team;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class XenditService
{
    public function createInvoice(Event $event, Team $team, int $qty, string $voter): array
    {
        // Hitung total harga
        $amount = $event->price_per_vote * $qty;

        // Buat ID unik untuk referensi kita ke Xendit
        $externalId = 'DV-' . strtoupper($event->slug) . '-' . time() . '-' . Str::random(6);

        // Tembak API Xendit menggunakan Basic Auth
        $response = Http::withBasicAuth(config('services.xendit.secret_key'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $externalId,
                'amount' => $amount,
                'description' => 'Vote ' . $qty . 'x untuk ' . $team->name,
                'invoice_duration' => 300, // Expired dalam 5 menit
                'payment_methods' => ['QRIS'], // Fokus ke QRIS sesuai brief
                'customer' => [
                    'given_names' => $voter ?: 'Anonymous'
                ],
                'success_redirect_url' => url('/' . $event->slug . '?voted=1'),
                'failure_redirect_url' => url('/' . $event->slug . '?failed=1'),
            ]);

        if ($response->failed()) {
            throw new \Exception('Gagal terhubung ke Xendit: ' . $response->body());
        }

        $data = $response->json();

        // Simpan data invoice ke database kita dengan status pending
        Invoice::create([
            'xendit_id' => $data['id'],
            'event_id' => $event->id,
            'team_id' => $team->id,
            'voter_name' => $voter ?: 'Anonymous',
            'vote_qty' => $qty,
            'amount' => $amount,
            'status' => 'pending',
            'expired_at' => now()->addMinutes(5),
        ]);

        return $data;
    }
}
