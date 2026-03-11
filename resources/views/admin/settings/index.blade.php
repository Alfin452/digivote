@extends('layouts.admin')

@section('title', 'Pengaturan Platform')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Pengaturan Platform</h1>
    <p class="text-gray-500 mt-1">Kelola konfigurasi global aplikasi, persentase biaya, dan keamanan Xendit.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
    <div class="p-6 md:p-8">
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl text-sm">
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

            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Identitas & Keuangan Global</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Platform <span class="text-red-500">*</span></label>
                    <input type="text" name="platform_name" value="{{ old('platform_name', $settings['platform_name'] ?? 'DigiVote.id') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Nama yang akan tampil di header / judul web.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Potongan Layanan / Fee (%) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="fee_percent" value="{{ old('fee_percent', $settings['fee_percent'] ?? '5') }}" min="0" max="100" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all font-mono">
                        <span class="absolute right-4 top-3 text-gray-400 font-bold">%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Persentase keuntungan untuk platform (misal: 5 untuk 5%).</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Default Per Vote (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-400 font-bold">Rp</span>
                    <input type="number" name="default_price_per_vote" value="{{ old('default_price_per_vote', $settings['default_price_per_vote'] ?? '2000') }}" min="0" required class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all font-mono">
                </div>
                <p class="text-xs text-gray-500 mt-1">Harga rekomendasi saat membuat event baru.</p>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 pt-4">Keamanan Payment Gateway</h3>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Xendit Webhook Secret Token</label>
                <input type="text" name="xendit_webhook_secret" value="{{ old('xendit_webhook_secret', $settings['xendit_webhook_secret'] ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all font-mono text-sm placeholder-gray-300" placeholder="Contoh: xnd_webhook_secret_...">
                <p class="text-xs text-blue-600 mt-2 font-medium">💡 Token ini didapatkan dari Dashboard Xendit saat mendaftarkan URL Webhook. Kosongkan jika belum tersedia.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-200 uppercase tracking-wide">
                    Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection