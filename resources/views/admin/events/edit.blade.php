@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
{{-- Load Flatpickr Light Theme --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar {
        font-family: 'Inter', sans-serif;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
</style>

<div class="w-full pb-10">

    {{-- Tombol Kembali --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-600 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 group w-fit">
            <svg class="w-5 h-5 mr-2 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Event
        </a>
    </div>

    {{-- Alert Validasi Error --}}
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
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

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- KARTU 1: Informasi Dasar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-heading font-bold text-slate-800">1. Informasi Dasar</h3>
                <p class="text-sm text-slate-500">Detail utama dari event yang akan diselenggarakan.</p>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Event / Acara <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $event->name) }}" required
                            class="w-full px-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                            placeholder="Contoh: Pemilu BEM 2026">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Penyelenggara (Organisasi) <span class="text-red-500">*</span></label>
                        <input type="text" name="org" value="{{ old('org', $event->org) }}" required
                            class="w-full px-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                            placeholder="Contoh: BEM Universitas X">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat (Opsional)</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium resize-none"
                        placeholder="Berikan keterangan singkat tentang tujuan atau aturan event ini...">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- KARTU 2: Aturan & Harga --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-heading font-bold text-slate-800">2. Pengaturan Voting & Harga</h3>
                <p class="text-sm text-slate-500">Tentukan harga per suara, minimal pembelian, dan status tayang.</p>
            </div>
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Input Harga dengan Auto-Format Rupiah (Alpine.js) --}}
                    <div x-data="{
                        rawPrice: '{{ old('price_per_vote', $event->price_per_vote) }}',
                        get formattedPrice() {
                            if (!this.rawPrice && this.rawPrice !== 0) return '';
                            return parseInt(this.rawPrice).toLocaleString('id-ID');
                        },
                        updatePrice(e) {
                            let val = e.target.value.replace(/\D/g, '');
                            this.rawPrice = val || 0;
                            e.target.value = this.formattedPrice;
                        }
                    }">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Harga per Suara <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold">Rp</span>
                            </div>

                            {{-- Hidden input yang dikirim ke Laravel --}}
                            <input type="hidden" name="price_per_vote" :value="rawPrice">

                            {{-- Input visual yang diketik Admin --}}
                            <input type="text" :value="formattedPrice" @input="updatePrice" required placeholder="0"
                                class="w-full pl-12 pr-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-bold tracking-wide">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Minimal Pembelian <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="min_vote" value="{{ old('min_vote', $event->min_vote) }}" min="1" required
                                class="w-full px-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-bold tracking-wide">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-sm font-medium">Vote</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status Event <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <select name="status" required class="w-full pl-4 pr-10 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all appearance-none cursor-pointer font-medium">
                                <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                                <option value="soon" {{ old('status', $event->status) == 'soon' ? 'selected' : '' }}>Soon (Akan Datang)</option>
                                <option value="live" {{ old('status', $event->status) == 'live' ? 'selected' : '' }}>Live (Berjalan)</option>
                                <option value="done" {{ old('status', $event->status) == 'done' ? 'selected' : '' }}>Done (Selesai)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU 3: Periode & Media --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-heading font-bold text-slate-800">3. Periode & Media</h3>
                <p class="text-sm text-slate-500">Tentukan jadwal pelaksanaan dan perbarui logo acara jika diperlukan.</p>
            </div>
            <div class="p-6 md:p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Flatpickr Inputs --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="text" name="started_at" value="{{ old('started_at', \Carbon\Carbon::parse($event->started_at)->format('Y-m-d')) }}" required
                                class="datepicker w-full pl-11 pr-4 py-3 bg-slate-50 text-slate-800 placeholder-slate-400 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium cursor-pointer"
                                placeholder="Pilih Tanggal Mulai">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="text" name="ended_at" value="{{ old('ended_at', \Carbon\Carbon::parse($event->ended_at)->format('Y-m-d')) }}" required
                                class="datepicker w-full pl-11 pr-4 py-3 bg-slate-50 text-slate-800 placeholder-slate-400 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium cursor-pointer"
                                placeholder="Pilih Tanggal Selesai">
                        </div>
                    </div>
                </div>

                {{-- File Input Premium (Upload & Preview Logo) --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Ganti Logo Event (Opsional)</label>

                    {{-- Tampilan Logo Saat Ini --}}
                    @if($event->logo_path)
                    <div class="mb-5 flex items-center gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50 shadow-sm w-fit max-w-full">
                        <img src="{{ asset('storage/' . $event->logo_path) }}" alt="Logo Lama" class="h-16 w-16 object-cover rounded-lg shadow-sm border border-slate-200 shrink-0 bg-white">
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-slate-700">Logo Saat Ini Aktif</p>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">Biarkan kosong di bawah jika tidak ingin diganti.</p>
                        </div>
                    </div>
                    @endif

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="logo-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                    <span>Upload file logo baru</span>
                                    <input id="logo-upload" name="logo" type="file" accept="image/jpeg, image/png, image/webp" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, WEBP hingga 2MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.events.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition-all shadow-sm shadow-blue-600/20">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            allowInput: true,
            disableMobile: "true"
        });

        const fileInput = document.getElementById('logo-upload');
        const fileLabel = fileInput.previousElementSibling;
        const originalText = fileLabel.innerText;

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                fileLabel.innerText = 'Terpilih: ' + e.target.files[0].name;
            } else {
                fileLabel.innerText = originalText;
            }
        });
    });
</script>
@endpush
@endsection