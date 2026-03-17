@extends('layouts.public')

@section('title', 'DigiVote - Platform Voting Terpadu')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center bg-white relative overflow-hidden">
    <!-- Subtle tech background dots -->
    <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: radial-gradient(#202124 1px, transparent 1px); background-size: 32px 32px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 py-16 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Text Content -->
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 mb-6 px-3 py-1 rounded-full bg-google-blue/10 text-google-bluedark border border-google-blue/20">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-google-blue opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-google-blue"></span>
                    </span>
                    <span class="text-xs font-medium tracking-wide">Sistem Voting Aktif</span>
                </div>
                
                <h1 class="text-5xl md:text-[64px] font-display font-medium text-google-text leading-[1.1] tracking-tight mb-6">
                    Masa depan voting <br />
                    <span class="text-google-blue">digital yang terpercaya</span>
                </h1>
                
                <p class="text-xl text-google-textmuted mb-10 leading-relaxed font-light">
                    Infrastruktur pemilihan skala besar yang dirancang untuk kecepatan, transparansi real-time, dan didukung oleh pembayaran instan QRIS.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home.live-events') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-medium rounded text-white bg-google-blue hover:bg-google-bluedark transition-all google-shadow-hover">
                        Eksplorasi Event Aktif
                    </a>
                    <a href="{{ route('home.cara-kerja') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-google-border text-base font-medium rounded text-google-text bg-white hover:bg-google-gray transition-all">
                        Pelajari Cara Kerja
                    </a>
                </div>
                
                <div class="mt-12 flex items-center gap-8 text-sm text-google-textmuted">
                    <div class="flex flex-col">
                        <span class="font-display font-medium text-2xl text-google-text">99.9%</span>
                        <span>Uptime Server</span>
                    </div>
                    <div class="w-px h-10 bg-google-border"></div>
                    <div class="flex flex-col">
                        <span class="font-display font-medium text-2xl text-google-text">< 2s</span>
                        <span>Latensi Voting</span>
                    </div>
                    <div class="w-px h-10 bg-google-border"></div>
                    <div class="flex flex-col">
                        <span class="font-display font-medium text-2xl text-google-text">QRIS</span>
                        <span>Integrasi Validasi</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Data Visual / Dashboard Mockup -->
            <div class="relative hidden lg:block">
                <div class="absolute -inset-4 bg-google-gray rounded-[32px] transform rotate-3"></div>
                <div class="absolute -inset-4 bg-white/50 backdrop-blur-3xl rounded-[32px] border border-white transform -rotate-2"></div>
                
                <div class="relative bg-white rounded-2xl border border-google-border google-shadow overflow-hidden">
                    <div class="h-10 border-b border-google-border bg-google-gray/50 flex items-center px-4 gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#ea4335]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#fbbc04]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#34a853]"></div>
                        <div class="ml-4 text-xs text-google-textmuted font-medium bg-white px-4 py-1 rounded shadow-sm border border-google-border">digivote.id/console</div>
                    </div>
                    
                    <div class="p-8">
                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <h3 class="font-display font-medium text-lg text-google-text">Live Telemetry</h3>
                                <p class="text-xs text-google-textmuted">Beban jaringan saat ini</p>
                            </div>
                            <div class="text-right">
                                <span class="font-display text-3xl text-google-blue">14,208</span>
                                <p class="text-xs text-google-textmuted">Suara/menit</p>
                            </div>
                        </div>
                        
                        <!-- Abstract Chart -->
                        <div class="h-40 flex items-end gap-2 mb-6">
                            @foreach([40, 70, 45, 90, 65, 85, 100, 60, 80, 50, 75, 95] as $height)
                            <div class="flex-1 bg-google-blue/10 rounded-t-sm hover:bg-google-blue/20 transition-colors" style="height: {{ $height }}%">
                                <div class="bg-google-blue rounded-t-sm w-full transition-all" style="height: {{ $height * 0.8 }}%"></div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl border border-google-border bg-google-gray/30">
                                <p class="text-xs text-google-textmuted mb-1">Status Enkripsi</p>
                                <p class="font-medium text-sm text-google-green flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    End-to-end (AES-256)
                                </p>
                            </div>
                            <div class="p-4 rounded-xl border border-google-border bg-google-gray/30">
                                <p class="text-xs text-google-textmuted mb-1">Gateway API</p>
                                <p class="font-medium text-sm text-google-blue flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-google-blue"></span>
                                    Xendit OVO/Dana/QRIS
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
