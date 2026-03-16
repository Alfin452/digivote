<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Panel') - DigiVote</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

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

    <div x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-30 w-72 bg-[#0F172A] flex flex-col transition-transform duration-300 lg:static lg:translate-x-0 border-r border-slate-800/60 shadow-2xl lg:shadow-none">

        <div class="pt-8 pb-6 flex flex-col items-center justify-center border-b border-slate-800/60">
            <div class="w-16 h-16 rounded-full bg-slate-800/50 border-2 border-slate-700 flex items-center justify-center overflow-hidden shrink-0 p-0.5 mb-3 shadow-lg shadow-black/20">
                <img src="{{ asset('images/logo.jpeg') }}" alt="DigiVote Logo" class="w-full h-full object-contain rounded-full">
            </div>
            <div class="text-center">
                <span class="font-heading font-extrabold text-2xl tracking-tight text-white">
                    Digi<span class="text-yellow-400">Vote</span>
                </span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 space-y-1">

            <div class="px-8 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Dashboard</div>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="font-medium">Overview Panel</span>
            </a>
            <div class="px-8 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Master</div>

            <a href="{{ route('admin.events.index') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.events.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Data Event Acara</span>
            </a>

            <a href="{{ route('admin.event-admins.index') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin.event-admins.*') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.event-admins.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="font-medium">Akun Panitia</span>
            </a>

            <div class="px-8 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keuangan & Sistem</div>

            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin.transactions.*') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.transactions.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium">Semua Transaksi</span>
            </a>

            <a href="{{ route('admin.settings.index') }}"
                class="flex items-center px-8 py-3 transition-all duration-200 group relative {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-blue-500/10 to-transparent border-l-4 border-blue-500 text-blue-400' : 'text-slate-400 border-l-4 border-transparent hover:bg-slate-800/40 hover:text-slate-200' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">Konfigurasi Panel</span>
            </a>
        </nav>

        <div class="p-6 bg-[#0B1120] border-t border-slate-800/60">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold shrink-0">
                    {{ substr(Auth::guard('super_admin')->user()->name ?? 'S', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-sm font-bold text-slate-200 truncate">{{ Auth::guard('super_admin')->user()->name ?? 'Super Admin' }}</div>
                    <div class="text-xs text-slate-500 truncate flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Online
                    </div>
                </div>
            </div>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex justify-center items-center px-4 py-2.5 text-sm text-slate-400 border border-slate-700/50 hover:border-red-500/30 hover:bg-red-500/10 hover:text-red-400 rounded-lg font-medium transition-all duration-200 group">
                    <svg class="w-4 h-4 mr-2 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-10">
            <div class="flex items-center gap-5">
                <button @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg lg:hidden transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-heading font-bold text-slate-800 hidden sm:block">@yield('title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500 hidden sm:block mt-0.5">Pantau dan kelola aktivitas sistem secara real-time.</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</span>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-2 lg:p-5 pb-24">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        // Custom Font untuk SweetAlert agar matching dengan desain
        const swalConfig = Swal.mixin({
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-slate-100',
                title: 'font-heading font-bold text-slate-800',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-6 py-2.5 transition-colors',
                cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors'
            },
            buttonsStyling: false
        });

        // Logika Konfirmasi Logout
        function confirmLogout() {
            swalConfig.fire({
                title: 'Keluar?',
                text: "Anda harus login kembali untuk mengakses panel ini.",
                icon: 'warning',
                iconColor: '#EF4444',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    // Override khusus untuk tombol merah di alert logout
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg px-6 py-2.5 transition-colors',
                    cancelButton: 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-medium rounded-lg px-6 py-2.5 ml-3 transition-colors',
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    title: 'font-heading font-bold text-slate-800'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Eksekusi submit form jika user klik 'Ya'
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Global Alert (Toast) untuk Notifikasi Session (Success/Error)
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