@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Event
    </a>
    <h1 class="text-3xl font-black text-gray-900">Edit Data Event</h1>
    <p class="text-gray-500 mt-1">Ubah pengaturan untuk <span class="font-bold text-gray-700">"{{ $event->name }}"</span>.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
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

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Event / Acara <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $event->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                <p class="text-xs text-gray-500 mt-1">Slug URL: <span class="font-mono text-blue-600">{{ $event->slug }}</span> (Slug tidak akan berubah agar link publik tidak rusak).</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Organisasi / Penyelenggara <span class="text-red-500">*</span></label>
                <input type="text" name="org" value="{{ old('org', $event->org) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat (Opsional)</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga per 1 Suara (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_per_vote" value="{{ old('price_per_vote', $event->price_per_vote) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all font-mono">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Penayangan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white">
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                        <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active (Berjalan)</option>
                        <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Logo Event (Opsional)</label>
                @if($event->logo_path)
                <div class="mb-3 p-2 bg-gray-50 border border-gray-200 rounded-xl inline-block">
                    <img src="{{ asset('storage/' . $event->logo_path) }}" alt="Logo Lama" class="h-16 w-auto object-contain rounded">
                </div>
                @endif
                <input type="file" name="logo" accept="image/jpeg, image/png, image/webp" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah logo saat ini.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection