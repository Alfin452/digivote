<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Panitia') - DigiVote</title>

    {{-- Google Fonts Premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Gunakan Vite standar Laravel (Menghilangkan warning CDN) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Pendukung --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            background-color: #F8FAFC;
        }

        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>

<body class="text-slate-800 antialiased flex h-screen overflow-hidden selection:bg-blue-200 selection:text-blue-900" x-data="{ sidebarOpen: false }">

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false"></div>

    {{-- SIDEBAR --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-30 w-72 bg-[#0F172A] flex flex-col transition-transform duration-300 lg:static lg:translate-x-0 border-r border-slate-800/60 shadow-2xl lg:shadow-none">

        {{-- Logo Area --}}
        <div class="pt-8 pb-6 flex flex-col items-center justify-center border-b border-slate-800/60">
            <div class="w-16 h-16 rounded-full bg-slate-800/50 border-2 border-slate-700 flex items-center justify-center overflow-hidden shrink-0 p-0.5 mb-3 shadow-lg shadow-black/20">
                <img src="{{ asset('images/logo.jpeg') }}" alt="DigiVote Logo" class="w-full h-full object-contain rounded-full">
            </div>
            <div class="text-center flex items-center gap-2">
                <span class="font-bold text-2xl tracking-tight text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Digi<span class="text-yellow-400">Vote</span>
                </span>
                <span class="px-2 py-0.5 bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded text-[10px] font-bold uppercase tracking-wider">Event</span>
            </div>
        </div>

        {{-- Navigation Links --}}
        <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 space-y-1">

            <div class="px-8 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Dashboard</div>

            <a href="{{ route('admin-event.dashboard') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.dashboard') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.dashboard') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="font-medium">Overview Event</span>
            </a>

            <a href="{{ route('admin-event.leaderboard') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.leaderboard') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.leaderboard') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="font-medium">Leaderboard</span>
            </a>

            <div class="px-8 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kandidat & Kategori</div>

            <a href="{{ route('admin-event.categories.index') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.categories.*') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.categories.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="font-medium">Kelola Kandidat</span>
            </a>

            <div class="px-8 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keuangan & Data</div>

            <a href="{{ route('admin-event.transactions') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.transactions') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.transactions') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">Data Transaksi</span>
            </a>

            <a href="{{ route('admin-event.votes') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.votes') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.votes') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium">Rekap Suara Sah</span>
            </a>

            <div class="px-8 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Share Media</div>

            <a href="{{ route('admin-event.qr-links') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin-event.qr-links') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin-event.qr-links') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                <span class="font-medium">QR Code & Link</span>
            </a>
        </nav>

        {{-- Profil & Logout Area --}}
        <div class="p-6 bg-[#0B1120] border-t border-slate-800/60">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold shrink-0">
                    {{ substr(Auth::guard('event_admin')->user()->name ?? 'P', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-sm font-bold text-slate-200 truncate">{{ Auth::guard('event_admin')->user()->name ?? 'Panitia Event' }}</div>
                    <div class="text-[11px] text-blue-400 font-medium truncate flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                        {{ Str::limit(Auth::guard('event_admin')->user()->event->name ?? 'Tidak ada event', 20) }}
                    </div>
                </div>
            </div>

            <form id="logout-form" action="{{ route('admin-event.logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex justify-center items-center px-4 py-2.5 text-sm text-slate-400 border border-slate-700/50 hover:border-red-500/30 hover:bg-red-500/10 hover:text-red-400 rounded-lg font-medium transition-all duration-200 group">
                    <svg class="w-4 h-4 mr-2 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">

        {{-- Sticky Header --}}
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-10">
            <div class="flex items-center gap-5">
                <button @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg lg:hidden transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-slate-800 hidden sm:block" style="font-family: 'Plus Jakarta Sans', sans-serif;">@yield('title', 'Dashboard Event')</h1>
                    <p class="text-xs text-slate-500 hidden sm:block mt-0.5">Kelola kandidat, pantau suara, dan lihat statistik event.</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</span>
                </div>
            </div>
        </header>

        {{-- Dynamic Content --}}
        <div class="flex-1 overflow-y-auto p-2 lg:p-5 pb-24">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    {{-- Scripts Master --}}
    <script>
        const swalConfig = Swal.mixin({
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-slate-100',
                title: 'font-bold text-slate-800',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-6 py-2.5 transition-colors',
                cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors'
            },
            buttonsStyling: false
        });

        function confirmLogout() {
            swalConfig.fire({
                title: 'Keluar Sistem?',
                text: "Anda akan mengakhiri sesi manajemen event ini.",
                icon: 'warning',
                iconColor: '#EF4444',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg px-6 py-2.5 transition-colors',
                    cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors',
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    title: 'font-bold text-slate-800'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
        @endif

        @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
        @endif
    </script>

    @stack('scripts')
</body>

</html>