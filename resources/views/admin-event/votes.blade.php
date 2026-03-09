@extends('layouts.admin-event')

@section('title', 'Log Suara Sah')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-100">Log Suara Sah</h1>
        <p class="text-slate-400 mt-1">Daftar riwayat dukungan yang telah tervalidasi oleh sistem pembayaran.</p>
    </div>

    <button onclick="window.print()" class="bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white px-4 py-2 rounded-xl font-bold text-sm inline-flex items-center transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Cetak Laporan
    </button>
</div>

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-950/50 border-b border-slate-800">
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider w-16 text-center">No</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Waktu Masuk</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Nama Pendukung</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Kandidat Pilihan</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center">Jumlah Suara</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($validVotes as $index => $vote)
                <tr class="hover:bg-slate-800/50 transition-colors border-b border-slate-800/50">
                    <td class="py-4 px-6 text-center text-slate-500">{{ $validVotes->firstItem() + $index }}</td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-slate-200">{{ \Carbon\Carbon::parse($vote->paid_at)->format('d M Y') }}</div>
                        <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($vote->paid_at)->format('H:i:s') }} WITA</div>
                    </td>
                    <td class="py-4 px-6 font-bold text-slate-200">{{ $vote->voter_name ?? 'Pendukung Rahasia' }}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/20 mr-2">
                            No. {{ $vote->team->number ?? '-' }}
                        </span>
                        <span class="font-bold text-slate-300">{{ $vote->team->name ?? 'Kandidat Dihapus' }}</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="inline-block bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-3 py-1 rounded-lg font-black text-lg shadow-inner">
                            +{{ $vote->vote_qty }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-slate-500">
                        Belum ada data suara sah yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($validVotes->hasPages())
    <div class="p-4 border-t border-slate-800 bg-slate-900/50">
        {{ $validVotes->links() }}
    </div>
    @endif
</div>
@endsection