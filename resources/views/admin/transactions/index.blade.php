@extends('layouts.admin')

@section('title', 'Semua Transaksi Global')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-100 tracking-tight">Semua Transaksi Global</h1>
    <p class="text-slate-400 mt-1">Pantau seluruh aliran dana masuk dari semua event klien DigiVote.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-xl flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Total Dana Masuk (Sukses)</p>
            <p class="text-3xl font-black text-emerald-400">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.1)]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-xl flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Total Menunggu Pembayaran</p>
            <p class="text-3xl font-black text-amber-400">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-xl shadow-[0_0_15px_rgba(245,158,11,0.1)]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>

<div class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
    <div class="p-5 border-b border-slate-800 flex flex-wrap gap-4 items-center justify-between bg-slate-900/50">
        <h2 class="font-bold text-slate-200">Riwayat Transaksi Terbaru</h2>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-wrap gap-2">
            <div class="relative">
                <select name="status" class="text-sm px-4 py-2.5 bg-slate-950 text-slate-300 border border-slate-700 rounded-xl outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 appearance-none pr-10 cursor-pointer transition-all">
                    <option value="" class="bg-slate-900">Semua Status</option>
                    <option value="paid" class="bg-slate-900" {{ request('status') == 'paid' ? 'selected' : '' }}>Sukses (Paid)</option>
                    <option value="pending" class="bg-slate-900" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="expired" class="bg-slate-900" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-purple-500/20">
                Filter
            </button>

            @if(request('status'))
            <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-bold rounded-xl transition-colors border border-slate-700">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead class="bg-slate-950/50 border-b border-slate-800">
                <tr>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Tgl / Ref Xendit</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Event & Kandidat</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Pemilih</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Total Pembayaran</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50 text-sm">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-800/40 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-slate-200">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-1" title="Xendit ID">{{ $trx->xendit_id }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-bold text-cyan-400">{{ $trx->event->name ?? 'Event Dihapus' }}</div>
                        <div class="text-xs text-slate-400 mt-1">Vote: {{ $trx->team->name ?? 'Kandidat Dihapus' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm text-slate-200 font-medium">{{ $trx->voter_name ?? 'Hamba Allah' }}</div>
                        <div class="text-xs text-purple-400 mt-1 font-semibold">{{ $trx->vote_qty }} Suara</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm font-black text-emerald-400">Rp {{ number_format($trx->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($trx->status === 'paid')
                        <span class="inline-flex px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full text-[10px] font-black uppercase tracking-wider">PAID</span>
                        @elseif($trx->status === 'pending')
                        <span class="inline-flex px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full text-[10px] font-black uppercase tracking-wider">PENDING</span>
                        @else
                        <span class="inline-flex px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-full text-[10px] font-black uppercase tracking-wider">{{ $trx->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-slate-400 font-medium">Belum ada transaksi di platform ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="p-4 border-t border-slate-800 bg-slate-900/50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection