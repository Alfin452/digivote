@extends('layouts.admin-event')

@section('title', 'QR Code & Links')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900">QR Code & Link Kandidat</h1>
    <p class="text-gray-500 mt-1">Unduh kode QR atau salin tautan langsung untuk dibagikan ke pemilih.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($teams as $team)
    @php
    // Generate URL Link Langsung ke Form Vote Kandidat Ini
    $voteUrl = route('vote.create', ['slug' => $event->slug, 'kandidat' => $team->number]);
    // Generate URL Gambar QR Code via API qrserver.com
    $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&margin=10&data=' . urlencode($voteUrl);
    @endphp

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col items-center">
        <div class="w-full text-center mb-4">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold uppercase tracking-wide mb-2">Kandidat No. {{ $team->number }}</span>
            <h3 class="font-bold text-xl text-gray-900 line-clamp-1">{{ $team->name }}</h3>
        </div>

        <div class="bg-white p-2 border-2 border-dashed border-gray-200 rounded-xl mb-6 flex justify-center w-full">
            <img src="{{ $qrImageUrl }}" alt="QR Code {{ $team->name }}" class="w-48 h-48 object-contain">
        </div>

        <div class="w-full space-y-3 mt-auto">
            <a href="{{ $qrImageUrl }}&download=1" target="_blank" class="w-full flex justify-center items-center px-4 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold rounded-xl transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh Gambar QR
            </a>

            <div class="relative w-full flex items-center">
                <input type="text" readonly value="{{ $voteUrl }}" class="w-full text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-l-lg py-3 px-3 outline-none">
                <button onclick="navigator.clipboard.writeText('{{ $voteUrl }}'); alert('Tautan berhasil disalin!');" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold py-3 px-4 rounded-r-lg transition-colors border border-gray-800">
                    Salin
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection