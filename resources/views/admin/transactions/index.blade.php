@extends('layouts.admin')

@section('title', 'Semua Transaksi Global')

@section('content')

{{-- ===== SUMMARY CARDS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 mt-4">

    {{-- Card: Total Dana Masuk --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between group hover:border-emerald-300 hover:shadow-md transition-all duration-300">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Dana Masuk (Sukses)</p>
            <p class="text-3xl font-heading font-black text-slate-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-emerald-50 text-emerald-500 border border-emerald-100 rounded-xl group-hover:scale-110 transition-transform duration-300 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Card: Total Menunggu Pembayaran --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between group hover:border-amber-300 hover:shadow-md transition-all duration-300">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Menunggu Pembayaran</p>
            <p class="text-3xl font-heading font-black text-slate-800">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-amber-50 text-amber-500 border border-amber-100 rounded-xl group-hover:scale-110 transition-transform duration-300 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>


{{-- ===== TABEL TRANSAKSI DENGAN ALPINE.JS ===== --}}
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
    class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-8">

    {{-- TOOLBAR (Search & Filter) --}}
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/40">

        <div>
            <h2 class="font-heading font-bold text-slate-800 text-lg">Riwayat Transaksi</h2>
            <p class="text-sm text-slate-500 mt-0.5">Daftar lengkap invoice pembelian suara.</p>
        </div>

        <form x-ref="filterForm" action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

            {{-- Search Box dengan Debounce --}}
            <div class="relative w-full sm:w-64 group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" x-model="searchQuery" @input.debounce.700ms="applyFilter()"
                    placeholder="Cari pemilih, Xendit ID..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder:text-slate-400 shadow-sm">
            </div>

            {{-- Filter Status --}}
            <div class="relative w-full sm:w-44">
                <select name="status" x-model="statusFilter" @change="applyFilter()" class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                    <option value="">Semua Status</option>
                    <option value="paid">Sukses (Paid)</option>
                    <option value="pending">Tertunda (Pending)</option>
                    <option value="expired">Kedaluwarsa</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            {{-- Sortir --}}
            <div class="relative w-full sm:w-44">
                <select name="sort" x-model="sortFilter" @change="applyFilter()" class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm appearance-none cursor-pointer font-medium">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="amount_desc">Nominal Tertinggi</option>
                    <option value="amount_asc">Nominal Terendah</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

        </form>
    </div>

    <div class="overflow-x-auto relative">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-white border-b border-slate-100">
                    <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tgl / Ref Xendit</th>
                    <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Event & Kandidat</th>
                    <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pemilih</th>
                    <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Pembayaran</th>
                    <th class="py-4 px-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>

            {{-- ===== SKELETON LOADING ===== --}}
            <tbody x-show="isLoading" x-cloak class="divide-y divide-slate-100" style="display: none;">
                @for ($i = 0; $i < 5; $i++)
                    <tr class="animate-pulse bg-white">
                    <td class="py-4 px-6 space-y-2">
                        <div class="h-4 w-28 bg-slate-200 rounded"></div>
                        <div class="h-3 w-36 bg-slate-100 rounded"></div>
                    </td>
                    <td class="py-4 px-6 space-y-2">
                        <div class="h-4 w-40 bg-slate-200 rounded"></div>
                        <div class="h-3 w-24 bg-slate-100 rounded"></div>
                    </td>
                    <td class="py-4 px-6 space-y-2">
                        <div class="h-4 w-32 bg-slate-200 rounded"></div>
                        <div class="h-3 w-16 bg-slate-100 rounded"></div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="h-5 w-24 bg-slate-200 rounded"></div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="h-6 w-16 bg-slate-200 rounded-full mx-auto"></div>
                    </td>
                    </tr>
                    @endfor
            </tbody>

            {{-- ===== REAL DATA TABEL ===== --}}
            <tbody x-show="!isLoading" class="divide-y divide-slate-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50/60 transition-colors group bg-white">

                    {{-- Waktu & Xendit ID --}}
                    <td class="py-4 px-6">
                        <div class="text-sm font-semibold text-slate-800">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-1 bg-slate-100 px-1.5 py-0.5 rounded-md inline-block border border-slate-200" title="Xendit ID">{{ $trx->xendit_id }}</div>
                    </td>

                    {{-- Event & Kandidat --}}
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-blue-600">{{ $trx->event->name ?? 'Event Dihapus' }}</div>
                        <div class="text-xs text-slate-500 mt-1 font-medium flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                            {{ $trx->team->name ?? 'Kandidat Dihapus' }}
                        </div>
                    </td>

                    {{-- Pemilih & Suara --}}
                    <td class="py-4 px-6">
                        <div class="text-sm text-slate-700 font-bold flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                            </div>
                            {{ $trx->voter_name ?? 'Hamba Allah' }}
                        </div>
                        <div class="text-xs text-indigo-600 mt-1 font-bold ml-8">+{{ $trx->vote_qty }} Suara</div>
                    </td>

                    {{-- Total Amount --}}
                    <td class="py-4 px-6">
                        <div class="text-sm font-heading font-black text-slate-800">Rp {{ number_format($trx->amount, 0, ',', '.') }}</div>
                    </td>

                    {{-- Status --}}
                    <td class="py-4 px-6 text-center">
                        @if($trx->status === 'paid')
                        <span class="inline-flex px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">PAID</span>

                        @elseif($trx->status === 'pending')
                        <span class="inline-flex px-3 py-1 bg-amber-50 text-amber-600 border border-amber-200 rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">PENDING</span>

                        @elseif($trx->status === 'expired')
                        <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-500 border border-slate-200 rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">EXPIRED</span>

                        @else
                        <span class="inline-flex px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">{{ $trx->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="font-heading font-bold text-slate-700 text-lg">Tidak ada transaksi ditemukan</h3>
                            <p class="text-sm mt-1 text-slate-500">Coba ubah status filter atau kata kunci pencarian Anda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="p-5 border-t border-slate-100 bg-white">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection