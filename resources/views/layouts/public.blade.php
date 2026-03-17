<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Digivote')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Fredoka', 'ui-sans-serif', 'sans-serif'],
                    },
                    colors: {
                        pastel: {
                            yellow: '#fdf3c6',
                            yellowLight: '#fdfaf2',
                            purple: '#e5d9f2',
                            green: '#cce6d2',
                            pink: '#fadcf1',
                            blue: '#d7f0fa',
                            orange: '#fadab4',
                            dark: '#2d3748',
                            muted: '#718096',
                        }
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
                        '6xl': '3rem',
                    }
                }
            }
        }
    </script>
    <style>
        body { color: #2d3748; background-color: #fafbfc; }
        .bento-card {
            border-radius: 2rem;
            transition: all 0.3s ease;
        }
        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }
        .nav-pill-group {
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-pastel-pink selection:text-pastel-dark">

    <!-- Top Navbar (Playful Bento Style) -->
    <header class="fixed w-full z-50 bg-white/80 backdrop-blur-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-pastel-pink rounded-2xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                    <svg class="w-6 h-6 text-pastel-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="font-display font-bold text-2xl tracking-tight text-pastel-dark">DigiVote</span>
            </a>

            <!-- Navigation Links (Pill Group) -->
            <nav class="hidden md:flex p-1.5 bg-white rounded-full nav-pill-group border border-gray-100">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-pastel-yellow text-pastel-dark shadow-sm' : 'text-pastel-muted hover:bg-gray-50' }} px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 flex items-center gap-2">
                    Beranda
                </a>
                <a href="{{ route('home.cara-kerja') }}" class="{{ request()->routeIs('home.cara-kerja') ? 'bg-pastel-yellow text-pastel-dark shadow-sm' : 'text-pastel-muted hover:bg-gray-50' }} px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 flex items-center gap-2">
                    Cara Kerja
                </a>
                <a href="{{ route('home.live-events') }}" class="{{ request()->routeIs('home.live-events') ? 'bg-pastel-yellow text-pastel-dark shadow-sm' : 'text-pastel-muted hover:bg-gray-50' }} px-5 py-2 rounded-full font-bold text-sm transition-all duration-300 flex items-center gap-2">
                    Katalog
                </a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin-event.login') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold rounded-full text-pastel-dark bg-pastel-green hover:bg-[#b8d6b1] transition-colors shadow-sm transform hover:-translate-y-0.5">
                    Konsol Dashboard
                </a>
                
                <!-- Mobile button -->
                <button class="md:hidden bg-white p-2.5 rounded-full nav-pill-group border border-gray-100 text-pastel-dark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-auto pt-16 pb-8 border-t border-gray-100 overflow-hidden relative">
        <!-- Playful Background Blobs -->
        <div class="absolute -top-32 -left-20 w-80 h-80 bg-pastel-yellow rounded-full mix-blend-multiply filter blur-[100px] opacity-40 pointer-events-none"></div>
        <div class="absolute top-10 right-0 w-72 h-72 bg-pastel-purple rounded-full mix-blend-multiply filter blur-[100px] opacity-40 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-12">
                <!-- Col 1: Brand & Desc -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-pastel-purple rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pastel-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        </div>
                        <div>
                            <span class="block font-display font-bold text-xl text-pastel-dark leading-none">DigiVote</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-pastel-muted mb-6">
                        Menghadirkan kebahagiaan dan kemudahan dalam setiap pemilihan. Cepat, aman, dan sangat menghibur!
                    </p>
                    <div class="inline-flex items-center justify-center gap-2 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-pastel-green animate-pulse"></span>
                        <span class="text-xs font-bold text-pastel-muted">Sistem Online & Aman</span>
                    </div>
                </div>

                <!-- Col 2: Platform -->
                <div>
                    <h4 class="font-bold text-pastel-dark mb-4">Platform</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pastel-yellow opacity-0 hover:opacity-100 transition-opacity"></div>Beranda</a></li>
                        <li><a href="{{ route('home.live-events') }}" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pastel-pink opacity-0 hover:opacity-100 transition-opacity"></div>Katalog Event</a></li>
                        <li><a href="{{ route('home.cara-kerja') }}" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pastel-green opacity-0 hover:opacity-100 transition-opacity"></div>Cara Kerja</a></li>
                        <li><a href="{{ route('admin-event.login') }}" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pastel-blue opacity-0 hover:opacity-100 transition-opacity"></div>Konsol Dashboard</a></li>
                    </ul>
                </div>

                <!-- Col 3: Resource -->
                <div>
                    <h4 class="font-bold text-pastel-dark mb-4">Informasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Panduan Pemilih</a></li>
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Pusat Bantuan</a></li>
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Status Sistem</a></li>
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Blog</a></li>
                    </ul>
                </div>

                <!-- Col 4: Legal -->
                <div>
                    <h4 class="font-bold text-pastel-dark mb-4">Legalitas</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-sm font-medium text-pastel-muted hover:text-pastel-dark transition-colors flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-gray-300 opacity-0 hover:opacity-100 transition-opacity"></div>Kebijakan Cookies</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-100 text-center flex flex-col items-center">
                <span class="text-xs font-bold text-pastel-muted">&copy; {{ date('Y') }} DigiVote ID. Seluruh Hak Cipta Dilindungi.</span>
            </div>
        </div>
    </footer>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    @stack('scripts')
</body>
</html>
