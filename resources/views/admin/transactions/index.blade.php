@extends('layouts.admin')

@section('title', 'Semua Transaksi Global')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Semua Transaksi Global</h1>
    <p class="text-gray-500 mt-1">Pantau seluruh aliran dana masuk dari semua event klien DigiVote.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Total Dana Masuk (Sukses)</p>
            <p class="text-3xl font-black text-emerald-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-emerald-50 text-emerald-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Total Menunggu Pembayaran</p>
            <p class="text-3xl font-black text-amber-500">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-amber-50 text-amber-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex flex-wrap gap-4 items-center justify-between bg-gray-50/50">
        <h2 class="font-bold text-gray-700">Riwayat Transaksi Terbaru</h2>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex gap-2">
            <select name="status" class="text-sm px-3 py-2 border border-gray-200 rounded-lg outline-none focus:border-blue-500 bg-white">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sukses (Paid)</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm font-bold rounded-lg hover:bg-gray-900 transition-colors">
                Filter
            </button>
            @if(request('status'))
            <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-300 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Tgl / Ref Xendit</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Event & Kandidat</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Pemilih</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                    <th class="py-3 px-6 font-bold text-xs text-gray-500 uppercase tracking-wider text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-blue-50/30 transition-colors">
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-gray-900">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        <div class="text-[11px] text-gray-400 font-mono mt-1" title="Xendit ID">{{ $trx->xendit_id }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-blue-600">{{ $trx->event->name ?? 'Event Dihapus' }}</div>
                        <div class="text-xs text-gray-500 mt-1">Vote: {{ $trx->team->name ?? 'Kandidat Dihapus' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm text-gray-900 font-medium">{{ $trx->voter_name ?? 'Hamba Allah' }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $trx->vote_qty }} Suara</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-black text-gray-900">Rp {{ number_format($trx->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($trx->status === 'paid')
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase">PAID</span>
                        @elseif($trx->status === 'pending')
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">PENDING</span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">Belum ada transaksi di platform ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection