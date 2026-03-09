@extends('layouts.admin')

@section('title', 'Master Overview')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Master Overview</h1>
    <p class="text-gray-500 mt-1">Pantau seluruh aktivitas dan perputaran transaksi di platform DigiVote.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Perputaran Uang</p>
            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-black text-gray-900">Rp {{ number_format($totalPlatformIncome, 0, ',', '.') }}</p>
        <p class="text-xs text-emerald-600 font-bold mt-2">Gross Volume (Paid)</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Event Aktif</p>
            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-black text-gray-900">{{ number_format($totalEvents, 0, ',', '.') }}</p>
        <p class="text-xs text-blue-600 font-bold mt-2">Event Terdaftar</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Suara Masuk</p>
            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-black text-gray-900">{{ number_format($totalPlatformVotes, 0, ',', '.') }}</p>
        <p class="text-xs text-purple-600 font-bold mt-2">Vote Sah Diproses</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900">Event Terbaru</h2>
        <button class="text-sm font-bold text-blue-600 hover:text-blue-800">Lihat Semua &rarr;</button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Nama Event</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Harga / Suara</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Periode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEvents as $ev)
                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                    <td class="py-4 px-6 font-bold text-gray-900">{{ $ev->name }}</td>
                    <td class="py-4 px-6">
                        @if($ev->status === 'active')
                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Active</span>
                        @else
                        <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold uppercase">{{ $ev->status }}</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 font-mono text-sm">Rp {{ number_format($ev->price_per_vote, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($ev->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($ev->end_date)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-gray-500">Belum ada event yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection