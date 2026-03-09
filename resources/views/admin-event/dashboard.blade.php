@extends('layouts.admin-event')

@section('title', 'Dashboard Overview')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --cyan: #06b6d4;
        --cyan-glow: rgba(6, 182, 212, 0.15);
        --amber: #f59e0b;
        --emerald: #10b981;
        --purple: #a855f7;
        --surface: #0f1117;
        --surface-2: #161b27;
        --border: rgba(255, 255, 255, 0.08);
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--surface);
        color: #e2e8f0;
    }

    .dash-title {
        font-family: 'Syne', sans-serif;
    }

    /* Ambient Background Glows */
    .ambient-glow {
        position: fixed;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.15;
        z-index: -1;
        pointer-events: none;
    }

    .glow-1 {
        top: -100px;
        left: -100px;
        background: var(--cyan);
    }

    .glow-2 {
        bottom: -100px;
        right: -100px;
        background: var(--purple);
    }

    /* Noise texture overlay */
    .noise {
        position: relative;
    }

    .noise::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        border-radius: inherit;
        z-index: 0;
        mix-blend-mode: overlay;
    }

    /* Glow card */
    .glow-card {
        background: linear-gradient(145deg, var(--surface-2), rgba(22, 27, 39, 0.8));
        border: 1px solid var(--border);
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .glow-card>* {
        position: relative;
        z-index: 10;
    }

    /* Ensure content is above noise */

    .glow-card:hover {
        transform: translateY(-4px);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .glow-card.cyan:hover {
        box-shadow: 0 10px 40px -10px rgba(6, 182, 212, 0.25);
        border-color: rgba(6, 182, 212, 0.3);
    }

    .glow-card.amber:hover {
        box-shadow: 0 10px 40px -10px rgba(245, 158, 11, 0.25);
        border-color: rgba(245, 158, 11, 0.3);
    }

    .glow-card.emerald:hover {
        box-shadow: 0 10px 40px -10px rgba(16, 185, 129, 0.25);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .glow-card.purple:hover {
        box-shadow: 0 10px 40px -10px rgba(168, 85, 247, 0.25);
        border-color: rgba(168, 85, 247, 0.3);
    }

    /* Stat icon blob */
    .icon-blob {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Animated pulse dot */
    @keyframes pulse-ring {
        0% {
            transform: scale(0.8);
            opacity: 1;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }

        100% {
            transform: scale(2.2);
            opacity: 0;
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    .live-dot {
        position: relative;
        display: inline-flex;
    }

    .live-dot::before {
        content: '';
        position: absolute;
        inset: -4px;
        background: transparent;
        border-radius: 50%;
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    .live-dot-inner {
        width: 8px;
        height: 8px;
        background: var(--emerald);
        border-radius: 50%;
        position: relative;
        z-index: 1;
        box-shadow: 0 0 8px var(--emerald);
    }

    /* Progress bar */
    .progress-bar {
        transition: width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Rank badges */
    .rank-1 {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(217, 119, 6, 0.05));
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #fbbf24;
        text-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
    }

    .rank-2 {
        background: linear-gradient(135deg, rgba(148, 163, 184, 0.15), rgba(100, 116, 139, 0.05));
        border: 1px solid rgba(148, 163, 184, 0.4);
        color: #cbd5e1;
    }

    .rank-3 {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.15), rgba(234, 88, 12, 0.05));
        border: 1px solid rgba(249, 115, 22, 0.4);
        color: #fdba74;
    }

    /* Entry animation */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-1 {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .anim-2 {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
    }

    .anim-3 {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
    }

    .anim-4 {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
    }

    .anim-5 {
        animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both;
    }

    /* Table row styling */
    .custom-table th {
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border);
    }

    .custom-table tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .custom-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
        transform: scale(1.005);
    }

    .custom-table tbody tr:last-child {
        border-bottom: none;
    }

    /* Vote bar colors */
    .bar-rank-1 {
        background: linear-gradient(90deg, #f59e0b, #f97316);
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
    }

    .bar-rank-2 {
        background: linear-gradient(90deg, #06b6d4, #3b82f6);
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
    }

    .bar-rank-3 {
        background: linear-gradient(90deg, #a855f7, #ec4899);
        box-shadow: 0 0 10px rgba(168, 85, 247, 0.4);
    }

    .bar-rank-n {
        background: linear-gradient(90deg, #475569, #64748b);
    }

    /* Scrollbar */
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
</style>
@endpush

@section('content')
<div class="ambient-glow glow-1"></div>
<div class="ambient-glow glow-2"></div>

{{-- ===== HEADER ===== --}}
<div class="mb-10 flex flex-col lg:flex-row lg:justify-between lg:items-end gap-6 anim-1 relative z-10">
    <div>
        <div class="flex items-center gap-3 mb-3">
            @php $statusRaw = strtolower($event->status ?? 'draft'); @endphp
            @if($statusRaw === 'live')
            <span class="inline-flex items-center gap-2 text-[11px] font-bold text-emerald-400 tracking-widest bg-emerald-500/10 border border-emerald-500/20 rounded-full px-3 py-1.5 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                <span class="live-dot"><span class="live-dot-inner"></span></span>
                LIVE NOW
            </span>
            @elseif($statusRaw === 'soon')
            <span class="inline-flex items-center text-[11px] font-bold tracking-widest text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-full px-3 py-1.5">
                ⏳ SEGERA DIMULAI
            </span>
            @elseif($statusRaw === 'done')
            <span class="inline-flex items-center text-[11px] font-bold tracking-widest text-slate-400 bg-slate-700/40 border border-slate-600/30 rounded-full px-3 py-1.5">
                ✓ EVENT SELESAI
            </span>
            @else
            <span class="inline-flex items-center text-[11px] font-bold tracking-widest text-slate-500 bg-slate-800/60 border border-slate-700/30 rounded-full px-3 py-1.5">
                📝 DRAFT
            </span>
            @endif
        </div>
        <h1 class="dash-title text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">{{ $event->name }}</h1>
        <p class="text-slate-400 mt-2 text-sm font-medium">Pantau statistik perolehan suara secara real-time dari dashboard admin.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3 shrink-0">
        <button onclick="navigator.clipboard.writeText('{{ route('event.show', $event->slug) }}'); this.innerHTML='<svg class=\'w-4 h-4 mr-2 text-emerald-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Disalin!'; setTimeout(()=>this.innerHTML='<svg class=\'w-4 h-4 mr-2 opacity-70\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3\'></path></svg> Salin Link', 2000)"
            class="inline-flex items-center px-5 py-2.5 bg-slate-800/50 backdrop-blur-md border border-slate-700/80 rounded-xl text-sm font-semibold text-slate-200 hover:bg-slate-700 hover:text-white transition-all shadow-sm">
            <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3"></path>
            </svg>
            Salin Link
        </button>
        <a href="{{ route('event.show', $event->slug) }}" target="_blank"
            class="inline-flex items-center px-5 py-2.5 bg-cyan-500/10 border border-cyan-500/30 rounded-xl text-sm font-semibold text-cyan-400 hover:bg-cyan-500 hover:text-white transition-all shadow-[0_0_15px_rgba(6,182,212,0.15)] hover:shadow-[0_0_20px_rgba(6,182,212,0.3)]">
            Halaman Publik
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
        </a>
    </div>
</div>

{{-- ===== STAT CARDS ROW ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    {{-- Total Votes --}}
    <div class="glow-card purple noise p-6 anim-2">
        <div class="flex items-start justify-between mb-6">
            <div class="icon-blob bg-purple-500/20 shadow-[0_0_15px_rgba(168,85,247,0.2)] text-purple-400 border border-purple-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-800/50 px-2.5 py-1 rounded-md">Total Votes</span>
        </div>
        <div class="dash-title text-4xl font-extrabold text-white tracking-tight">{{ number_format($totalVotes ?? 0, 0, ',', '.') }}</div>
        <div class="text-sm text-slate-400 mt-2 font-medium">Seluruh suara masuk</div>
    </div>

    {{-- Total Pemasukan --}}
    <div class="glow-card emerald noise p-6 anim-2">
        <div class="flex items-start justify-between mb-6">
            <div class="icon-blob bg-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.2)] text-emerald-400 border border-emerald-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-800/50 px-2.5 py-1 rounded-md">Total Income</span>
        </div>
        <div class="dash-title text-3xl font-extrabold text-white leading-tight truncate" title="Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}">
            Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
        </div>
        <div class="text-sm text-slate-400 mt-2 font-medium">Akumulasi pendapatan</div>
    </div>

    {{-- Kandidat --}}
    <div class="glow-card cyan noise p-6 anim-3">
        <div class="flex items-start justify-between mb-6">
            <div class="icon-blob bg-cyan-500/20 shadow-[0_0_15px_rgba(6,182,212,0.2)] text-cyan-400 border border-cyan-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-800/50 px-2.5 py-1 rounded-md">Teams</span>
        </div>
        <div class="dash-title text-4xl font-extrabold text-white tracking-tight">{{ $leaderboard->count() }}</div>
        <div class="text-sm text-slate-400 mt-2 font-medium">Kandidat terdaftar</div>
    </div>

    {{-- Pemasukan Hari Ini --}}
    <div class="glow-card amber noise p-6 anim-3">
        <div class="flex items-start justify-between mb-6">
            <div class="icon-blob bg-amber-500/20 shadow-[0_0_15px_rgba(245,158,11,0.2)] text-amber-400 border border-amber-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-amber-400 uppercase tracking-widest bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-md">Today</span>
        </div>
        <div class="dash-title text-3xl font-extrabold text-white leading-tight truncate" title="Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}">
            Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}
        </div>
        <div class="text-sm text-slate-400 mt-2 font-medium">Pemasukan hari ini</div>
    </div>
</div>

{{-- ===== LEADER SPOTLIGHT + VOTE DISTRIBUTION ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Leader Spotlight --}}
    @php $leader = $leaderboard->first(); @endphp
    <div class="glow-card amber noise lg:col-span-1 p-7 anim-4">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-400 to-orange-500"></div>

        <div class="flex items-center gap-2 mb-8 mt-1">
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
            <span class="text-xs font-bold text-amber-400 uppercase tracking-widest drop-shadow-[0_0_8px_rgba(245,158,11,0.5)]">Kandidat Terdepan</span>
        </div>

        @if($leader && $leader->vote_count > 0)
        <div class="flex items-center gap-5 mb-8">
            @if($leader->image)
            <img src="{{ asset('storage/' . $leader->image) }}" alt="Foto" class="w-20 h-20 rounded-2xl object-cover border-2 border-amber-500/30 shadow-[0_10px_25px_-5px_rgba(245,158,11,0.3)]">
            @else
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-600/30 border-2 border-amber-500/30 flex items-center justify-center dash-title text-3xl font-black text-amber-400 shadow-[0_10px_25px_-5px_rgba(245,158,11,0.3)]">
                {{ $leader->number }}
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="dash-title text-2xl font-extrabold text-white leading-tight truncate" title="{{ $leader->name }}">{{ $leader->name }}</div>
                <div class="inline-block px-3 py-1 bg-slate-800/80 border border-slate-700 rounded-lg text-sm text-slate-300 mt-2 font-medium">Kandidat No. {{ $leader->number }}</div>
            </div>
        </div>

        <div class="h-px bg-gradient-to-r from-transparent via-amber-500/20 to-transparent w-full mb-6"></div>

        <div class="flex items-end justify-between">
            <div>
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Total Suara</div>
                <div class="dash-title text-4xl lg:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-amber-300 to-orange-500 drop-shadow-sm">{{ number_format($leader->vote_count, 0, ',', '.') }}</div>
            </div>
            @php $leaderPct = $totalVotes > 0 ? round(($leader->vote_count / $totalVotes) * 100, 1) : 0; @endphp
            <div class="text-right">
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Persentase</div>
                <div class="dash-title text-3xl lg:text-4xl font-extrabold text-white">{{ $leaderPct }}<span class="text-xl text-slate-400 font-medium ml-1">%</span></div>
            </div>
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-800/80 border border-slate-700 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <p class="text-slate-300 font-semibold text-lg mb-1">Belum Ada Suara</p>
            <p class="text-slate-500 text-sm">Statistik akan muncul setelah voting dimulai.</p>
        </div>
        @endif
    </div>

    {{-- Vote Distribution Chart --}}
    <div class="glow-card cyan noise lg:col-span-2 p-7 anim-4 flex flex-col">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="dash-title text-xl font-bold text-white">Distribusi Suara</h2>
                <p class="text-sm text-slate-400 mt-1">Perbandingan perolehan suara antar 5 kandidat teratas</p>
            </div>
            <a href="{{ route('admin-event.leaderboard') }}" class="hidden sm:inline-flex text-xs font-bold text-cyan-400 hover:text-cyan-300 transition-colors bg-cyan-500/10 border border-cyan-500/20 rounded-lg px-4 py-2 hover:bg-cyan-500/20">
                Lihat Lengkap →
            </a>
        </div>

        @if($leaderboard->count() > 0 && $totalVotes > 0)
        <div class="space-y-5 flex-1 flex flex-col justify-center">
            @foreach($leaderboard->take(5) as $idx => $team)
            @php
            $pct = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;
            $barClass = match($idx) { 0 => 'bar-rank-1', 1 => 'bar-rank-2', 2 => 'bar-rank-3', default => 'bar-rank-n' };
            $numColor = match($idx) { 0 => 'text-amber-400', 1 => 'text-cyan-400', 2 => 'text-purple-400', default => 'text-slate-400' };
            @endphp
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-black {{ $numColor }} w-6 text-right">#{{ $idx + 1 }}</span>
                        <span class="text-[15px] font-semibold text-slate-200 truncate max-w-[150px] sm:max-w-[250px]">{{ $team->name }}</span>
                    </div>
                    <div class="flex items-center gap-4 shrink-0">
                        <span class="text-sm font-semibold text-slate-400 hidden sm:inline-block">{{ number_format($team->vote_count, 0, ',', '.') }} suara</span>
                        <span class="text-sm font-black text-white w-14 text-right bg-slate-800/80 rounded px-2 py-0.5">{{ $pct }}%</span>
                    </div>
                </div>
                <div class="w-full bg-slate-800/60 border border-slate-700/50 rounded-full h-2.5 overflow-hidden">
                    <div class="{{ $barClass }} progress-bar h-full rounded-full" style="width: 0%" data-width="{{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        @if($leaderboard->count() > 5)
        <div class="mt-6 pt-4 border-t border-slate-800/60 text-center">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">+{{ $leaderboard->count() - 5 }} kandidat lainnya</span>
        </div>
        @endif

        @else
        <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-800/80 border border-slate-700 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path>
                </svg>
            </div>
            <p class="text-slate-300 font-semibold text-lg mb-1">Data Belum Tersedia</p>
            <p class="text-slate-500 text-sm">Grafik distribusi akan tampil jika ada suara yang masuk.</p>
        </div>
        @endif
    </div>
</div>

{{-- ===== LEADERBOARD TABLE ===== --}}
<div class="glow-card noise anim-5 overflow-hidden mb-10">
    <div class="px-7 py-6 flex justify-between items-center bg-slate-800/20 border-b border-slate-800/60">
        <div>
            <h2 class="dash-title text-xl font-bold text-white">Leaderboard Sementara</h2>
            <p class="text-sm text-slate-400 mt-1">Top 3 kandidat dengan perolehan suara tertinggi</p>
        </div>
        <a href="{{ route('admin-event.leaderboard') }}" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 transition-colors bg-cyan-500/10 border border-cyan-500/20 rounded-lg px-4 py-2 hover:bg-cyan-500/20">
            Papan Lengkap →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left custom-table">
            <thead>
                <tr class="bg-slate-900/40">
                    <th class="py-4 px-7 text-[10px] font-bold text-slate-500 uppercase tracking-widest w-20 text-center">Rank</th>
                    <th class="py-4 px-7 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kandidat</th>
                    <th class="py-4 px-7 text-[10px] font-bold text-slate-500 uppercase tracking-widest hidden md:table-cell w-1/3">Distribusi Bar</th>
                    <th class="py-4 px-7 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Perolehan Suara</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaderboard->take(3) as $index => $team)
                @php
                $percentage = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;
                $rankClass = match($index) { 0 => 'rank-1', 1 => 'rank-2', default => 'rank-3' };
                $barClass = match($index) { 0 => 'bar-rank-1', 1 => 'bar-rank-2', default => 'bar-rank-3' };
                @endphp
                <tr>
                    <td class="py-5 px-7 text-center">
                        <div class="w-10 h-10 rounded-xl {{ $rankClass }} flex items-center justify-center dash-title font-extrabold text-base mx-auto">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    <td class="py-5 px-7">
                        <div class="flex items-center gap-4">
                            @if($team->image)
                            <img src="{{ asset('storage/' . $team->image) }}" alt="Foto" class="w-12 h-12 rounded-xl object-cover border border-slate-700">
                            @else
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-700 to-slate-800 border border-slate-600 flex items-center justify-center dash-title font-extrabold text-slate-400 text-lg">
                                {{ $team->number }}
                            </div>
                            @endif
                            <div>
                                <div class="font-bold text-slate-100 text-[15px]">{{ $team->name }}</div>
                                <div class="text-xs text-slate-500 mt-1 font-medium">Kandidat No. {{ $team->number }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-7 hidden md:table-cell">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-slate-800/80 border border-slate-700/50 rounded-full h-2 overflow-hidden">
                                <div class="{{ $barClass }} progress-bar h-full rounded-full" style="width: 0%" data-width="{{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs font-black text-slate-300 w-12 text-right">{{ $percentage }}%</span>
                        </div>
                    </td>
                    <td class="py-5 px-7 text-right">
                        <div class="dash-title text-2xl font-black text-white">{{ number_format($team->vote_count, 0, ',', '.') }}</div>
                        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest mt-1">Suara</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-16 px-7 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-slate-800/40 border border-slate-700/50 flex items-center justify-center mx-auto mb-5">
                            <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-300 text-lg mb-2">Belum ada kandidat</p>
                        <p class="text-sm text-slate-500 mb-5">Silakan tambahkan kandidat untuk memulai event pemilihan ini.</p>
                        <a href="{{ route('admin-event.team.create') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 bg-cyan-400 hover:bg-cyan-300 transition-colors px-5 py-2.5 rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
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
        const bars = document.querySelectorAll('.progress-bar');

        // Small delay to ensure the DOM is painted and the transition catches
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