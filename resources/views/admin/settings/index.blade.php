@extends('layouts.admin')

@section('title', 'Pengaturan Platform')

@section('content')
<div class="w-full pb-10">

    {{-- Alert Validasi Error --}}
    @if ($errors->any())
    <div class="mb-6 mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-red-800">Terdapat {{ $errors->count() }} kesalahan pengisian:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="mb-6 mt-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 mt-4">
        @csrf
        @method('PUT')

        {{-- KARTU 1: Identitas & Keuangan Global --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-heading font-bold text-slate-800">1. Identitas & Keuangan Global</h3>
                <p class="text-sm text-slate-500">Kelola nama aplikasi, persentase keuntungan, dan harga dasar voting.</p>
            </div>
            <div class="p-6 md:p-8 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Input Nama Platform --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Platform <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <input type="text" name="platform_name" value="{{ old('platform_name', $settings['platform_name'] ?? 'DigiVote.id') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                                placeholder="Contoh: DigiVote.id">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Nama yang akan tampil di sistem web.</p>
                    </div>

                    {{-- Input Fee / Potongan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Potongan Layanan / Fee <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="fee_percent" value="{{ old('fee_percent', $settings['fee_percent'] ?? '5') }}" min="0" max="100" required
                                class="w-full px-4 py-3 pr-10 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-bold tracking-wide">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold">%</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Persentase bersih untuk platform (misal: 5 untuk 5%).</p>
                    </div>
                </div>

                {{-- Input Harga Default dengan Format Rupiah (Alpine.js) --}}
                <div class="w-full md:w-1/2 pr-0 md:pr-3" x-data="{
                    rawPrice: '{{ old('default_price_per_vote', $settings['default_price_per_vote'] ?? '2000') }}',
                    get formattedPrice() {
                        if (!this.rawPrice) return '';
                        // Ubah angka murni menjadi format ribuan dengan titik (Standar Indonesia)
                        return parseInt(this.rawPrice).toLocaleString('id-ID');
                    },
                    updatePrice(e) {
                        // Hilangkan semua karakter selain angka agar tidak error
                        let val = e.target.value.replace(/\D/g, '');
                        this.rawPrice = val;
                        // Format kembali tampilannya di input box
                        e.target.value = this.formattedPrice;
                    }
                }">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Default Per Vote <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-bold">Rp</span>
                        </div>

                        <input type="hidden" name="default_price_per_vote" :value="rawPrice">

                        <input type="text" :value="formattedPrice" @input="updatePrice" required
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-bold tracking-wide text-lg">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2 font-medium">Harga rekomendasi pengisian saat form pembuatan event baru.</p>
                </div>

            </div>
        </div>

        {{-- KARTU 2: Keamanan Xendit --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-heading font-bold text-slate-800">2. Integrasi Xendit Webhook</h3>
                <p class="text-sm text-slate-500">Konfigurasi keamanan komunikasi antara platform ini dengan server Xendit.</p>
            </div>
            <div class="p-6 md:p-8">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Webhook Secret Token</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <input type="text" name="xendit_webhook_secret" value="{{ old('xendit_webhook_secret', $settings['xendit_webhook_secret'] ?? '') }}"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-mono text-sm"
                            placeholder="xnd_webhook_secret_...">
                    </div>

                    {{-- Info Box Premium --}}
                    <div class="mt-4 flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <div class="mt-0.5 text-blue-500 shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-blue-800 font-medium leading-relaxed">
                            Token ini didapatkan dari Dashboard Xendit saat Anda mendaftarkan URL Webhook. Token berfungsi memastikan bahwa notifikasi pembayaran yang masuk benar-benar berasal dari server resmi Xendit. <br>
                            <span class="font-bold">Kosongkan kolom di atas jika sistem webhook belum Anda konfigurasikan.</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="flex items-center justify-end pt-4">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition-all shadow-sm shadow-blue-600/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Simpan Konfigurasi
            </button>
        </div>
    </form>
</div>
@endsection