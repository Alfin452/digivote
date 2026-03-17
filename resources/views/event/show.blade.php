@extends('layouts.public')

@section('title', $event->name . ' - DigiVote')

@section('content')
<div class="bg-google-gray min-h-[calc(100vh-64px)] py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-google-textmuted mb-6" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a href="{{ route('home') }}" class="hover:text-google-blue transition-colors">Beranda</a>
            </li>
            <li><div class="flex items-center"><span class="mx-2">/</span>
              <a href="{{ route('home.live-events') }}" class="hover:text-google-blue transition-colors">Event</a>
            </div></li>
            <li aria-current="page"><div class="flex items-center"><span class="mx-2">/</span>
              <span class="text-google-text font-medium">{{ $event->name }}</span>
            </div></li>
          </ol>
        </nav>

        <!-- Event Header Card -->
        <div class="bg-white rounded-xl border border-google-border google-shadow p-8 mb-8">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 mb-3">
                        <span class="w-2 h-2 rounded-full bg-google-green animate-pulse"></span>
                        <span class="text-xs font-medium text-google-green tracking-wide">LIVE</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-display font-medium text-google-text mb-2">{{ $event->name }}</h1>
                    <p class="text-sm text-google-textmuted mb-4 font-medium">{{ $event->org }}</p>
                    <p class="text-google-textmuted leading-relaxed max-w-2xl">{{ $event->description }}</p>
                </div>
                
                <div class="shrink-0 flex md:flex-col items-center justify-between md:items-end gap-4">
                    <div class="bg-google-gray px-4 py-2 rounded-lg border border-google-border">
                        <span class="block text-xs text-google-textmuted mb-1 uppercase tracking-wider font-medium">Nilai Suara</span>
                        <span class="text-xl font-display font-medium text-google-text">Rp {{ number_format($event->price_per_vote, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-display font-medium text-google-text">Daftar Kandidat</h2>
            <div class="text-sm text-google-textmuted">Total: <span class="font-medium text-google-text">{{ count($teams) }}</span></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($teams as $team)
            <div class="bg-white rounded-xl border border-google-border p-6 hover:shadow-md transition-shadow relative flex flex-col group">
                
                <!-- Rank # -->
                <div class="absolute top-4 right-4 text-xs font-medium text-google-textmuted bg-google-gray px-2 py-1 rounded">
                    #{{ $loop->iteration }}
                </div>

                <div class="flex flex-col items-center mt-2">
                    @if($team->image_path)
                    <div class="w-24 h-24 rounded-full bg-google-gray p-1 mb-4 flex-shrink-0">
                        <img src="{{ asset('storage/' . $team->image_path) }}" alt="{{ $team->name }}" class="w-full h-full rounded-full object-cover">
                    </div>
                    @else
                    <div class="w-24 h-24 rounded-full bg-google-blue/10 flex items-center justify-center text-3xl font-display font-medium text-google-blue mb-4 flex-shrink-0">
                        {{ $team->number }}
                    </div>
                    @endif

                    <h3 class="text-lg font-medium text-google-text text-center mb-1">{{ $team->name }}</h3>
                    
                    <div class="flex items-center gap-2 text-xs text-google-textmuted mb-2">
                        <span class="bg-google-gray px-2 py-1 rounded">{{ $team->category->name ?? 'Umum' }}</span>
                    </div>
                    <p class="text-xs text-google-textmuted text-center mb-6">📌 {{ $team->location }}</p>
                </div>

                <div class="mt-auto w-full flex-1 flex flex-col justify-end">
                    <div class="text-center py-3 border-y border-google-border mb-4 bg-google-gray/30">
                        <div class="text-[10px] uppercase font-medium text-google-textmuted mb-1">Perolehan Suara</div>
                        <div class="text-2xl font-display font-medium text-google-text">{{ number_format($team->vote_count, 0, ',', '.') }}</div>
                    </div>

                    <a href="{{ route('vote.create', ['slug' => $event->slug, 'kandidat' => $team->number]) }}" class="w-full inline-flex justify-center py-2.5 border border-transparent text-sm font-medium rounded text-white bg-google-blue hover:bg-google-bluedark transition-colors google-shadow">
                        Berikan Suara
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center border border-dashed border-google-border rounded-xl bg-white">
                <svg class="w-12 h-12 text-google-border mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <h4 class="text-lg font-medium text-google-text mb-1">Belum ada kandidat</h4>
                <p class="text-sm text-google-textmuted">Kandidat belum diunggah untuk event ini.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection