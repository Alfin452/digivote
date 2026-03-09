@extends('layouts.admin')

@section('title', 'Buat Akun Panitia')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.event-admins.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Akun
    </a>
    <h1 class="text-3xl font-black text-gray-900">Buat Akses Panitia Baru</h1>
    <p class="text-gray-500 mt-1">Daftarkan email dan password untuk klien agar bisa mengelola event mereka.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
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

        <form action="{{ route('admin.event-admins.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Event Terkait <span class="text-red-500">*</span></label>
                <select name="event_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white">
                    <option value="">-- Pilih Event yang sudah dibuat --</option>
                    @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->name }} ({{ \Carbon\Carbon::parse($event->start_date)->format('M Y') }})
                    </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Satu event hanya bisa ditautkan ke satu akun panitia.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Perwakilan Panitia <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ketua KPU BEM" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: admin.bem@univ.edu" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password Login <span class="text-red-500">*</span></label>
                <input type="text" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                <p class="text-xs text-blue-600 mt-2 font-medium">💡 Berikan email & password ini kepada panitia agar mereka bisa login di {{ url('/admin-event/login') }}.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-200">
                    Simpan Akun Panitia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection