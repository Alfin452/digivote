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

{{-- ===== STAT CARDS ROW ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Total Perputaran Uang (Gross) --}}
    <div class="bg-white border border-slate-200/60 shadow-sm rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-300 hover:shadow-md transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Income (Gross)</p>
                <h3 class="text-2xl font-heading font-bold text-slate-800 mt-1">Rp {{ number_format($totalPlatformIncome, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-400 font-medium relative z-10">Volume Kotor (Paid)</div>
    </div>

    {{-- Keuntungan Bersih Platform (Net) --}}
    <div class="bg-white border border-slate-200/60 shadow-sm rounded-2xl p-6 relative overflow-hidden group hover:border-blue-300 hover:shadow-md transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div>
                <p class="text-sm font-medium text-slate-500">Platform Net Profit</p>
                <h3 class="text-2xl font-heading font-bold text-blue-600 mt-1">Rp {{ number_format($netPlatformProfit ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-400 font-medium relative z-10">Estimasi Omzet Bersih</div>
    </div>

    {{-- Total Event Aktif --}}
    <div class="bg-white border border-slate-200/60 shadow-sm rounded-2xl p-6 relative overflow-hidden group hover:border-indigo-300 hover:shadow-md transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Events</p>
                <h3 class="text-3xl font-heading font-bold text-slate-800 mt-1">{{ number_format($totalEvents, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-400 font-medium relative z-10">Event Terdaftar</div>
    </div>

    {{-- Total Suara Masuk --}}
    <div class="bg-white border border-slate-200/60 shadow-sm rounded-2xl p-6 relative overflow-hidden group hover:border-purple-300 hover:shadow-md transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Platform Votes</p>
                <h3 class="text-3xl font-heading font-bold text-slate-800 mt-1">{{ number_format($totalPlatformVotes, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl border border-purple-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-400 font-medium relative z-10">Vote Sah Diproses</div>
    </div>
</div>

{{-- ===== RECENT EVENTS TABLE ===== --}}
<div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl overflow-hidden mb-8">
    <div class="px-6 py-5 flex justify-between items-center border-b border-slate-100">
        <div>
            <h2 class="text-lg font-heading font-bold text-slate-800">Event Terbaru</h2>
            <p class="text-sm text-slate-500 mt-0.5">Daftar event yang baru saja ditambahkan</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white border border-blue-100 hover:border-blue-600 px-4 py-2 rounded-xl transition-all duration-200">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-200">
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Event</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga / Suara</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Periode</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentEvents as $ev)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="py-4 px-6">
                        <div class="font-semibold text-slate-800">{{ $ev->name }}</div>
                        <div class="text-xs text-slate-400 mt-0.5 font-medium">ID: #{{ str_pad($ev->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($ev->status === 'live')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                            Live
                        </span>
                        @elseif($ev->status === 'soon')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-600 text-[10px] font-bold uppercase tracking-wider">
                            Soon
                        </span>
                        @elseif($ev->status === 'done')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                            Done
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-50 border border-amber-200 text-amber-600 text-[10px] font-bold uppercase tracking-wider">
                            Draft
                        </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-semibold text-slate-700">Rp {{ number_format($ev->price_per_vote, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="text-sm font-medium text-slate-500">
                            {{ \Carbon\Carbon::parse($ev->started_at)->format('d M') }} - {{ \Carbon\Carbon::parse($ev->ended_at)->format('d M Y') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 px-6 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="font-medium">Belum ada event yang didaftarkan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection