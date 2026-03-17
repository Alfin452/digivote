@extends('layouts.public')

@section('title', 'Dukung ' . $team->name . ' - ' . $event->name)

@section('content')
<div class="bg-google-gray min-h-[calc(100vh-64px)] py-12 px-4 flex flex-col items-center">
    
    <div class="max-w-md w-full">
        <!-- Back Link -->
        <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center text-sm font-medium text-google-textmuted hover:text-google-blue mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Event
        </a>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-google-border google-shadow overflow-hidden">
            
            <!-- Candidate Info Header -->
            <div class="p-6 border-b border-google-border bg-google-gray/30 text-center">
                @if($team->image_path)
                <div class="w-20 h-20 mx-auto rounded-full bg-white p-1 mb-3 border border-google-border shadow-sm">
                    <img src="{{ asset('storage/' . $team->image_path) }}" alt="{{ $team->name }}" class="w-full h-full rounded-full object-cover">
                </div>
                @else
                <div class="w-20 h-20 mx-auto rounded-full bg-google-blue/10 mb-3 flex items-center justify-center text-2xl font-display font-medium text-google-blue">
                    {{ $team->number }}
                </div>
                @endif

                <p class="text-[10px] font-medium text-google-textmuted uppercase tracking-widest mb-1">Mendukung Kandidat</p>
                <h2 class="text-xl font-display font-medium text-google-text mb-1">{{ $team->name }}</h2>
                <p class="text-google-textmuted text-xs flex items-center justify-center gap-1 mt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $team->location }}
                </p>
            </div>

            <div class="p-6 md:p-8">
                <form action="{{ route('vote.store', $event->slug) }}" method="POST">
                    @csrf
                    <input type="hidden" name="team_number" value="{{ $team->number }}">

                    <!-- Voter Name -->
                    <div class="mb-6">
                        <label for="voter_name" class="block text-sm font-medium text-google-text mb-1.5">Nama Pemilih (Opsional)</label>
                        <input type="text" name="voter_name" id="voter_name" placeholder="John Doe" class="w-full px-4 py-2.5 bg-white rounded border border-google-border focus:border-google-blue focus:ring-1 focus:ring-google-blue outline-none transition-all text-sm text-google-text">
                    </div>

                    <!-- Vote Quantity -->
                    <div class="mb-8 relative">
                        <label for="vote_qty" class="block text-sm font-medium text-google-text mb-1.5 flex justify-between items-center">
                            <span>Jumlah Suara <span class="text-google-red">*</span></span>
                            <span class="text-[10px] bg-google-gray text-google-textmuted px-2 py-0.5 rounded font-medium">Min: {{ $event->min_vote }}</span>
                        </label>
                        
                        <div class="flex items-center gap-3">
                            <button type="button" id="btn-minus" class="w-10 h-10 flex items-center justify-center rounded border border-google-border text-google-textmuted hover:bg-google-gray hover:text-google-text transition-colors select-none font-medium text-lg">&minus;</button>
                            
                            <input type="number" name="vote_qty" id="vote_qty" value="{{ $event->min_vote }}" min="{{ $event->min_vote }}" required 
                                class="w-full text-center py-2 bg-google-gray/30 rounded border border-google-border focus:bg-white focus:border-google-blue focus:ring-1 focus:ring-google-blue outline-none font-display text-xl text-google-text transition-all" 
                                style="-moz-appearance: textfield; appearance: textfield;">
                                
                            <button type="button" id="btn-plus" class="w-10 h-10 flex items-center justify-center rounded border border-google-border text-google-textmuted hover:bg-google-gray hover:text-google-text transition-colors select-none font-medium text-lg">&plus;</button>
                        </div>
                        
                        <p class="text-xs text-google-textmuted mt-2 text-right">Harga Satuan: Rp <span id="price_per_vote" data-price="{{ $event->price_per_vote }}">{{ number_format($event->price_per_vote, 0, ',', '.') }}</span></p>
                    </div>

                    <!-- Total Banner -->
                    <div class="bg-google-blue/5 rounded-lg border border-google-blue/20 p-4 mb-6 flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-google-bluedark mb-0.5">Total Tagihan</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-sm font-medium text-google-blue">Rp</span>
                                <span class="text-2xl font-display font-medium text-google-blue leading-none" id="total_amount">{{ number_format($event->price_per_vote * $event->min_vote, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 bg-white rounded flex items-center justify-center border border-google-blue/20">
                            <svg class="w-5 h-5 text-google-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>

                    @if ($errors->any())
                    <div class="bg-red-50 text-google-red p-3 rounded mb-6 text-sm border border-red-100 flex items-start">
                        <svg class="w-4 h-4 mr-2 shrink-0 mt-0.5 text-google-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded text-sm font-medium text-white bg-google-blue hover:bg-google-bluedark transition-colors google-shadow">
                        Bayar via QRIS Sekarang
                    </button>
                    
                    <!-- Secured by indicator -->
                    <div class="mt-4 flex flex-col justify-center items-center gap-1.5 opacity-60">
                        <span class="text-[10px] uppercase font-medium text-google-textmuted tracking-wider">Secured by</span>
                        <div class="flex items-center gap-1">
                            <div class="w-4 h-4 bg-[#1423B8] rounded-sm flex items-center justify-center">
                                <span class="text-[8px] font-bold text-white">X</span>
                            </div>
                            <span class="font-display font-medium text-[#1423B8] text-sm">xendit</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Remove number input arrows */
input[type="number"]::-webkit-inner-spin-button, 
input[type="number"]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>

<script>
    const qtyInput = document.getElementById('vote_qty');
    const pricePerVote = parseInt(document.getElementById('price_per_vote').getAttribute('data-price'));
    const totalAmountSpan = document.getElementById('total_amount');
    const btnMinus = document.getElementById('btn-minus');
    const btnPlus = document.getElementById('btn-plus');
    const minVote = parseInt(qtyInput.getAttribute('min'));

    function updateTotal() {
        let qty = parseInt(qtyInput.value);
        if (isNaN(qty) || qty < 1) qty = 0;
        let total = qty * pricePerVote;
        totalAmountSpan.innerText = total.toLocaleString('id-ID');
    }

    qtyInput.addEventListener('input', updateTotal);
    
    // Fallback if empty
    qtyInput.addEventListener('blur', function() {
        if(this.value === '' || parseInt(this.value) < minVote) {
             this.value = minVote;
             updateTotal();
        }
    });

    btnMinus.addEventListener('click', () => {
        let val = parseInt(qtyInput.value) || minVote;
        if(val > minVote) {
             qtyInput.value = val - 1;
             updateTotal();
        }
    });

    btnPlus.addEventListener('click', () => {
        let val = parseInt(qtyInput.value) || 0;
        qtyInput.value = val + 1;
        updateTotal();
    });
</script>
@endsection