@extends('layouts.admin')

@section('title', 'Master Overview')

@push('scripts')
<style>
    /* Animasi Progress Bar */
    .progress-bar-fill {
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bars = document.querySelectorAll('.progress-bar-fill');
        setTimeout(() => {
            bars.forEach(bar => {
                const targetWidth = bar.getAttribute('data-width');
                if (targetWidth) {
                    bar.style.width = targetWidth;
                }
            });
        }, 150);
    });
</script>
@endpush

@section('content')

{{-- ===== HEADER ===== --}}
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Master Overview</h1>
        <p class="text-slate-400 mt-2 text-sm">Pantau seluruh aktivitas dan perputaran transaksi di platform DigiVote.</p>
    </div>
</div>

{{-- ===== STAT CARDS ROW ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    {{-- Total Perputaran Uang --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Income (Platform)</p>
                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPlatformIncome, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2 bg-emerald-500/10 text-emerald-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Gross Volume (Paid)</div>
    </div>

    {{-- Total Event Aktif --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-blue-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Events</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ number_format($totalEvents, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Event Terdaftar</div>
    </div>

    {{-- Total Suara Masuk --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Platform Votes</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ number_format($totalPlatformVotes, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2 bg-purple-500/10 text-purple-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Vote Sah Diproses</div>
    </div>
</div>

{{-- ===== RECENT EVENTS TABLE ===== --}}
<div class="bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-3xl overflow-hidden mb-8">
    <div class="px-6 py-5 flex justify-between items-center border-b border-slate-800/80">
        <div>
            <h2 class="text-lg font-bold text-white">Event Terbaru</h2>
            <p class="text-sm text-slate-400">Daftar event yang baru saja ditambahkan</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-xl transition-colors">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/30 border-b border-slate-800">
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Event</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Status</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Harga / Suara</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Periode</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($recentEvents as $ev)
                <tr class="hover:bg-slate-800/20 transition-colors">
                    <td class="py-4 px-6">
                        <div class="font-semibold text-slate-200">{{ $ev->name }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">ID: #{{ str_pad($ev->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($ev->status === 'active')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase">
                            Active
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-800 border border-slate-700 text-slate-400 text-[10px] font-bold uppercase">
                            {{ $ev->status }}
                        </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-slate-200">Rp {{ number_format($ev->price_per_vote, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="text-sm text-slate-300">
                            {{ \Carbon\Carbon::parse($ev->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($ev->end_date)->format('d M Y') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 px-6 text-center">
                        <p class="font-medium text-slate-300">Belum ada event</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection