<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Panel') - DigiVote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Subtle scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-300 font-sans flex h-screen overflow-hidden selection:bg-purple-500/30">

    <aside class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="font-black text-2xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-cyan-400">DigiVote</span>
            <span class="ml-2 px-2 py-0.5 bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded text-[10px] font-bold uppercase">Master</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-purple-400 font-bold border-r-2 border-purple-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium' }} rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Overview
            </a>

            <div class="px-3 mt-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Manajemen</div>

            <a href="{{ route('admin.events.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin.events.*') ? 'bg-slate-800 text-purple-400 font-bold border-r-2 border-purple-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium' }} rounded-lg transition-colors mt-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Data Event Acara
            </a>

            <a href="{{ route('admin.event-admins.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin.event-admins.*') ? 'bg-slate-800 text-purple-400 font-bold border-r-2 border-purple-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium' }} rounded-lg transition-colors mt-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Akun Panitia
            </a>

            <div class="px-3 mt-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sistem</div>

            <a href="#" class="flex items-center px-3 py-2.5 text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium rounded-lg transition-colors mt-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Semua Transaksi
            </a>

            <a href="#" class="flex items-center px-3 py-2.5 text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium rounded-lg transition-colors mt-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Konfigurasi
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900/50">
            <div class="text-sm font-bold text-slate-200 truncate">{{ Auth::guard('super_admin')->user()->name ?? 'Super Admin' }}</div>
            <div class="text-xs text-slate-500 mb-3 truncate">System Administrator</div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center px-3 py-2 text-sm text-red-400 border border-red-500/30 hover:bg-red-500/10 rounded-lg font-bold transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-950">
        <header class="h-16 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-4 md:hidden">
            <span class="font-black text-xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-cyan-400">DigiVote</span>
            <span class="text-sm font-bold text-slate-300">{{ Auth::guard('super_admin')->user()->name ?? 'Admin' }}</span>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </div>
    </main>

    <script>
        const swalDark = Swal.mixin({
            background: '#1e293b',
            color: '#f8fafc',
            confirmButtonColor: '#a855f7',
        });

        @if(session('success'))
        swalDark.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
        @endif

        @if(session('error'))
        swalDark.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
        @endif
    </script>
    @stack('scripts')
</body>

</html>