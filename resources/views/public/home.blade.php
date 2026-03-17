@extends('layouts.public')

@section('title', 'DigiVote - Bring Joy to Voting')

@section('content')
<div class="relative w-full overflow-hidden bg-[#fafbfc]">
    <!-- Hero Section -->
    <div class="relative pt-20 pb-16 text-center z-10">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-gradient-to-r from-pastel-pink via-pastel-yellow to-pastel-blue opacity-50 blur-[80px] -z-10 rounded-full pointer-events-none"></div>
        
        <div class="flex justify-center gap-4 mb-6">
            <div class="w-16 h-16 bg-pastel-pink rounded-[24px] rotate-[-10deg] flex items-center justify-center text-pastel-dark font-display text-2xl" style="animation: bounce 3s infinite;">
                ^ᴗ^
            </div>
            <div class="w-16 h-16 bg-pastel-orange rounded-[24px] rotate-[10deg] flex items-center justify-center text-pastel-dark font-display text-2xl" style="animation: bounce 3.5s infinite; animation-delay: 0.5s;">
                *ᴗ*
            </div>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-display font-bold text-pastel-dark tracking-tight mb-6 mt-4 leading-tight">
            Pemilihan Umum<br>yang Menyenangkan!
        </h1>
        <p class="text-lg md:text-xl text-pastel-muted max-w-2xl mx-auto font-medium px-4">
            Ruang khusus untuk penyelenggara dan pemilih. Cepat, aman, dan sangat menghibur.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 px-4 relative z-20">
            <a href="{{ route('home.live-events') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-pastel-dark bg-pastel-yellow hover:bg-[#fae486] transition-transform transform hover:-translate-y-1 shadow-sm w-full sm:w-auto">
                Eksplorasi Katalog Event &nbsp; 🎉
            </a>
            <a href="{{ route('home.cara-kerja') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-pastel-dark bg-white border border-gray-100 hover:bg-gray-50 transition-transform transform hover:-translate-y-1 shadow-sm w-full sm:w-auto">
                Pelajari Cara Kerja
            </a>
        </div>
    </div>

    <!-- Bento Grid Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-24 z-10 relative">
        <div class="inline-block px-4 py-1.5 bg-pastel-yellow/50 text-pastel-dark font-bold text-sm rounded-full mb-6 relative z-10">
            #FEATURES
        </div>
        <h2 class="text-3xl md:text-4xl font-display font-bold text-pastel-dark mb-10 relative z-10">Ruang khusus untuk segala<br>kebutuhan voting-mu</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-[280px]">
            
            <!-- Large Card: Active Events -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2 bento-card bg-white p-8 border border-gray-100 relative overflow-hidden flex flex-col justify-between group">
                <div class="z-10">
                    <h3 class="text-2xl font-bold text-pastel-dark mb-3">Vote dari mana saja.</h3>
                    <p class="text-pastel-muted font-medium pr-12 lg:pr-40 text-sm md:text-base">Dengan integrasi QRIS yang aman, kamu bisa memberikan suara untuk kandidat favoritmu dalam hitungan detik, secara harfiah di mana pun.</p>
                </div>
                <div class="mt-8 z-10 relative">
                    <a href="{{ route('home.live-events') }}" class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full text-pastel-dark group-hover:bg-pastel-yellow group-hover:scale-110 transition-all border border-gray-100 relative z-20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                <!-- Mockup decoration -->
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gray-50 rounded-[3rem] border-8 border-white shadow-xl transform rotate-12 transition-transform group-hover:rotate-6 flex flex-col p-6 pointer-events-none z-0">
                    <div class="w-full space-y-4 mt-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-pastel-yellow rounded-full"></div>
                            <div class="w-24 h-4 bg-gray-200 rounded-full"></div>
                        </div>
                        <div class="w-full h-12 bg-pastel-blue/30 rounded-xl"></div>
                        <div class="w-2/3 h-12 bg-pastel-green/30 rounded-xl"></div>
                    </div>
                </div>
            </div>

            <!-- Card: Cara Kerja -->
            <div class="bento-card bg-pastel-yellowLight p-8 relative overflow-hidden group">
                <div class="absolute -right-4 top-20 w-32 h-32 bg-pastel-yellow rounded-full mix-blend-multiply opacity-50 group-hover:scale-[2] transition-transform duration-700 pointer-events-none z-0"></div>
                
                <h3 class="text-xl font-bold text-pastel-dark mb-3 relative z-10">Pahami cara<br>kerjanya.</h3>
                <div class="absolute bottom-6 right-6 z-20">
                    <a href="{{ route('home.cara-kerja') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full text-pastel-dark group-hover:scale-110 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card: Security -->
            <div class="bento-card bg-pastel-green p-8 relative overflow-hidden group">
                <h3 class="text-xl font-bold text-pastel-dark mb-2 z-10 relative">Aman dan 100%<br>anonim.</h3>
                <!-- Happy abstract bars -->
                <div class="absolute bottom-0 left-0 right-0 h-40 flex items-end justify-center gap-3 px-6 pointer-events-none z-0">
                    <div class="w-10 h-24 bg-white/50 rounded-t-full flex justify-center pt-3 relative transform group-hover:-translate-y-2 transition-transform">
                        <span class="text-pastel-dark font-display text-xs">╹o╹</span>
                    </div>
                    <div class="w-10 h-16 bg-white/40 rounded-t-full flex justify-center pt-3 relative transform group-hover:translate-y-2 transition-transform delay-100">
                        <span class="text-pastel-dark font-display text-xs">^o^</span>
                    </div>
                    <div class="w-10 h-32 bg-white/60 rounded-t-full flex justify-center pt-3 relative transform group-hover:-translate-y-4 transition-transform delay-200">
                        <span class="text-pastel-dark font-display text-xs">^ᴗ^</span>
                    </div>
                </div>
                <div class="absolute bottom-6 right-6 z-20">
                    <div class="inline-flex items-center justify-center w-3 h-3 bg-white rounded-full"></div>
                </div>
            </div>

            <!-- Card: Realtime -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2 lg:col-start-2 bento-card bg-pastel-purple p-8 flex flex-col md:flex-row gap-6 relative overflow-hidden group items-center">
                <div class="flex-1 z-10">
                    <div class="inline-flex items-center justify-center px-3 py-1 bg-white/50 text-pastel-dark text-xs font-bold rounded-full mb-4 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-pastel-dark animate-pulse mr-2"></span> REALTIME
                    </div>
                    <h3 class="text-2xl font-bold text-pastel-dark mb-3">Pantau telemetri live.</h3>
                    <p class="text-pastel-dark/80 font-medium text-sm">Lihat suara masuk secara instan. Nggak perlu refresh lagi deh.</p>
                </div>
                <!-- Mini dash mockup -->
                <div class="w-full md:w-1/2 bg-white border border-gray-100 rounded-[2rem] h-48 md:h-full p-5 shadow-sm flex flex-col relative overflow-hidden transform group-hover:scale-[1.03] transition-transform pointer-events-none z-0 mt-4 md:mt-0">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-16 h-3 bg-gray-100 rounded-full"></div>
                        <div class="w-8 h-3 bg-pastel-yellow rounded-full"></div>
                    </div>
                    <div class="w-2/3 h-6 bg-pastel-dark/5 rounded-full mb-auto mt-2"></div>
                    <div class="relative w-full h-16 mt-auto border-b-2 border-l-2 border-gray-100 flex items-end gap-2 pb-1 pl-1">
                        <div class="w-1/5 bg-pastel-pink rounded-t-lg h-1/3"></div>
                        <div class="w-1/5 bg-pastel-yellow rounded-t-lg h-1/2"></div>
                        <div class="w-1/5 bg-pastel-green rounded-t-lg h-3/4"></div>
                        <div class="w-1/5 bg-pastel-blue rounded-t-lg h-full"></div>
                        <div class="w-1/5 bg-pastel-purple rounded-t-lg h-5/6"></div>
                    </div>
                </div>
            </div>

            <!-- Card: Polaroid Fun -->
            <div class="bento-card bg-pastel-yellow p-8 relative overflow-hidden group">
                <h3 class="text-xl font-bold text-pastel-dark mb-2 z-10 relative">Temukan kandidat<br>pilihanmu.</h3>
                <!-- Fun polaroids -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
                    <div class="w-16 h-20 bg-white p-2 pb-6 rounded-lg shadow-md transform -rotate-12 translate-x-4 translate-y-4 group-hover:-rotate-6 transition-transform">
                        <div class="w-full h-full bg-pastel-orange rounded-md flex items-center justify-center">
                            <span class="font-display font-medium text-pastel-dark text-xs">╹_╹</span>
                        </div>
                    </div>
                    <div class="w-16 h-20 bg-white p-2 pb-6 rounded-lg shadow-lg transform rotate-6 -translate-x-4 -translate-y-2 group-hover:rotate-12 group-hover:-translate-y-6 transition-transform z-10">
                        <div class="w-full h-full bg-pastel-blue rounded-md flex items-center justify-center">
                            <span class="font-display font-medium text-pastel-dark text-xs">*_*</span>
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-6 right-6 z-20">
                    <a href="{{ route('home.live-events') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full text-pastel-dark group-hover:scale-110 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Register ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // Hero Section Animations
        const heroTl = gsap.timeline();
        
        heroTl.fromTo('.pt-20 h1', 
            { y: 50, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.8, ease: "back.out(1.7)" }
        )
        .fromTo('.pt-20 p',
            { y: 30, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.6, ease: "power2.out" },
            "-=0.4"
        )
        .fromTo('.pt-20 .gap-4 a',
            { y: 20, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.5, stagger: 0.1, ease: "power2.out" },
            "-=0.2"
        );

        // Bento Cards Staggered Animation
        gsap.fromTo('.bento-card',
            { y: 60, opacity: 0 },
            {
                y: 0, 
                opacity: 1, 
                duration: 0.6, 
                stagger: 0.15, 
                ease: "power2.out",
                scrollTrigger: {
                    trigger: '.grid',
                    start: "top 80%", // Animates when the top of the grid hits 80% down the viewport
                    toggleActions: "play none none reverse"
                }
            }
        );
        
        // Floating animation for the hero character blobs (if we want to enhance CSS bounce with GSAP)
        gsap.to('.w-16.h-16.bg-pastel-pink', {
            y: -15,
            rotation: -15,
            duration: 2,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });
        
        gsap.to('.w-16.h-16.bg-pastel-orange', {
            y: -20,
            rotation: 15,
            duration: 2.5,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            delay: 0.2
        });
    });
</script>
@endpush
@endsection
