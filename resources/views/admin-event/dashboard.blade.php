@extends('layouts.admin-event')

@section('title', 'Dashboard Overview')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    /* Subtle scrollbar untuk elemen tabel/list */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* Animasi Progress Bar */
    .progress-bar-fill {
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush

@section('content')

{{-- ===== HEADER ===== --}}
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6 animate-[fadeIn_0.5s_ease-out]">
    <div>
        <div class="flex items-center gap-3 mb-2">
            @php $statusRaw = strtolower($event->status ?? 'draft'); @endphp
            @if($statusRaw === 'live')
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wide">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                LIVE NOW
            </div>
            @elseif($statusRaw === 'soon')
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-wide">
                ⏳ SEGERA DIMULAI
            </div>
            @elseif($statusRaw === 'done')
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-slate-500/10 border border-slate-500/20 text-slate-400 text-xs font-semibold tracking-wide">
                ✓ EVENT SELESAI
            </div>
            @else
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-400 text-xs font-semibold tracking-wide">
                📝 DRAFT
            </div>
            @endif
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">{{ $event->name }}</h1>
        <p class="text-slate-400 mt-2 text-sm">Pantau statistik perolehan suara secara real-time dari dashboard admin.</p>
    </div>

    <div class="flex items-center gap-3 shrink-0">
        <button onclick="navigator.clipboard.writeText('{{ route('event.show', $event->slug) }}'); this.innerHTML='<svg class=\'w-4 h-4 mr-2 text-emerald-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Disalin!'; setTimeout(()=>this.innerHTML='<svg class=\'w-4 h-4 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3\'></path></svg> Salin Link', 2000)"
            class="inline-flex items-center px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl text-sm font-medium text-slate-200 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3"></path>
            </svg>
            Salin Link
        </button>
        <a href="{{ route('event.show', $event->slug) }}" target="_blank"
            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 border border-indigo-500/50 rounded-xl text-sm font-medium text-white shadow-lg shadow-indigo-500/20 transition-all hover:shadow-indigo-500/40">
            Halaman Publik
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
        </a>
    </div>
</div>

{{-- ===== STAT CARDS ROW ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    {{-- Card 1: Total Votes --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Votes</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ number_format($totalVotes ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="p-2 bg-purple-500/10 text-purple-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Seluruh suara masuk</div>
    </div>

    {{-- Card 2: Total Pemasukan --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Income</p>
                <h3 class="text-2xl font-bold text-white mt-1 truncate" title="Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}">
                    Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-2 bg-emerald-500/10 text-emerald-400 rounded-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Akumulasi pendapatan</div>
    </div>

    {{-- Card 3: Kandidat --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-cyan-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Total Teams</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $leaderboard->count() }}</h3>
            </div>
            <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Kandidat terdaftar event</div>
    </div>

    {{-- Card 4: Pemasukan Hari Ini --}}
    <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 relative overflow-hidden group hover:border-amber-500/30 transition-colors">
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-medium text-slate-400">Income Today</p>
                <h3 class="text-2xl font-bold text-white mt-1 truncate" title="Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}">
                    Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-2 bg-amber-500/10 text-amber-400 rounded-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500">Pemasukan khusus hari ini</div>
    </div>
</div>

{{-- ===== BENTO GRID: LEADER SPOTLIGHT & CHART ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- BENTO 1: Leader Spotlight --}}
    @php $leader = $leaderboard->first(); @endphp
    <div class="bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-3xl p-6 lg:col-span-1 flex flex-col relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>

        <div class="flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
            <h2 class="text-sm font-bold text-slate-200 uppercase tracking-wide">Kandidat Terdepan</h2>
        </div>

        @if($leader && $leader->vote_count > 0)
        <div class="flex-1 flex flex-col items-center justify-center text-center">
            <div class="relative">
                @if($leader->image)
                <img src="{{ asset('storage/' . $leader->image) }}" alt="Foto" class="w-28 h-28 rounded-full object-cover border-4 border-slate-800 shadow-xl relative z-10">
                @else
                <div class="w-28 h-28 rounded-full bg-slate-800 border-4 border-slate-700 flex items-center justify-center text-4xl font-black text-slate-400 shadow-xl relative z-10">
                    {{ $leader->number }}
                </div>
                @endif
                <div class="absolute -inset-4 bg-amber-500/20 blur-xl rounded-full z-0"></div>
                <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-amber-500 text-slate-900 text-xs font-bold px-3 py-1 rounded-full z-20 border-2 border-slate-900">
                    Peringkat #1
                </div>
            </div>

            <h3 class="mt-8 text-2xl font-bold text-white line-clamp-1" title="{{ $leader->name }}">{{ $leader->name }}</h3>
            <p class="text-slate-400 mt-1">Kandidat No. {{ $leader->number }}</p>

            <div class="w-full h-px bg-slate-800 my-6"></div>

            <div class="w-full flex justify-between items-end px-2">
                <div class="text-left">
                    <p class="text-xs text-slate-500 font-medium mb-1">Total Suara</p>
                    <p class="text-3xl font-black text-amber-400">{{ number_format($leader->vote_count, 0, ',', '.') }}</p>
                </div>
                @php $leaderPct = $totalVotes > 0 ? round(($leader->vote_count / $totalVotes) * 100, 1) : 0; @endphp
                <div class="text-right">
                    <p class="text-xs text-slate-500 font-medium mb-1">Persentase</p>
                    <p class="text-2xl font-bold text-white">{{ $leaderPct }}<span class="text-lg text-slate-400 ml-1">%</span></p>
                </div>
            </div>
        </div>
        @else
        <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-800/50 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <p class="text-slate-300 font-semibold mb-1">Belum Ada Suara</p>
            <p class="text-slate-500 text-sm">Data kandidat akan muncul di sini.</p>
        </div>
        @endif
    </div>

    {{-- BENTO 2: Vote Distribution --}}
    <div class="bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-3xl p-6 lg:col-span-2 flex flex-col">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-lg font-bold text-white">Distribusi Suara</h2>
                <p class="text-sm text-slate-400">5 kandidat dengan perolehan tertinggi</p>
            </div>
            <a href="{{ route('admin-event.leaderboard') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/20 px-4 py-2 rounded-xl transition-colors">
                Detail →
            </a>
        </div>

        @if($leaderboard->count() > 0 && $totalVotes > 0)
        <div class="flex-1 flex flex-col justify-center space-y-6">
            @foreach($leaderboard->take(5) as $idx => $team)
            @php
            $pct = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;
            $barColors = match($idx) {
            0 => 'from-amber-400 to-orange-500 shadow-amber-500/20',
            1 => 'from-cyan-400 to-blue-500 shadow-cyan-500/20',
            2 => 'from-purple-400 to-pink-500 shadow-purple-500/20',
            default => 'from-slate-400 to-slate-500 shadow-none'
            };
            @endphp
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500 w-4">#{{ $idx + 1 }}</span>
                        <span class="text-sm font-semibold text-slate-200 truncate max-w-[150px] sm:max-w-[250px]">{{ $team->name }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-400 hidden sm:block">{{ number_format($team->vote_count, 0, ',', '.') }} suara</span>
                        <span class="text-sm font-bold text-white w-12 text-right">{{ $pct }}%</span>
                    </div>
                </div>
                <div class="w-full bg-slate-800/50 rounded-full h-2.5 overflow-hidden border border-slate-700/50">
                    <div class="progress-bar-fill h-full rounded-full bg-gradient-to-r {{ $barColors }} shadow-lg" style="width: 0%" data-width="{{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-800/50 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path>
                </svg>
            </div>
            <p class="text-slate-300 font-semibold mb-1">Data Belum Tersedia</p>
            <p class="text-slate-500 text-sm">Grafik akan tampil setelah voting dimulai.</p>
        </div>
        @endif
    </div>
</div>

{{-- ===== LEADERBOARD TABLE ===== --}}
<div class="bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-3xl overflow-hidden mb-8">
    <div class="px-6 py-5 flex justify-between items-center border-b border-slate-800/80">
        <div>
            <h2 class="text-lg font-bold text-white">Leaderboard Sementara</h2>
            <p class="text-sm text-slate-400">Peringkat 3 kandidat teratas</p>
        </div>
        <a href="{{ route('admin-event.leaderboard') }}" class="text-sm font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-xl transition-colors">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/30 border-b border-slate-800">
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider w-20 text-center">Rank</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Kandidat</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell w-1/3">Distribusi</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Total Suara</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($leaderboard->take(3) as $index => $team)
                @php
                $percentage = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;
                $rankColors = match($index) {
                0 => 'text-amber-400 bg-amber-400/10 border-amber-400/20',
                1 => 'text-slate-300 bg-slate-300/10 border-slate-300/20',
                default => 'text-orange-400 bg-orange-400/10 border-orange-400/20'
                };
                $barColors = match($index) {
                0 => 'from-amber-400 to-orange-500',
                1 => 'from-slate-300 to-slate-400',
                default => 'from-orange-400 to-red-500'
                };
                @endphp
                <tr class="hover:bg-slate-800/20 transition-colors">
                    <td class="py-4 px-6 text-center">
                        <div class="w-8 h-8 mx-auto rounded-lg border {{ $rankColors }} flex items-center justify-center font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-4">
                            @if($team->image)
                            <img src="{{ asset('storage/' . $team->image) }}" alt="Foto" class="w-12 h-12 rounded-full object-cover border border-slate-700">
                            @else
                            <div class="w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-slate-400">
                                {{ $team->number }}
                            </div>
                            @endif
                            <div>
                                <div class="font-semibold text-slate-200">{{ $team->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">Kandidat No. {{ $team->number }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 hidden md:table-cell align-middle">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-slate-800/50 rounded-full h-2 overflow-hidden border border-slate-700/50">
                                <div class="progress-bar-fill h-full rounded-full bg-gradient-to-r {{ $barColors }}" style="width: 0%" data-width="{{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-slate-300 w-12 text-right">{{ $percentage }}%</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="text-xl font-bold text-white">{{ number_format($team->vote_count, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500">Suara</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 px-6 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-800/50 flex items-center justify-center mx-auto mb-4 text-slate-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <p class="font-medium text-slate-300 mb-1">Belum ada kandidat</p>
                        <p class="text-sm text-slate-500 mb-4">Silakan tambahkan kandidat untuk memulai.</p>
                        <a href="{{ route('admin-event.team.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-xl transition-colors">
                            Tambah Kandidat
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Animate progress bars on load for smoother UI feel
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
@endsection