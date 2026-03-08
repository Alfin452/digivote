<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessVotePayment;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function xendit(Request $request)
    {
        // 1. Validasi signature/token keamanan dari Xendit [cite: 335-339]
        $secret = config('services.xendit.webhook_secret');

        if ($request->header('x-callback-token') !== $secret) {
            Log::warning('Percobaan Webhook Xendit Palsu Terdeteksi', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 2. Lempar data ke antrean (Redis) agar diproses di background [cite: 340-341]
        ProcessVotePayment::dispatch($request->all());

        // 3. Balas Xendit secepat mungkin dengan status 200 OK [cite: 342]
        return response()->json(['status' => 'received'], 200);
    }
}
