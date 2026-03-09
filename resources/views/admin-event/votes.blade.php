@extends('layouts.admin-event')

@section('title', 'Log Suara Sah')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Log Suara Sah</h1>
        <p class="text-gray-500 mt-1">Daftar riwayat dukungan yang telah tervalidasi oleh sistem pembayaran.</p>
    </div>

    <button onclick="window.print()" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-xl font-bold text-sm inline-flex items-center transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Cetak Laporan
    </button>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider w-16 text-center">No</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Waktu Masuk</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Nama Pendukung</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Kandidat Pilihan</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider text-center">Jumlah Suara</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($validVotes as $index => $vote)
                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50">
                    <td class="py-4 px-6 text-center text-gray-500">{{ $validVotes->firstItem() + $index }}</td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($vote->paid_at)->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($vote->paid_at)->format('H:i:s') }} WITA</div>
                    </td>
                    <td class="py-4 px-6 font-bold text-gray-900">{{ $vote->voter_name ?? 'Pendukung Rahasia' }}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                            No. {{ $vote->team->number ?? '-' }}
                        </span>
                        <span class="font-bold text-gray-700">{{ $vote->team->name ?? 'Kandidat Dihapus' }}</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="inline-block bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg font-black text-lg">
                            +{{ $vote->vote_qty }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500">
                        Belum ada data suara sah yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($validVotes->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $validVotes->links() }}
    </div>
    @endif
</div>
@endsection