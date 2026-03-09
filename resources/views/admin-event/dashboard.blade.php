@extends('layouts.admin-event')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">{{ $event->name }}</h1>
        <p class="text-gray-500 mt-1">Pantau statistik perolehan suara secara real-time.</p>
    </div>
    <a href="{{ route('event.show', $event->slug) }}" target="_blank" class="hidden md:inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm font-bold text-blue-600 hover:bg-gray-50 transition-colors">
        Lihat Halaman Publik
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
        </svg>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center">
        <div class="p-4 bg-blue-50 rounded-xl mr-4 text-blue-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Suara Masuk</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ number_format($totalVotes, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center">
        <div class="p-4 bg-emerald-50 rounded-xl mr-4 text-emerald-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Pemasukan (Paid)</p>
            <p class="text-4xl font-black text-gray-900 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-white">
        <h2 class="text-lg font-bold text-gray-800">Top 3 Leaderboard Sementara</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Peringkat</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Kandidat</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider text-right">Suara</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaderboard->take(3) as $index => $team)
                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50">
                    <td class="py-4 px-6">
                        @if($index === 0)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 font-bold text-sm">1</span>
                        @elseif($index === 1)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 font-bold text-sm">2</span>
                        @elseif($index === 2)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-700 font-bold text-sm">3</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-900">{{ $team->name }}</div>
                        <div class="text-sm text-gray-500">No. {{ $team->number }}</div>
                    </td>
                    <td class="py-4 px-6 text-right font-black text-xl text-blue-600">
                        {{ number_format($team->vote_count, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection