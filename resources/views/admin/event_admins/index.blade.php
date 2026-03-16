@extends('layouts.admin')

@section('title', 'Akun Panitia')

@section('content')

{{-- Alpine.js Wrapper untuk Debounce, Loader, & State Form --}}
<div x-data="{ 
        isLoading: false, 
        searchQuery: '{{ addslashes(request('search')) }}',
        eventFilter: '{{ request('event_filter') }}',
        sortFilter: '{{ request('sort', 'latest') }}',
        applyFilter() {
            this.isLoading = true;
            this.$refs.filterForm.submit();
        }
    }"
    class="relative pb-10">

    {{-- KARTU TABEL UTAMA --}}
    <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl overflow-hidden">

        {{-- TOOLBAR: Search & Filters (Background abu-abu sangat muda) --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/40">
            <form x-ref="filterForm" method="GET" action="{{ route('admin.event-admins.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                {{-- Group Kiri: Filter & Search --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">

                    {{-- Search Input (Live Debounce 700ms) --}}
                    <div class="relative w-full sm:w-72 group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text"
                            name="search"
                            x-model="searchQuery"
                            @input.debounce.700ms="applyFilter()"
                            placeholder="Cari nama panitia atau email..."
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder:text-slate-400 shadow-sm font-medium">
                    </div>

                    {{-- Dropdown Status Tautan Event --}}
                    <div class="relative w-full sm:w-48">
                        <select name="event_filter" @change="applyFilter()" x-model="eventFilter" class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                            <option value="">Semua Akun</option>
                            <option value="linked">Sudah Ada Event</option>
                            <option value="unlinked">Belum Ditautkan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Dropdown Urutkan --}}
                    <div class="relative w-full sm:w-40">
                        <select name="sort" @change="applyFilter()" x-model="sortFilter" class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="name_asc">Nama (A-Z)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Action Button (Kanan) --}}
                <a href="{{ route('admin.event-admins.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-sm font-semibold text-white rounded-xl shadow-sm hover:shadow-md shadow-blue-600/20 transition-all duration-200 shrink-0 w-full md:w-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Akun Panitia
                </a>
            </form>
        </div>

        {{-- AREA TABEL --}}
        <div class="overflow-x-auto relative">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Informasi Panitia</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Email (Login Akses)</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Penempatan Event</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Dibuat</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- ===== SKELETON LOADING (Ditampilkan oleh Alpine.js) ===== --}}
                <tbody x-show="isLoading" x-cloak class="divide-y divide-slate-100" style="display: none;">
                    @for ($i = 0; $i < 5; $i++)
                        <tr class="animate-pulse bg-white">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 shrink-0"></div>
                                <div class="h-4 w-32 bg-slate-200 rounded"></div>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="h-6 w-48 bg-slate-200 rounded-md"></div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="h-8 w-36 bg-slate-200 rounded-lg"></div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="space-y-2">
                                <div class="h-4 w-24 bg-slate-200 rounded"></div>
                                <div class="h-3 w-12 bg-slate-100 rounded"></div>
                            </div>
                        </td>
                        <td class="py-5 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="h-8 w-8 bg-slate-200 rounded-lg"></div>
                                <div class="h-8 w-8 bg-slate-200 rounded-lg"></div>
                            </div>
                        </td>
                        </tr>
                        @endfor
                </tbody>

                {{-- ===== REAL DATA TABEL ===== --}}
                <tbody x-show="!isLoading" class="divide-y divide-slate-100">
                    @forelse($admins as $adm)
                    <tr class="hover:bg-slate-50/60 transition-colors group bg-white">

                        {{-- Kolom 1: Profil Panitia --}}
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 border border-blue-200 flex items-center justify-center font-bold text-blue-700 shrink-0 shadow-sm">
                                    {{ strtoupper(substr($adm->name, 0, 1)) }}
                                </div>
                                <div class="font-bold text-slate-800 text-sm">{{ $adm->name }}</div>
                            </div>
                        </td>

                        {{-- Kolom 2: Email Monospace --}}
                        <td class="py-5 px-6">
                            <div class="text-[13px] font-medium text-slate-600 font-mono bg-slate-100 px-2.5 py-1.5 rounded-md inline-flex items-center gap-2 border border-slate-200">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $adm->email }}
                            </div>
                        </td>

                        {{-- Kolom 3: Status Tautan Event --}}
                        <td class="py-5 px-6">
                            @if($adm->event)
                            <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ Str::limit($adm->event->name, 35) }}
                            </div>
                            @else
                            <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 border border-red-200 text-red-600 text-xs font-semibold shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Belum Ditautkan
                            </div>
                            @endif
                        </td>

                        {{-- Kolom 4: Tanggal --}}
                        <td class="py-5 px-6">
                            <div class="text-sm font-semibold text-slate-700">
                                {{ $adm->created_at->format('d M Y') }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5 font-medium">{{ $adm->created_at->format('H:i') }} WIB</div>
                        </td>

                        {{-- Kolom 5: Aksi (Sembunyi sebelum di-hover di layar besar) --}}
                        <td class="py-5 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-200">

                                {{-- Edit Button --}}
                                <a href="{{ route('admin.event-admins.edit', $adm->id) }}" class="p-2 bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 rounded-lg text-slate-400 hover:text-blue-600 shadow-sm transition-all" title="Edit Akun">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.event-admins.destroy', $adm->id) }}" method="POST" id="delete-form-{{ $adm->id }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $adm->id }})" class="p-2 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-300 rounded-lg text-slate-400 hover:text-red-500 shadow-sm transition-all" title="Hapus Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    {{-- State Data Kosong --}}
                    <tr>
                        <td colspan="5" class="py-20 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading font-bold text-slate-700 text-lg">Tidak ada panitia ditemukan</h3>
                                <p class="text-sm mt-1 text-slate-500">Sesuaikan kata pencarian atau buat akun panitia baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination dengan preservasi Request query (search/filter) --}}
        @if($admins->hasPages())
        <div class="p-5 border-t border-slate-100 bg-white">
            {{ $admins->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    // SweetAlert Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Akun Panitia?',
            text: "Panitia ini tidak akan bisa login lagi ke sistem!",
            icon: 'warning',
            iconColor: '#EF4444',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg px-6 py-2.5 transition-colors shadow-sm',
                cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors shadow-sm',
                popup: 'rounded-3xl shadow-xl border border-slate-100',
                title: 'font-heading font-bold text-slate-800'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection