@extends('layouts.admin')

@section('title', 'Pengaturan Platform')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-100 tracking-tight">Pengaturan Platform</h1>
    <p class="text-slate-400 mt-1">Kelola konfigurasi global aplikasi, persentase biaya, dan keamanan Xendit.</p>
</div>

<div class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 overflow-hidden w-full">
    <div class="p-6 md:p-8">
        @if ($errors->any())
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm">
            <ul class="list-disc pl-5 font-medium">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-bold text-slate-200 mb-4 border-b border-slate-800 pb-2">Identitas & Keuangan Global</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Nama Platform <span class="text-red-400">*</span></label>
                    <input type="text" name="platform_name" value="{{ old('platform_name', $settings['platform_name'] ?? 'DigiVote.id') }}" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all placeholder-slate-600">
                    <p class="text-xs text-slate-500 mt-2">Nama yang akan tampil di header / judul web.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Potongan Layanan / Fee (%) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="number" name="fee_percent" value="{{ old('fee_percent', $settings['fee_percent'] ?? '5') }}" min="0" max="100" required class="w-full px-4 py-3 pr-10 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all font-mono">
                        <span class="absolute right-4 top-3.5 text-slate-500 font-bold">%</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Persentase keuntungan untuk platform (misal: 5 untuk 5%).</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-300 mb-2">Harga Default Per Vote (Rp) <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-500 font-bold">Rp</span>
                    <input type="number" name="default_price_per_vote" value="{{ old('default_price_per_vote', $settings['default_price_per_vote'] ?? '2000') }}" min="0" required class="w-full pl-12 pr-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all font-mono">
                </div>
                <p class="text-xs text-slate-500 mt-2">Harga rekomendasi saat membuat event baru.</p>
            </div>

            <h3 class="text-lg font-bold text-slate-200 mb-4 border-b border-slate-800 pb-2 pt-4">Keamanan Payment Gateway</h3>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-300 mb-2">Xendit Webhook Secret Token</label>
                <input type="text" name="xendit_webhook_secret" value="{{ old('xendit_webhook_secret', $settings['xendit_webhook_secret'] ?? '') }}" class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all font-mono text-sm placeholder-slate-600" placeholder="Contoh: xnd_webhook_secret_...">
                <p class="text-xs text-cyan-400 mt-2 font-medium">💡 Token ini didapatkan dari Dashboard Xendit saat mendaftarkan URL Webhook. Kosongkan jika belum tersedia.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="bg-gradient-to-r from-purple-500 to-cyan-500 hover:from-purple-400 hover:to-cyan-400 text-slate-950 font-black py-3 px-8 rounded-xl transition-all shadow-lg shadow-purple-500/20 uppercase tracking-wide">
                    Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection