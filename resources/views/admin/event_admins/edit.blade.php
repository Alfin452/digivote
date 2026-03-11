@extends('layouts.admin')

@section('title', 'Edit Akun Panitia')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.event-admins.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 font-semibold mb-4 transition-colors">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Panitia
    </a>
    <h1 class="text-3xl font-black text-slate-100 tracking-tight">Edit Data Panitia</h1>
    <p class="text-slate-400 mt-1">Ubah informasi akun panitia untuk event <span class="font-bold text-slate-200">"{{ $eventAdmin->event->name ?? 'Tidak diketahui' }}"</span>.</p>
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

        <form action="{{ route('admin.event-admins.update', $eventAdmin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Nama Panitia <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $eventAdmin->name) }}" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all placeholder-slate-600">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Pilih Event yang Dikelola <span class="text-red-400">*</span></label>
                    <div class="relative group">
                        <select name="event_id" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all appearance-none cursor-pointer">
                            <option value="" disabled>Pilih Event...</option>
                            @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ (old('event_id', $eventAdmin->event_id) == $event->id) ? 'selected' : '' }} class="bg-slate-900">
                                {{ $event->name }}
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Email (Username) <span class="text-red-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $eventAdmin->email) }}" required class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all placeholder-slate-600">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Password Baru <span class="text-slate-500 font-normal">(Opsional)</span></label>

                    <div class="relative">
                        <input type="password" id="password_input" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full px-4 py-3 pr-12 bg-slate-950 text-slate-200 placeholder-slate-600 rounded-xl border border-slate-800 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all">

                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 hover:text-purple-400 focus:outline-none transition-colors" title="Lihat/Sembunyikan Password">
                            <svg id="eye_icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eye_slash_icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>

                    <p class="text-xs text-slate-500 mt-2">Hanya diisi jika Anda ingin mereset/mengganti password akun panitia ini.</p>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="bg-gradient-to-r from-purple-500 to-cyan-500 hover:from-purple-400 hover:to-cyan-400 text-slate-950 font-black tracking-wide py-3 px-8 rounded-xl transition-all shadow-lg shadow-purple-500/20">
                    Simpan Perubahan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password_input');
        const eyeIcon = document.getElementById('eye_icon');
        const eyeSlashIcon = document.getElementById('eye_slash_icon');

        if (passwordInput.type === 'password') {
            // Ubah ke mode text (lihat password)
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            // Kembalikan ke mode password (sensor)
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
</script>
@endsection