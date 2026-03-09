@extends('layouts.admin-event')

@section('title', 'QR Code & Links')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-100">QR Code & Link Kandidat</h1>
    <p class="text-slate-400 mt-1">Unduh kode QR atau salin tautan langsung untuk dibagikan ke pemilih.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($teams as $team)
    @php
    $voteUrl = route('vote.create', ['slug' => $event->slug, 'kandidat' => $team->number]);
    $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&margin=10&data=' . urlencode($voteUrl);
    @endphp

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-sm flex flex-col items-center">
        <div class="w-full text-center mb-4">
            <span class="inline-block bg-purple-500/20 text-purple-400 border border-purple-500/30 text-xs px-2 py-1 rounded-full font-bold uppercase tracking-wide mb-2">Kandidat No. {{ $team->number }}</span>
            <h3 class="font-bold text-xl text-slate-200 line-clamp-1">{{ $team->name }}</h3>
        </div>

        <div class="bg-white p-2 border-2 border-dashed border-slate-700 rounded-xl mb-6 flex justify-center w-full">
            <img src="{{ $qrImageUrl }}" alt="QR Code {{ $team->name }}" class="w-48 h-48 object-contain">
        </div>

        <div class="w-full space-y-3 mt-auto">
            <a href="{{ $qrImageUrl }}&download=1" target="_blank" class="w-full flex justify-center items-center px-4 py-2.5 bg-slate-800 text-cyan-400 hover:bg-slate-700 hover:text-cyan-300 font-bold rounded-xl border border-slate-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh Gambar QR
            </a>

            <div class="relative w-full flex items-center">
                <input type="text" readonly value="{{ $voteUrl }}" class="w-full text-xs text-slate-400 bg-slate-950 border border-slate-800 rounded-l-lg py-3 px-3 outline-none">
                <button onclick="navigator.clipboard.writeText('{{ $voteUrl }}'); swalDark.fire({icon: 'success', title: 'Tersalin!', text: 'Tautan berhasil disalin', showConfirmButton: false, timer: 1500});" class="bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold py-3 px-4 rounded-r-lg transition-colors border border-purple-600">
                    Salin
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection