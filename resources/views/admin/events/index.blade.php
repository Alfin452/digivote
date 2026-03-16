@extends('layouts.admin')

@section('title', 'Data Event Acara')

@section('content')

{{-- Perbaikan: State Alpine.js langsung di-inline ke x-data agar anti-error --}}
<div x-data="{ 
        isLoading: false, 
        searchQuery: '{{ addslashes(request('search')) }}',
        statusFilter: '{{ request('status') }}',
        sortFilter: '{{ request('sort', 'latest') }}',
        applyFilter() {
            this.isLoading = true;
            this.$refs.filterForm.submit();
        }
    }"
    class="relative">

    {{-- ===== TABLE CARD CONTAINER ===== --}}
    <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl overflow-hidden mb-8">

        {{-- TOOLBAR & FILTERS --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/30">
            <form x-ref="filterForm" method="GET" action="{{ route('admin.events.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                {{-- Kiri: Search & Filters --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-72 group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text"
                            name="search"
                            x-model="searchQuery"
                            @input.debounce.700ms="applyFilter()"
                            placeholder="Cari nama event atau slug..."
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder:text-slate-400 shadow-sm">
                    </div>

                    {{-- Filter Status --}}
                    <div class="relative w-full sm:w-40">
                        <select name="status" @change="applyFilter()" x-model="statusFilter" class="w-full pl-4 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                            <option value="">Semua Status</option>
                            <option value="live">Live (Aktif)</option>
                            <option value="soon">Soon (Akan Datang)</option>
                            <option value="draft">Draft (Konsep)</option>
                            <option value="done">Done (Selesai)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Urutkan (Sort) --}}
                    <div class="relative w-full sm:w-44">
                        <select name="sort" @change="applyFilter()" x-model="sortFilter" class="w-full pl-4 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_desc">Harga Tertinggi</option>
                            <option value="price_asc">Harga Terendah</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Action Button --}}
                <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-sm font-semibold text-white rounded-xl shadow-sm hover:shadow-md shadow-blue-600/20 transition-all duration-200 shrink-0 w-full md:w-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Event Baru
                </a>
            </form>
        </div>

        {{-- TABLE WRAPPER --}}
        <div class="overflow-x-auto relative">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Event Info</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Harga / Vote</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Periode Acara</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- SKELETON LOADING (Hanya Tampil Saat isLoading = true) --}}
                <tbody x-show="isLoading" x-cloak class="divide-y divide-slate-100" style="display: none;">
                    @for ($i = 0; $i < 4; $i++)
                        <tr class="animate-pulse bg-white">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-200 shrink-0"></div>
                                <div class="space-y-2">
                                    <div class="h-4 w-32 bg-slate-200 rounded"></div>
                                    <div class="h-3 w-20 bg-slate-100 rounded"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="space-y-2">
                                <div class="h-4 w-24 bg-slate-200 rounded"></div>
                                <div class="h-3 w-16 bg-slate-100 rounded"></div>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="space-y-2">
                                <div class="h-4 w-28 bg-slate-200 rounded"></div>
                                <div class="h-3 w-20 bg-slate-100 rounded"></div>
                            </div>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <div class="h-6 w-16 bg-slate-200 rounded-md mx-auto"></div>
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

                {{-- REAL DATA TABLE (Sembunyi saat loading) --}}
                <tbody x-show="!isLoading" class="divide-y divide-slate-100">
                    @forelse($events as $event)
                    <tr class="hover:bg-slate-50/80 transition-colors group bg-white">

                        {{-- Kolom Info Event --}}
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-4">
                                @if($event->logo_path)
                                <img src="{{ asset('storage/' . $event->logo_path) }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm shrink-0">
                                @else
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 flex items-center justify-center font-bold text-slate-500 shadow-sm shrink-0">
                                    EV
                                </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-800 text-base">{{ $event->name }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[11px] text-blue-600 font-mono font-medium bg-blue-50 px-1.5 py-0.5 rounded">/{{ $event->slug }}</span>
                                        @if($event->org)
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-xs text-slate-500 font-medium">{{ $event->org }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom Harga --}}
                        <td class="py-5 px-6">
                            <div class="text-sm font-bold text-slate-800">Rp {{ number_format($event->price_per_vote, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500 mt-1 font-medium bg-slate-100 inline-block px-2 py-0.5 rounded-md">Min: {{ $event->min_vote }} vote</div>
                        </td>

                        {{-- Kolom Periode --}}
                        <td class="py-5 px-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($event->started_at)->format('d M Y') }}</span>
                                <span class="text-xs text-slate-400 mt-0.5">s/d {{ \Carbon\Carbon::parse($event->ended_at)->format('d M Y') }}</span>
                            </div>
                        </td>

                        {{-- Kolom Status --}}
                        <td class="py-5 px-6 text-center">
                            @if($event->status === 'live')
                            <div class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-600 text-[11px] font-bold uppercase tracking-wider">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Live
                            </div>
                            @elseif($event->status === 'done')
                            <div class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-slate-100 border border-slate-200 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Done
                            </div>
                            @elseif($event->status === 'soon')
                            <div class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-600 text-[11px] font-bold uppercase tracking-wider">
                                Soon
                            </div>
                            @else
                            <div class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-amber-50 border border-amber-200 text-amber-600 text-[11px] font-bold uppercase tracking-wider">
                                Draft
                            </div>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="py-5 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2 bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 rounded-lg text-slate-400 hover:text-blue-600 shadow-sm transition-all" title="Edit Event">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" id="delete-form-{{ $event->id }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $event->id }})" class="p-2 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-300 rounded-lg text-slate-400 hover:text-red-500 shadow-sm transition-all" title="Hapus Event">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading font-bold text-slate-700 text-lg">Tidak ada data ditemukan</h3>
                                <p class="text-sm mt-1 text-slate-500">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
        <div class="p-5 border-t border-slate-100 bg-white">
            {{ $events->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    // Hanya sisakan fungsi SweetAlert di sini, AlpineJS sudah berjalan di atas
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Event Ini?',
            text: "Data kandidat dan suara terkait event ini akan ikut terhapus!",
            icon: 'warning',
            iconColor: '#EF4444',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg px-6 py-2.5 transition-colors shadow-sm',
                cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors shadow-sm',
                popup: 'rounded-3xl shadow-2xl border border-slate-100',
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