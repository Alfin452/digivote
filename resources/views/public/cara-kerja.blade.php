@extends('layouts.public')

@section('title', 'Cara Kerja - DigiVote')

@section('content')
<div class="bg-google-gray min-h-[calc(100vh-64px)] py-12 md:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-display font-medium text-google-text mb-4">Arsitektur & Transaksi</h1>
            <p class="text-google-textmuted text-lg">Bagaimana sistem kami memproses suara secara real-time melalui webhook Xendit.</p>
        </div>

        <div class="bg-white rounded-2xl border border-google-border google-shadow p-8 mb-8">
            <div class="border-l-4 border-google-blue pl-6 py-2 mb-10">
                <h2 class="text-2xl font-display text-google-text mb-2">1. Inisiasi Transaksi</h2>
                <p class="text-google-textmuted">Pengguna memilih kandidat dan menentukan kuantitas suara (vote). Sistem menghitung total tagihan dengan formula `qty * price_per_vote` dan membuat Invoice eksternal via API Xendit.</p>
            </div>
            
            <div class="border-l-4 border-google-yellow pl-6 py-2 mb-10">
                <h2 class="text-2xl font-display text-google-text mb-2">2. Autentikasi Pembayaran</h2>
                <p class="text-google-textmuted">Pengguna diarahkan ke Checkout UI Xendit untuk memindai QRIS. Endpoint menunggu callback (webhook) asinkron dari bank/e-wallet untuk memvalidasi pembayaran.</p>
            </div>

            <div class="border-l-4 border-google-green pl-6 py-2">
                <h2 class="text-2xl font-display text-google-text mb-2">3. Rekonsiliasi Server</h2>
                <p class="text-google-textmuted">Xendit mengirim *POST Request* ke endpoint webhook kami (`/webhook/xendit`). Pekerja antrean (Background Job) memvalidasi token rahasia, memperbarui status Invoice menjadi "paid", dan menambahkan angka suara ke tabel Leaderboard secara serentak.</p>
            </div>
        </div>
        
        <div class="text-center">
            <a href="{{ route('home.live-events') }}" class="text-google-blue font-medium hover:underline inline-flex items-center gap-1">
                Lihat langsung di Live Events 
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>
@endsection
