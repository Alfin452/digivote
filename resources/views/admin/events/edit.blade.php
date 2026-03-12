@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

<div class="mb-8">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 font-semibold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Event
    </a>
    <h1 class="text-3xl font-black text-slate-100 tracking-tight">Edit Data Event</h1>
    <p class="text-slate-400 mt-1">Ubah pengaturan untuk <span class="font-bold text-slate-200">"{{ $event->name }}"</span>.</p>
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

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Nama Event / Acara <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $event->name) }}" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Nama Organisasi / Penyelenggara <span class="text-red-400">*</span></label>
                    <input type="text" name="org" value="{{ old('org', $event->org) }}" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-300 mb-2">Deskripsi Singkat</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Harga per Suara <span class="text-red-400">*</span></label>
                    <input type="number" name="price_per_vote" value="{{ old('price_per_vote', $event->price_per_vote) }}" min="0" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all font-mono">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Minimal Pembelian <span class="text-red-400">*</span></label>
                    <input type="number" name="min_vote" value="{{ old('min_vote', $event->min_vote) }}" min="1" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all font-mono">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Status <span class="text-red-400">*</span></label>
                    <div class="relative group">
                        <select name="status" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all appearance-none cursor-pointer">
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                            <option value="soon" {{ old('status', $event->status) == 'soon' ? 'selected' : '' }}>Soon (Akan Datang)</option>
                            <option value="live" {{ old('status', $event->status) == 'live' ? 'selected' : '' }}>Live (Berjalan)</option>
                            <option value="done" {{ old('status', $event->status) == 'done' ? 'selected' : '' }}>Done (Selesai)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Tanggal Mulai <span class="text-red-400">*</span></label>
                    <input type="text" name="started_at" value="{{ old('started_at', \Carbon\Carbon::parse($event->started_at)->format('Y-m-d')) }}" required class="datepicker w-full px-4 py-3 bg-slate-950 text-slate-200 placeholder-slate-500 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all" placeholder="Pilih Tanggal Mulai...">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Tanggal Selesai <span class="text-red-400">*</span></label>
                    <input type="text" name="ended_at" value="{{ old('ended_at', \Carbon\Carbon::parse($event->ended_at)->format('Y-m-d')) }}" required class="datepicker w-full px-4 py-3 bg-slate-950 text-slate-200 placeholder-slate-500 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all" placeholder="Pilih Tanggal Selesai...">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-300 mb-2">Ganti Logo Event (Opsional)</label>

                @if($event->logo_path)
                <div class="mb-4 p-2 bg-slate-950 border border-slate-800 rounded-xl inline-block shadow-inner">
                    <img src="{{ asset('storage/' . $event->logo_path) }}" alt="Logo Lama" class="h-16 w-auto object-contain rounded">
                </div>
                @endif

                <div class="relative group">
                    <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 bg-slate-950 text-slate-400 rounded-xl border border-slate-800 focus:border-purple-500 outline-none transition-all file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-purple-400 hover:file:bg-slate-700 hover:file:text-purple-300 cursor-pointer">
                </div>
                <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah logo saat ini.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="bg-gradient-to-r from-purple-500 to-cyan-500 hover:from-purple-400 hover:to-cyan-400 text-slate-950 font-black tracking-wide py-3 px-8 rounded-xl transition-all shadow-lg shadow-purple-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Flatpickr pada input yang memiliki class "datepicker"
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d", // Format tahun-bulan-tanggal
            allowInput: true, // Mengizinkan user mengetik manual jika mau
            disableMobile: "true" // Memaksa flatpickr berjalan di mobile (menimpa UI bawaan HP)
        });
    });
</script>
@endsection