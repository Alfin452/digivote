@extends('layouts.public')

@section('title', 'Welcome to DigiVote')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center p-6 bg-[#fafbfc]">
    <div class="bento-card bg-white p-8 md:p-12 max-w-xl text-center border border-gray-100 shadow-sm relative overflow-hidden group">
        <!-- Playful Background Accents -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-pastel-pink rounded-bl-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-pastel-yellow rounded-tr-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 text-center flex flex-col items-center">
           <div class="w-20 h-20 bg-pastel-blue rounded-[24px] rotate-[-10deg] flex items-center justify-center text-pastel-dark font-display text-3xl mx-auto mb-8 shadow-sm group-hover:rotate-0 transition-all duration-300">
                ^ᴗ^
            </div>
            
            <h1 class="text-3xl md:text-4xl font-display font-bold text-pastel-dark mb-4">
                Hello default Welcome Blade!
            </h1>
            
            <p class="text-pastel-muted font-medium mb-10 leading-relaxed">
                Welcome to DigiVote! Just a heads up, the actual public landing page is now handled by <code class="bg-gray-50 px-2 py-1 rounded text-pastel-dark border border-gray-100">home.blade.php</code>, but we've cleaned this page up for you so you don't have to see that scary default code anymore! ✨
            </p>
            
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-full text-pastel-dark bg-pastel-yellow hover:bg-[#fae486] transition-transform transform hover:-translate-y-1 shadow-sm">
                Ke Halaman Beranda
            </a>
        </div>
    </div>
</div>
@endsection
