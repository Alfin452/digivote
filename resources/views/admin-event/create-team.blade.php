@extends('layouts.admin-event')

@section('title', 'Tambah Kandidat Baru')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --surface: #0f1117;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--surface);
        color: #e2e8f0;
    }

    .dash-title {
        font-family: 'Syne', sans-serif;
    }

    /* Animasi Muncul Halus */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-fade-up {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Custom Input Auto-fill (Mencegah background putih saat autofill di Chrome) */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px #1e293b inset !important;
        -webkit-text-fill-color: white !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>
@endpush

@section('content')
<div class="mb-8 anim-fade-up" style="animation-delay: 0s;">
    <a href="{{ route('admin-event.leaderboard') }}" class="inline-flex items-center text-sm font-bold text-cyan-400 hover:text-cyan-300 transition-colors bg-cyan-500/10 border border-cyan-500/20 px-4 py-2 rounded-xl mb-5 hover:bg-cyan-500/20 shadow-[0_0_10px_rgba(6,182,212,0.1)]">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Papan
    </a>
    <h1 class="dash-title text-3xl md:text-4xl font-extrabold text-white tracking-tight">Tambah Kandidat</h1>
    <p class="text-slate-400 mt-2 text-sm">Masukkan data lengkap peserta/tim baru ke dalam sistem. Foto bersifat opsional.</p>
</div>

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden max-w-2xl mx-auto">
    <div class="p-6 md:p-8">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

        <div class="p-6 md:p-8 relative z-10">

            @if ($errors->any())
            <div class="mb-8 bg-red-500/10 text-red-400 p-5 rounded-xl text-sm border border-red-500/20 shadow-[0_0_15px_rgba(239,68,68,0.1)]">
                <div class="flex items-center font-bold mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terdapat kesalahan pengisian:
                </div>
                <ul class="list-disc pl-7 space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin-event.team.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="number" class="block text-sm font-bold text-slate-300 mb-2">No. Urut / Peserta <span class="text-red-500">*</span></label>
                        <input type="text" name="number" id="number" value="{{ old('number') }}" required placeholder="Contoh: 01"
                            class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-800/50 text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all shadow-inner">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-bold text-slate-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-800/50 text-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all appearance-none shadow-inner cursor-pointer">
                                <option value="" disabled selected class="text-slate-500">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-slate-800 text-white">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-slate-300 mb-2">Nama Lengkap / Nama Tim <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-800/50 text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all shadow-inner">
                </div>

                <div class="mb-6">
                    <label for="location" class="block text-sm font-bold text-slate-300 mb-2">Asal / Instansi / Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Contoh: Fakultas Teknik / SMAN 1"
                        class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-800/50 text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all shadow-inner">
                </div>

                <div class="mb-8">
                    <label for="image" class="block text-sm font-bold text-slate-300 mb-2">Foto / Logo <span class="text-slate-500 font-normal">(Opsional)</span></label>
                    <div class="relative">
                        <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp"
                            class="w-full pl-4 pr-4 py-3 rounded-xl border border-slate-700 bg-slate-800/50 text-slate-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all shadow-inner cursor-pointer
                        file:mr-5 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:tracking-widest file:uppercase file:bg-cyan-500/10 file:text-cyan-400 file:border file:border-cyan-500/20 hover:file:bg-cyan-500/20 hover:file:cursor-pointer">
                    </div>
                    <p class="text-xs text-slate-500 mt-2.5 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.
                    </p>
                </div>

                <div class="flex justify-end pt-6 border-t border-slate-800">
                    <button type="submit" class="inline-flex items-center bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Kandidat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection