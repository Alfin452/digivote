@extends('layouts.admin-event')

@section('title', 'Edit Kandidat')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin-event.leaderboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Leaderboard
    </a>
    <h1 class="text-3xl font-extrabold text-gray-900">Edit Data Kandidat</h1>
    <p class="text-gray-500 mt-1">Ubah informasi peserta. Biarkan foto kosong jika tidak ingin mengganti gambar.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-6 md:p-8">

        @if ($errors->any())
        <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100">
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
                    <label for="number" class="block text-sm font-bold text-gray-700 mb-2">No. Urut / Peserta <span class="text-red-500">*</span></label>
                    <input type="text" name="number" id="number" value="{{ old('number', $team->number) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all bg-white">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $team->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap / Nama Tim <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
            </div>

            <div class="mb-6">
                <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Asal / Instansi / Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $team->location) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
            </div>

            <div class="mb-8">
                <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Ganti Foto / Logo (Opsional)</label>
                @if($team->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $team->image_path) }}" alt="Foto Lama" class="w-20 h-20 object-cover rounded-xl border border-gray-200">
                </div>
                @endif
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-2">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection