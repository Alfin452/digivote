@extends('layouts.admin-event')

@section('title', 'Command Center Event')

@push('styles')
<style>
    /* Animasi Progress Bar Halus */
    .progress-bar-fill {
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Background Pattern Mesh */
    .bg-mesh-pattern {
        background-image: radial-gradient(#94a3b8 1px, transparent 1px);
        background-size: 24px 24px;
    }

    /* Holographic Card Effect untuk Juara 1 */
    .holographic-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
    }

    /* Animasi Fade In Berjenjang */
    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .delay-100 {
        animation-delay: 100ms;
    }

    .delay-200 {
        animation-delay: 200ms;
    }

    .delay-300 {
        animation-delay: 300ms;
    }
</style>
@endpush

@section('content')

@php
// Logika Penghitungan Waktu Event (Fitur Baru)
$now = \Carbon\Carbon::now();
$start = \Carbon\Carbon::parse($event->started_at);
$end = \Carbon\Carbon::parse($event->ended_at);

$totalDuration = $start->diffInMinutes($end) ?: 1; // Cegah division by zero
$elapsed = $start->diffInMinutes($now, false);

if ($elapsed < 0) {
    $timeProgress=0; // Belum mulai
    $daysLeft=$now->diffInDays($start);
    $timeText = "Dimulai dalam $daysLeft hari";
    } elseif ($now->gt($end)) {
    $timeProgress = 100; // Sudah selesai
    $timeText = "Event telah berakhir";
    } else {
    $timeProgress = min(100, max(0, ($elapsed / $totalDuration) * 100)); // Sedang berjalan
    $daysLeft = $now->diffInDays($end);
    $hoursLeft = $now->copy()->addDays($daysLeft)->diffInHours($end);
    $timeText = "Sisa waktu: $daysLeft Hari, $hoursLeft Jam";
    }
    @endphp

    {{-- ===== 1. HERO COMMAND CENTER & TIMELINE ===== --}}
    <div class="relative bg-white border border-slate-200 shadow-sm rounded-3xl p-6 lg:p-8 mb-8 overflow-hidden animate-slide-up opacity-0">

        {{-- Decorative Background --}}
        <div class="absolute inset-0 bg-mesh-pattern opacity-[0.1] pointer-events-none"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/10 blur-3xl rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-500/10 blur-3xl rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row justify-between gap-8">

            {{-- Kiri: Identitas Event --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-4">
                    @php $statusRaw = strtolower($event->status ?? 'draft'); @endphp
                    @if($statusRaw === 'live')
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-50 border border-red-200 text-red-600 text-[11px] font-black uppercase tracking-widest shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                        LIVE EVENT
                    </div>
                    @elseif($statusRaw === 'soon')
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-600 text-[11px] font-black uppercase tracking-widest shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        COMING SOON
                    </div>
                    @else
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-600 text-[11px] font-black uppercase tracking-widest shadow-sm">
                        EVENT CLOSED
                    </div>
                    @endif
                    <span class="text-sm font-bold text-slate-400 bg-white border border-slate-200 px-3 py-1 rounded-lg">ID: #{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-heading font-black text-slate-800 tracking-tight leading-tight">{{ $event->name }}</h1>
                <p class="text-slate-500 mt-2 text-sm font-medium max-w-xl">Overview komprehensif data pemilihan. Salin tautan di bawah dan bagikan ke media sosial untuk mendongkrak partisipasi.</p>

                {{-- Fitur Baru: Social Share & Quick Actions --}}
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    {{-- Copy Link --}}
                    <button onclick="navigator.clipboard.writeText('{{ route('event.show', $event->slug) }}'); this.innerHTML='<svg class=\'w-4 h-4 mr-2 text-emerald-500\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2.5\' d=\'M5 13l4 4L19 7\'></path></svg> Disalin!'; setTimeout(()=>this.innerHTML='<svg class=\'w-4 h-4 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3\'></path></svg> Salin Link', 2500)"
                        class="inline-flex items-center px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl text-sm font-bold text-slate-700 transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3"></path>
                        </svg>
                        Salin Link
                    </button>

                    {{-- Share WA --}}
                    <a href="https://api.whatsapp.com/send?text=Dukung%20kandidat%20pilihanmu%20di%20{{ urlencode($event->name) }}!%20Klik%20link%20berikut%20untuk%20voting:%20{{ route('event.show', $event->slug) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2.5 bg-[#25D366]/10 hover:bg-[#25D366]/20 border border-[#25D366]/30 rounded-xl text-sm font-bold text-[#1DA851] transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Share WA
                    </a>

                    {{-- Visit Public --}}
                    <a href="{{ route('event.show', $event->slug) }}" target="_blank"
                        class="inline-flex items-center px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        Live Portal
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Kanan: Event Timeline Widget (Fitur Baru) --}}
            <div class="w-full xl:w-96 bg-slate-50 border border-slate-200 rounded-2xl p-5 shadow-inner flex flex-col justify-center">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Event Timeline Widget</h3>

                <div class="flex justify-between items-end mb-2">
                    <span class="text-[11px] font-bold text-slate-500 bg-white px-2 py-1 rounded shadow-sm border border-slate-100">{{ $start->format('d M Y') }}</span>
                    <span class="text-[11px] font-bold text-slate-500 bg-white px-2 py-1 rounded shadow-sm border border-slate-100">{{ $end->format('d M Y') }}</span>
                </div>

                <div class="w-full bg-slate-200/80 rounded-full h-3 mb-3 overflow-hidden shadow-inner p-0.5">
                    <div class="progress-bar-fill h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 relative" style="width: 0%" data-width="{{ $timeProgress }}%">
                        <div class="absolute top-0 inset-x-0 h-1/2 bg-white/30 rounded-full"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm font-bold text-indigo-600">{{ round($timeProgress) }}% <span class="text-xs font-medium text-slate-500">Berjalan</span></div>
                    <div class="text-xs font-bold text-slate-600 px-2 py-1 bg-slate-200/50 rounded-lg">⏳ {{ $timeText }}</div>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== 2. METRIC STAT CARDS DENGAN SPARKLINE ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-slide-up delay-100 opacity-0">

        {{-- Card 1: Total Suara --}}
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl p-6 relative overflow-hidden group hover:border-blue-300 hover:shadow-lg transition-all duration-300">
            {{-- Mini SVG Sparkline Background --}}
            <svg class="absolute bottom-0 left-0 w-full h-16 text-blue-50 opacity-50 group-hover:scale-105 transition-transform duration-500" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,100 C20,80 40,90 60,40 C80,10 100,60 100,60 L100,100 Z" fill="currentColor" />
            </svg>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Total Suara Masuk</p>
                    <h3 class="text-3xl font-heading font-black text-slate-800">{{ number_format($totalVotes ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 flex items-center justify-center rounded-2xl text-blue-600 border border-blue-100 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Pemasukan --}}
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl p-6 relative overflow-hidden group hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
            <svg class="absolute bottom-0 left-0 w-full h-16 text-emerald-50 opacity-50 group-hover:scale-105 transition-transform duration-500" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,100 C30,70 50,80 70,30 C90,10 100,50 100,50 L100,100 Z" fill="currentColor" />
            </svg>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-full pr-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Omzet Bersih</p>
                    <h3 class="text-2xl font-heading font-black text-slate-800 truncate" title="Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}">
                        <span class="text-base text-slate-400 mr-0.5">Rp</span>{{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 flex items-center justify-center rounded-2xl text-emerald-600 border border-emerald-100 shadow-sm shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 3: Jumlah Kandidat --}}
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl p-6 relative overflow-hidden group hover:border-purple-300 hover:shadow-lg transition-all duration-300">
            <svg class="absolute -right-4 -top-4 w-28 h-28 text-purple-50 opacity-60 group-hover:scale-110 transition-transform duration-500 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Total Kandidat</p>
                    <h3 class="text-3xl font-heading font-black text-slate-800">{{ $leaderboard->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-50 flex items-center justify-center rounded-2xl text-purple-600 border border-purple-100 shadow-sm shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 4: Hari Ini --}}
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl p-6 relative overflow-hidden group hover:border-amber-300 hover:shadow-lg transition-all duration-300">
            <svg class="absolute bottom-0 left-0 w-full h-16 text-amber-50 opacity-50 group-hover:scale-105 transition-transform duration-500" preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0,100 C20,60 40,80 60,30 C80,10 100,50 100,50 L100,100 Z" fill="currentColor" />
            </svg>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-full pr-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Income Hari Ini</p>
                    <h3 class="text-2xl font-heading font-black text-slate-800 truncate" title="Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}">
                        <span class="text-base text-slate-400 mr-0.5">Rp</span>{{ number_format($todayIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-12 h-12 bg-amber-50 flex items-center justify-center rounded-2xl text-amber-600 border border-amber-100 shadow-sm shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== 3. BENTO GRID: LEADER SPOTLIGHT & DISTRIBUTION ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 animate-slide-up delay-200 opacity-0">

        {{-- BENTO 1: The Holographic Leader Spotlight --}}
        @php $leader = $leaderboard->first(); @endphp
        <div class="bg-slate-900 shadow-xl rounded-3xl p-8 lg:col-span-1 flex flex-col relative overflow-hidden group border border-slate-800">

            {{-- Luxury Dark Background FX --}}
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
            <div class="absolute -top-32 -left-32 w-64 h-64 bg-amber-500/20 blur-[60px] rounded-full pointer-events-none group-hover:bg-amber-400/30 transition-all duration-700"></div>

            <div class="flex items-center justify-between mb-8 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-amber-500/10 rounded border border-amber-500/20">
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <h2 class="text-xs font-black text-slate-300 uppercase tracking-widest">👑 Puncak Klasemen</h2>
                </div>
            </div>

            @if($leader && $leader->vote_count > 0)
            <div class="flex-1 flex flex-col items-center justify-center text-center relative z-10">

                {{-- Foto Profil dengan Efek Glowing Trophy --}}
                <div class="relative group-hover:-translate-y-2 transition-transform duration-500">
                    <div class="absolute inset-0 bg-amber-400 blur-2xl opacity-30 rounded-full animate-pulse"></div>
                    @if($leader->image)
                    <img src="{{ asset('storage/' . $leader->image) }}" alt="Foto" class="w-36 h-36 rounded-full object-cover border-4 border-slate-800 shadow-2xl relative z-10 bg-slate-900 ring-4 ring-amber-500/30">
                    @else
                    <div class="w-36 h-36 rounded-full bg-slate-800 border-4 border-slate-900 flex items-center justify-center text-5xl font-black text-slate-400 shadow-2xl relative z-10 ring-4 ring-amber-500/30">
                        {{ $leader->number }}
                    </div>
                    @endif

                    {{-- Trophy Badge --}}
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-400 to-yellow-500 text-slate-900 text-[11px] font-black px-4 py-1.5 rounded-full z-20 border-[3px] border-slate-900 shadow-lg uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 4h14v2H5V4zm0 5a7.992 7.992 0 006 7.745V19H8v2h8v-2h-3v-2.255A7.992 7.992 0 0019 9V7H5v2z" />
                        </svg>
                        Peringkat 1
                    </div>
                </div>

                <h3 class="mt-10 text-3xl font-heading font-black text-white line-clamp-1 px-4 drop-shadow-md" title="{{ $leader->name }}">{{ $leader->name }}</h3>
                <p class="text-slate-400 mt-1 font-medium text-sm">Kandidat No. {{ $leader->number }}</p>

                <div class="w-full h-px bg-slate-800 my-8"></div>

                <div class="w-full flex justify-between items-end px-4">
                    <div class="text-left">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5">Total Suara</p>
                        <p class="text-4xl font-heading font-black text-amber-400 drop-shadow-[0_0_10px_rgba(251,191,36,0.5)]">{{ number_format($leader->vote_count, 0, ',', '.') }}</p>
                    </div>
                    @php $leaderPct = $totalVotes > 0 ? round(($leader->vote_count / $totalVotes) * 100, 1) : 0; @endphp
                    <div class="text-right">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5">Persentase</p>
                        <p class="text-3xl font-heading font-black text-white">{{ $leaderPct }}<span class="text-lg text-slate-500 ml-1">%</span></p>
                    </div>
                </div>
            </div>
            @else
            <div class="flex-1 flex flex-col items-center justify-center py-10 text-center relative z-10">
                <div class="w-20 h-20 rounded-full bg-slate-800 flex items-center justify-center mb-5 text-slate-500 border border-slate-700">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-300 font-heading font-bold text-xl mb-1">Belum Ada Suara</p>
                <p class="text-slate-500 text-sm">Juara akan muncul di sini saat data masuk.</p>
            </div>
            @endif
        </div>

        {{-- BENTO 2: Vote Distribution --}}
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl p-8 lg:col-span-2 flex flex-col">
            <div class="flex items-start sm:items-center justify-between mb-8 flex-col sm:flex-row gap-4">
                <div>
                    <h2 class="text-xl font-heading font-bold text-slate-800">Distribusi Suara Target</h2>
                    <p class="text-sm text-slate-500 mt-1">Perbandingan 5 kandidat dengan perolehan tertinggi</p>
                </div>
                <a href="{{ route('admin-event.leaderboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-5 py-2.5 rounded-xl transition-colors border border-blue-100 shrink-0 shadow-sm hover:shadow">
                    Buka Leaderboard
                </a>
            </div>

            @if($leaderboard->count() > 0 && $totalVotes > 0)
            <div class="flex-1 flex flex-col justify-center space-y-7">
                @foreach($leaderboard->take(5) as $idx => $team)
                @php
                $pct = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;
                // Gradient mewah untuk setiap baris
                $barColors = match($idx) {
                0 => 'from-amber-400 to-orange-500 shadow-[0_0_15px_rgba(245,158,11,0.4)]',
                1 => 'from-slate-400 to-slate-500 shadow-[0_0_15px_rgba(100,116,139,0.3)]',
                2 => 'from-orange-400 to-rose-400 shadow-[0_0_15px_rgba(251,146,60,0.3)]',
                default => 'from-blue-400 to-indigo-500 shadow-[0_0_15px_rgba(96,165,250,0.3)]'
                };
                @endphp
                <div class="group">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-4">
                            <div class="w-6 text-center text-[10px] font-black text-slate-400 bg-slate-100 py-1 rounded-md border border-slate-200">#{{ $idx + 1 }}</div>
                            <span class="text-sm font-bold text-slate-700 truncate max-w-[150px] sm:max-w-[300px]">{{ $team->name }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-semibold text-slate-400 hidden sm:block bg-slate-50 px-2 py-0.5 rounded border border-slate-100">{{ number_format($team->vote_count, 0, ',', '.') }} suara</span>
                            <span class="text-sm font-black text-slate-800 w-14 text-right">{{ $pct }}%</span>
                        </div>
                    </div>
                    {{-- Premium Progress Bar --}}
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden border border-slate-200/60 p-[1px]">
                        <div class="progress-bar-fill h-full rounded-full bg-gradient-to-r {{ $barColors }} relative" style="width: 0%" data-width="{{ $pct }}%">
                            <div class="absolute top-0 inset-x-0 h-[40%] bg-white/30 rounded-full"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
                <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center mb-5 text-slate-300 border-2 border-slate-100 border-dashed">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path>
                    </svg>
                </div>
                <p class="text-slate-800 font-heading font-bold text-xl mb-1">Distribusi Kosong</p>
                <p class="text-slate-500 text-sm">Grafik perbandingan akan terbentuk jika data suara telah terisi.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== 4. LEADERBOARD TABLE ===== --}}
    <div class="bg-white border border-slate-200/80 shadow-sm rounded-3xl overflow-hidden mb-8 animate-slide-up delay-300 opacity-0">
        <div class="px-8 py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 bg-slate-50/50">
            <div>
                <h2 class="text-xl font-heading font-bold text-slate-800">Tabel Peringkat Lengkap</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar kandidat dengan perolehan suara terbanyak saat ini.</p>
            </div>
            <div class="flex gap-3">
                {{-- Tombol Refresh Animasi Alpine --}}
                <button x-data="{ spinning: false }" @click="spinning = true; setTimeout(() => window.location.reload(), 500)" class="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-xl transition-all shadow-sm bg-white" title="Refresh Data">
                    <svg class="w-5 h-5 transition-transform duration-500" :class="spinning ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <a href="{{ route('admin-event.leaderboard') }}" class="text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 border border-slate-700 px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center justify-center shrink-0">
                    Data Keseluruhan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest w-24 text-center">Rank</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Kandidat</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell w-1/3">Distribusi Target</th>
                        <th class="py-5 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Suara Masuk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($leaderboard->take(5) as $index => $team)
                    @php
                    $percentage = $totalVotes > 0 ? round(($team->vote_count / $totalVotes) * 100, 1) : 0;

                    $rankColors = match($index) {
                    0 => 'text-amber-600 bg-amber-50 border-amber-200 shadow-sm',
                    1 => 'text-slate-600 bg-slate-100 border-slate-200 shadow-sm',
                    2 => 'text-orange-600 bg-orange-50 border-orange-200 shadow-sm',
                    default => 'text-slate-500 bg-white border-slate-200'
                    };

                    $barColors = match($index) {
                    0 => 'from-amber-400 to-orange-500',
                    1 => 'from-slate-400 to-slate-500',
                    2 => 'from-orange-400 to-rose-400',
                    default => 'from-blue-400 to-indigo-400'
                    };
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors bg-white group">
                        <td class="py-5 px-8 text-center">
                            <div class="w-10 h-10 mx-auto rounded-xl border-2 {{ $rankColors }} flex items-center justify-center font-black text-base group-hover:scale-110 transition-transform">
                                {{ $index + 1 }}
                            </div>
                        </td>
                        <td class="py-5 px-8">
                            <div class="flex items-center gap-5">
                                @if($team->image)
                                <img src="{{ asset('storage/' . $team->image) }}" alt="Foto" class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm shrink-0">
                                @else
                                <div class="w-14 h-14 rounded-full bg-slate-50 border-2 border-slate-100 flex items-center justify-center font-bold text-slate-400 shadow-sm shrink-0">
                                    {{ $team->number }}
                                </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-800 text-base">{{ $team->name }}</div>
                                    <div class="text-xs font-semibold text-slate-500 mt-1 bg-slate-100 inline-block px-2 py-0.5 rounded border border-slate-200">Kandidat No. {{ $team->number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-8 hidden md:table-cell align-middle">
                            <div class="flex items-center gap-4">
                                <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden border border-slate-200/50 p-[1px]">
                                    <div class="progress-bar-fill h-full rounded-full bg-gradient-to-r {{ $barColors }} relative" style="width: 0%" data-width="{{ $percentage }}%">
                                        <div class="absolute top-0 inset-x-0 h-[40%] bg-white/30 rounded-full"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-black text-slate-700 w-14 text-right">{{ $percentage }}%</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 text-right">
                            <div class="text-2xl font-heading font-black text-slate-800">{{ number_format($team->vote_count, 0, ',', '.') }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Suara</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 px-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="w-20 h-20 rounded-3xl bg-slate-50 border border-slate-200 border-dashed flex items-center justify-center mb-5 shadow-sm">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <p class="font-heading font-bold text-slate-800 text-xl mb-1">Tabel Kosong</p>
                                <p class="text-sm text-slate-500 mb-6">Anda belum memasukkan data kandidat satupun ke sistem.</p>
                                <a href="{{ route('admin-event.categories.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                    + Kelola Kandidat Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.progress-bar-fill');
            setTimeout(() => {
                bars.forEach(bar => {
                    const targetWidth = bar.getAttribute('data-width');
                    if (targetWidth) {
                        bar.style.width = targetWidth;
                    }
                });
            }, 500);
        });
    </script>
    @endpush
    @endsection