@extends('layouts.public')

@section('title', 'Live Events - DigiVote')

@section('content')
<div class="bg-white min-h-[calc(100vh-64px)] py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 pb-6 border-b border-google-border">
            <div>
                <h1 class="text-3xl font-display font-medium text-google-text mb-2">Katalog Event</h1>
                <p class="text-google-textmuted">Daftar pemilihan/voting digital yang sedang menerima respons aktif.</p>
            </div>
            
            <!-- Filter mock -->
            <div class="flex items-center gap-3">
                <span class="text-sm text-google-textmuted font-medium">Status:</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e6f4ea] text-[#137333] text-sm font-medium rounded-full border border-[#ceead6]">
                    <span class="w-2 h-2 rounded-full bg-[#137333]"></span>
                    LIVE
                </span>
            </div>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($events as $event)
                    <a href="{{ route('event.show', $event->slug) }}" class="group block bg-white rounded-xl border border-google-border overflow-hidden google-shadow hover:shadow-md transition-shadow flex flex-col h-full">
                        <div class="h-40 bg-google-gray flex items-center justify-center p-6 relative">
                            <!-- Placeholder Logo/Initial -->
                            <div class="w-16 h-16 rounded shadow bg-white flex items-center justify-center text-2xl font-display font-medium text-google-blue border border-google-border z-10">
                                {{ substr($event->name, 0, 1) }}
                            </div>
                            <!-- Deco -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent to-google-blue/5"></div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h2 class="font-display font-medium text-google-text text-lg mb-1 group-hover:text-google-blue transition-colors line-clamp-2">
                                {{ $event->name }}
                            </h2>
                            <p class="text-xs text-google-textmuted mb-4">{{ $event->org }}</p>
                            
                            <p class="text-sm text-google-text mt-auto mb-4 line-clamp-2">
                                {{ $event->description }}
                            </p>
                            
                            <div class="pt-4 border-t border-google-border flex items-center justify-between mt-auto">
                                <span class="text-xs font-medium bg-google-gray px-2 py-1 rounded text-google-textmuted">
                                    Rp {{ number_format($event->price_per_vote, 0, ',', '.') }}/vote
                                </span>
                                <span class="text-sm font-medium text-google-blue group-hover:underline">Buka</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-12 flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            <div class="py-20 text-center max-w-lg mx-auto">
                <svg class="w-16 h-16 text-google-border mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-xl font-display text-google-text mb-2">Tidak ada data ditemukan</h3>
                <p class="text-google-textmuted">Sistem tidak mendeteksi adanya event yang berstatus Live saat ini di database.</p>
            </div>
        @endif
    </div>
</div>
@endsection
