@extends('layouts.admin-event')

@section('title', 'Data Pemasukan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-100">Riwayat Pemasukan</h1>
        <p class="text-slate-400 mt-1">Pantau semua transaksi masuk dari para pemilih.</p>
    </div>

    <div class="bg-emerald-500/10 text-emerald-400 px-4 py-2 rounded-lg border border-emerald-500/20 font-bold text-sm inline-flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Hanya transaksi PAID yang masuk ke Leaderboard
    </div>
</div>

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-950/50 border-b border-slate-800">
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">ID Transaksi</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Nama Voter</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Kandidat</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center">Jml Suara</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-right">Nominal</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-800/50 transition-colors border-b border-slate-800/50">
                    <td class="py-4 px-6 text-slate-400">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td class="py-4 px-6 font-mono text-xs text-slate-500">{{ $trx->xendit_id ?? 'Menunggu...' }}</td>
                    <td class="py-4 px-6 font-bold text-slate-200">{{ $trx->voter_name ?? 'Anonymous' }}</td>
                    <td class="py-4 px-6 text-slate-300">{{ $trx->team->name ?? '-' }} <span class="text-slate-500">(No. {{ $trx->team->number ?? '-' }})</span></td>
                    <td class="py-4 px-6 font-bold text-center text-cyan-400">{{ $trx->vote_qty }}</td>
                    <td class="py-4 px-6 font-bold text-right text-slate-200">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">
                        @if($trx->status === 'paid')
                        <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 py-1 px-3 rounded-full text-xs font-bold uppercase">Paid</span>
                        @elseif($trx->status === 'pending')
                        <span class="bg-amber-500/20 text-amber-400 border border-amber-500/20 py-1 px-3 rounded-full text-xs font-bold uppercase">Pending</span>
                        @else
                        <span class="bg-red-500/20 text-red-400 border border-red-500/20 py-1 px-3 rounded-full text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-10 text-center text-slate-500">
                        Belum ada data transaksi masuk.
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