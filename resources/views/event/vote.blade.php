<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung {{ $team->name }} - {{ $event->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center pt-10 px-4">

    <div class="max-w-md w-full">
        <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 font-semibold transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Halaman Event
        </a>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50 p-6 text-center border-b border-blue-100">
                <p class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-2">Anda mendukung</p>
                <h2 class="text-2xl font-black text-gray-900">{{ $team->name }}</h2>
                <p class="text-gray-500 mt-1">{{ $team->location }}</p>
            </div>

            <div class="p-6 md:p-8">
                <form action="{{ route('vote.store', $event->slug) }}" method="POST">
                    @csrf
                    <input type="hidden" name="team_number" value="{{ $team->number }}">

                    <div class="mb-5">
                        <label for="voter_name" class="block text-sm font-bold text-gray-700 mb-2">Nama Anda (Opsional)</label>
                        <input type="text" name="voter_name" id="voter_name" placeholder="Boleh dikosongkan" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                    </div>

                    <div class="mb-6">
                        <label for="vote_qty" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Suara <span class="text-red-500">*</span></label>
                        <input type="number" name="vote_qty" id="vote_qty" value="{{ $event->min_vote }}" min="{{ $event->min_vote }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-xl font-bold text-center transition-all">
                        <p class="text-sm text-gray-500 mt-2 text-center">Harga per suara: Rp <span id="price_per_vote" data-price="{{ $event->price_per_vote }}">{{ number_format($event->price_per_vote, 0, ',', '.') }}</span></p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-8 border border-gray-200 flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total Bayar:</span>
                        <span class="text-2xl font-black text-blue-600">Rp <span id="total_amount">{{ number_format($event->price_per_vote * $event->min_vote, 0, ',', '.') }}</span></span>
                    </div>

                    @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition-colors shadow-sm text-lg flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Lanjut Bayar
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-4 flex items-center justify-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        Pembayaran aman via QRIS Xendit
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const qtyInput = document.getElementById('vote_qty');
        const pricePerVote = parseInt(document.getElementById('price_per_vote').getAttribute('data-price'));
        const totalAmount = document.getElementById('total_amount');

        qtyInput.addEventListener('input', function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 1) qty = 0;
            let total = qty * pricePerVote;
            // Format format Rupiah sederhana
            totalAmount.innerText = total.toLocaleString('id-ID');
        });
    </script>
</body>

</html>