<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Digivote')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Google Sans', 'Roboto', 'sans-serif'],
                    },
                    colors: {
                        google: {
                            blue: '#1a73e8',
                            bluedark: '#1558d6',
                            red: '#ea4335',
                            yellow: '#fbbc04',
                            green: '#34a853',
                            gray: '#f1f3f4',
                            text: '#202124',
                            textmuted: '#5f6368',
                            border: '#dadce0',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { color: #202124; background-color: #ffffff; }
        .google-shadow { box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15); }
        .google-shadow-hover:hover { box-shadow: 0 1px 3px 0 rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15); }
    </style>
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">

    <!-- Top Navbar (Google Style) -->
    <header class="fixed w-full z-50 bg-white border-b border-google-border">
        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-google-blue" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <span class="font-display font-medium text-[22px] tracking-tight text-google-text">DigiVote</span>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex gap-8 items-center">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-google-blue font-medium' : 'text-google-textmuted hover:text-google-text' }} transition-colors text-sm">
                    Ringkasan
                </a>
                <a href="{{ route('home.cara-kerja') }}" class="{{ request()->routeIs('home.cara-kerja') ? 'text-google-blue font-medium' : 'text-google-textmuted hover:text-google-text' }} transition-colors text-sm">
                    Cara Kerja
                </a>
                <a href="{{ route('home.live-events') }}" class="{{ request()->routeIs('home.live-events') ? 'text-google-blue font-medium' : 'text-google-textmuted hover:text-google-text' }} transition-colors text-sm">
                    Live Events
                </a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin-event.login') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-google-blue hover:bg-google-bluedark transition-colors google-shadow">
                    Konsol Penyelenggara
                </a>
                
                <!-- Mobile button -->
                <button class="md:hidden text-google-textmuted p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-google-border bg-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-google-textmuted">
                <div class="flex items-center gap-2">
                    <span class="font-display font-medium text-google-text">DigiVote</span>
                </div>
                <div>
                    <a href="#" class="hover:text-google-text px-3">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-google-text px-3">Persyaratan Dasar</a>
                    <a href="#" class="hover:text-google-text px-3">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
