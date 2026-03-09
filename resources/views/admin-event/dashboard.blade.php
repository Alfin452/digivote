@extends('layouts.admin-event')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-100">{{ $event->name }}</h1>
        <p class="text-slate-400 mt-1">Pantau statistik perolehan suara secara real-time.</p>
    </div>
    <a href="{{ route('event.show', $event->slug) }}" target="_blank" class="hidden md:inline-flex items-center px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg shadow-sm text-sm font-bold text-cyan-400 hover:bg-slate-700 transition-colors">
        Lihat Halaman Publik
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
        </svg>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 bg-purple-500/20 rounded-xl mr-4 text-purple-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Total Suara Masuk</p>
            <p class="text-3xl font-black text-slate-100 mt-1">{{ number_format($totalVotes ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 bg-emerald-500/20 rounded-xl mr-4 text-emerald-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Total Pemasukan</p>
            <p class="text-3xl font-black text-slate-100 mt-1 truncate">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 bg-blue-500/20 rounded-xl mr-4 text-blue-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Potensi Hari Ini</p>
            <p class="text-3xl font-black text-slate-100 mt-1 truncate">Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 bg-cyan-500/20 rounded-xl mr-4 text-cyan-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Kandidat Terdaftar</p>
            <p class="text-3xl font-black text-slate-100 mt-1">{{ $leaderboard->count() }} <span class="text-sm font-normal text-slate-400">Tim</span></p>
        </div>
    </div>

    @php
    $statusRaw = strtolower($event->status ?? 'draft');
    $statusTheme = match($statusRaw) {
    'live' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'label' => 'Sedang Berjalan'],
    'soon' => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-400', 'label' => 'Segera Dimulai'],
    'done' => ['bg' => 'bg-slate-700/50', 'text' => 'text-slate-400', 'label' => 'Telah Selesai'],
    default => ['bg' => 'bg-slate-800', 'text' => 'text-slate-500', 'label' => 'Draft / Persiapan'],
    };
    @endphp
    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 {{ $statusTheme['bg'] }} rounded-xl mr-4 {{ $statusTheme['text'] }}">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($statusRaw === 'live')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                @elseif($statusRaw === 'soon')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                @endif
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Status Event</p>
            <p class="text-xl md:text-2xl font-black {{ $statusTheme['text'] }} mt-1 truncate">{{ $statusTheme['label'] }}</p>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex items-center">
        <div class="p-4 bg-yellow-500/20 rounded-xl mr-4 text-yellow-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider truncate">Leader Saat Ini</p>
            @php $leader = $leaderboard->first(); @endphp
            @if($leader && $leader->vote_count > 0)
            <p class="text-xl font-black text-slate-100 mt-1 truncate" title="{{ $leader->name }}">{{ $leader->name }}</p>
            <p class="text-xs font-bold text-yellow-400 mt-0.5">{{ number_format($leader->vote_count, 0, ',', '.') }} Suara</p>
            @else
            <p class="text-xl font-black text-slate-400 mt-1 truncate">Belum Ada Suara</p>
            @endif
        </div>
    </div>
</div>

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-800 bg-slate-900/50">
        <h2 class="text-lg font-bold text-slate-200">Top 3 Leaderboard Sementara</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-950/50 border-b border-slate-800">
                    <th class="py-3 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Peringkat</th>
                    <th class="py-3 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Kandidat</th>
                    <th class="py-3 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-right">Suara</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaderboard->take(3) as $index => $team)
                <tr class="hover:bg-slate-800/50 transition-colors border-b border-slate-800/50">
                    <td class="py-4 px-6">
                        @if($index === 0)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 font-bold text-sm">1</span>
                        @elseif($index === 1)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-700 text-slate-300 border border-slate-600 font-bold text-sm">2</span>
                        @elseif($index === 2)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30 font-bold text-sm">3</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-slate-200">{{ $team->name }}</div>
                        <div class="text-sm text-slate-400">No. {{ $team->number }}</div>
                    </td>
                    <td class="py-4 px-6 text-right font-black text-xl text-cyan-400">
                        {{ number_format($team->vote_count, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection