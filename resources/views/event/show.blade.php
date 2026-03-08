<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} - DigiVote.id</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-10 px-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">{{ $event->name }}</h1>
            <p class="text-gray-500 mt-2 font-medium">Diselenggarakan oleh: {{ $event->org }}</p>
            <p class="text-gray-600 mt-5 leading-relaxed">{{ $event->description }}</p>

            <div class="mt-6 inline-flex items-center bg-blue-50 text-blue-700 px-5 py-2 rounded-full font-bold text-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                </svg>
                Harga: Rp {{ number_format($event->price_per_vote, 0, ',', '.') }} / Suara
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Kandidat & Leaderboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($teams as $team)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center hover:shadow-md transition-shadow">

                @if($team->image_path)
                <img src="{{ asset('storage/' . $team->image_path) }}" alt="{{ $team->name }}" class="w-24 h-24 rounded-full object-cover mb-4 border-4 border-gray-50">
                @else
                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center text-3xl font-black text-blue-600 mb-4 border-4 border-white shadow-sm">
                    {{ $team->number }}
                </div>
                @endif

                <h3 class="text-xl font-bold text-gray-900 text-center">{{ $team->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $team->category->name ?? 'Umum' }}</p>
                <p class="text-sm text-gray-500">{{ $team->location }}</p>

                <div class="mt-6 w-full">
                    <div class="bg-gray-50 rounded-xl py-3 text-center mb-4 border border-gray-100">
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Perolehan Suara</span>
                        <span class="block text-3xl font-black text-gray-800 mt-1">{{ number_format($team->vote_count, 0, ',', '.') }}</span>
                    </div>

                    <a href="#" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm">
                        Dukung Kandidat
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10 text-gray-500 bg-white rounded-2xl border border-dashed border-gray-300">
                Belum ada kandidat yang terdaftar di event ini.
            </div>
            @endforelse
        </div>

    </div>
</body>

</html>