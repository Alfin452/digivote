<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Event') - DigiVote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <span class="font-black text-2xl text-blue-600 tracking-tight">DigiVote</span>
            <span class="ml-2 px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-[10px] font-bold uppercase">Event</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin-event.dashboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin-event.dashboard') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100 font-medium' }} rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Overview
            </a>

            <a href="{{ route('admin-event.leaderboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin-event.leaderboard') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100 font-medium' }} rounded-lg transition-colors mt-2">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Leaderboard
            </a>
            <a href="{{ route('admin-event.transactions') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin-event.transactions') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100 font-medium' }} rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pemasukan
            </a>
            <a href="{{ route('admin-event.votes') }}" class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Data Suara
            </a>
            <a href="{{ route('admin-event.qr-links') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('admin-event.qr-links') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100 font-medium' }} rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                QR Code & Links
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="text-sm font-bold text-gray-900 truncate">{{ Auth::guard('event_admin')->user()->name }}</div>
            <div class="text-xs text-gray-500 mb-3 truncate">{{ Auth::guard('event_admin')->user()->event->name ?? 'Tidak ada event' }}</div>
            <form action="{{ route('admin-event.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center px-3 py-2 text-sm text-red-600 border border-red-200 hover:bg-red-50 rounded-lg font-bold transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:hidden">
            <span class="font-black text-xl text-blue-600">DigiVote</span>
            <span class="text-sm font-bold text-gray-700">{{ Auth::guard('event_admin')->user()->name }}</span>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </div>
    </main>

    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
        @endif
    </script>
</body>

</html>