@extends('layouts.admin-event')

@section('title', 'Edit Kandidat')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin-event.leaderboard') }}" class="inline-flex items-center text-cyan-500 hover:text-cyan-400 font-bold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Leaderboard
    </a>
    <h1 class="text-3xl font-extrabold text-white">Edit Data Kandidat</h1>
    <p class="text-slate-400 mt-1">Ubah informasi peserta. Biarkan foto kosong jika tidak ingin mengganti gambar.</p>
</div>

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden w-full">
    <div class="p-6 md:p-8">

        @if ($errors->any())
        <div class="mb-6 bg-rose-500/10 text-rose-400 p-4 rounded-xl text-sm border border-rose-500/20">
            <ul class="list-disc pl-5 font-medium">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin-event.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="number" class="block text-sm font-bold text-slate-300 mb-2">No. Urut / Peserta <span class="text-rose-500">*</span></label>
                    <input type="text" name="number" id="number" value="{{ old('number', $team->number) }}" required class="w-full px-4 py-3 bg-slate-800/50 text-white rounded-xl border border-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all placeholder-slate-500">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-slate-300 mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-3 bg-slate-800/50 text-white rounded-xl border border-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all appearance-none cursor-pointer">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" class="bg-slate-800" {{ (old('category_id', $team->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-300 mb-2">Nama Lengkap / Nama Tim <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required class="w-full px-4 py-3 bg-slate-800/50 text-white rounded-xl border border-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all placeholder-slate-500">
                </div>

                <div>
                    <label for="location" class="block text-sm font-bold text-slate-300 mb-2">Asal / Instansi / Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $team->location) }}" class="w-full px-4 py-3 bg-slate-800/50 text-white rounded-xl border border-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all placeholder-slate-500">
                </div>
            </div>

            <div class="mb-8">
                <label for="image" class="block text-sm font-bold text-slate-300 mb-2">Ganti Foto / Logo (Opsional)</label>
                @if($team->image)
                <div class="mb-4 p-2 bg-slate-800/50 rounded-xl border border-slate-700 inline-block shadow-inner">
                    <img src="{{ asset('storage/' . $team->image) }}" alt="Foto Lama" class="w-20 h-20 object-cover rounded-lg border border-slate-600">
                </div>
                @endif
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp" class="w-full px-4 py-3 bg-slate-800/50 text-slate-300 rounded-xl border border-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-cyan-400 hover:file:bg-slate-600 cursor-pointer">
                <p class="text-xs text-slate-500 mt-2">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-end pt-5 border-t border-slate-800">
                <button type="submit" class="w-full md:w-auto bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-bold py-3 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(6,182,212,0.2)] hover:shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection