@extends('layouts.admin')

@section('title', 'Edit Akun Panitia')

@section('content')
<div class="w-full pb-10">

    {{-- Tombol Kembali --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('admin.event-admins.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-600 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 group w-fit">
            <svg class="w-5 h-5 mr-2 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Panitia
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

    <form action="{{ route('admin.event-admins.update', $eventAdmin->id) }}" method="POST" autocomplete="off" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- KARTU 1: Penugasan & Identitas (FIXED: Dihapus overflow-hidden) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80">
            {{-- Ditambahkan rounded-t-2xl agar lengkungan atas tetap ada --}}
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 rounded-t-2xl">
                <h3 class="text-lg font-heading font-bold text-slate-800">1. Penugasan & Identitas</h3>
                <p class="text-sm text-slate-500">Perbarui nama panitia atau ubah penempatan event yang dikelola.</p>
            </div>
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Input Nama Panitia --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Panitia <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $eventAdmin->name) }}" required autocomplete="off"
                            class="w-full px-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                            placeholder="Contoh: Panitia BEM">
                    </div>

                    {{-- Dropdown Pilih Event (Searchable Alpine) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Event yang Dikelola <span class="text-red-500">*</span></label>

                        <div x-data="{
                            open: false,
                            search: '',
                            selected: '{{ old('event_id', $eventAdmin->event_id ?? '') }}',
                            options: [
                                @foreach($events as $event)
                                    { id: '{{ $event->id }}', name: '{{ addslashes($event->name) }}' },
                                @endforeach
                            ],
                            get selectedName() {
                                if (this.selected === '') return '-- Pilih Event Terdaftar --';
                                let option = this.options.find(opt => opt.id == this.selected);
                                return option ? option.name : '-- Pilih Event Terdaftar --';
                            },
                            get filteredOptions() {
                                if (this.search === '') return this.options;
                                return this.options.filter(opt => opt.name.toLowerCase().includes(this.search.toLowerCase()));
                            }
                        }" class="relative" @click.away="open = false">

                            <input type="hidden" name="event_id" :value="selected" required>

                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-3 bg-slate-50 text-left rounded-xl border focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium flex justify-between items-center"
                                :class="open ? 'border-blue-500 bg-white ring-4 ring-blue-500/10' : 'border-slate-200'">
                                <span x-text="selectedName" :class="selected === '' ? 'text-slate-400' : 'text-slate-800'" class="truncate pr-4"></span>
                                <svg class="h-5 w-5 text-slate-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition.opacity.duration.200ms style="display: none;"
                                class="absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-2xl overflow-hidden">

                                <div class="p-2 border-b border-slate-100 bg-slate-50/50">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" x-model="search" placeholder="Ketik untuk mencari event..."
                                            class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-slate-400">
                                    </div>
                                </div>

                                <ul class="max-h-56 overflow-y-auto p-1.5 custom-scrollbar">
                                    <template x-for="option in filteredOptions" :key="option.id">
                                        <li @click="selected = option.id; open = false; search = ''"
                                            class="px-3 py-2.5 rounded-lg text-sm font-medium cursor-pointer transition-colors flex items-center justify-between"
                                            :class="selected == option.id ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100'">
                                            <span x-text="option.name" class="truncate pr-4"></span>
                                            <svg x-show="selected == option.id" class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </li>
                                    </template>
                                    <li x-show="filteredOptions.length === 0" class="px-4 py-4 text-sm text-slate-500 text-center font-medium">
                                        Event tidak ditemukan
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- KARTU 2: Akses Kredensial (FIXED: Dihapus overflow-hidden) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 rounded-t-2xl">
                <h3 class="text-lg font-heading font-bold text-slate-800">2. Akses Login</h3>
                <p class="text-sm text-slate-500">Perbarui email atau reset password untuk panitia ini.</p>
            </div>
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Input Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email (Username) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $eventAdmin->email) }}" required autocomplete="off"
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                                placeholder="panitia@digivote.com">
                        </div>
                    </div>

                    {{-- Input Password dengan Toggle Alpine.js --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password" autocomplete="new-password"
                                class="w-full pl-10 pr-12 py-3 bg-slate-50 text-slate-800 rounded-xl border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all placeholder-slate-400 font-medium"
                                placeholder="Kosongkan jika tidak ingin mengubah">

                            {{-- Toggle Button --}}
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-blue-600 focus:outline-none transition-colors" title="Lihat/Sembunyikan Password">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Hanya diisi jika Anda ingin mereset/mengganti password lama panitia ini.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.event-admins.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition-all shadow-sm shadow-blue-600/20">
                Simpan Perubahan Akun
            </button>
        </div>
    </form>
</div>

{{-- Style opsional agar scrollbar di dropdown search terlihat cantik --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection