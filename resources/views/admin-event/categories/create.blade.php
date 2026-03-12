@extends('layouts.admin-event')
@section('title', 'Buat Kategori')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-100 tracking-tight">Buat Kategori Baru</h1>
</div>
<div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 max-w-2xl">
    <form action="{{ route('admin-event.categories.store') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-sm font-bold text-slate-300 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" required placeholder="Misal: Kandidat Ketua BEM" class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 outline-none">
        </div>
        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-300 mb-2">Urutan Tampil (Sort Order)</label>
            <input type="number" name="sort_order" value="0" min="0" class="w-full px-4 py-3 bg-slate-950 text-slate-200 rounded-xl border border-slate-800 focus:border-purple-500 outline-none">
            <p class="text-xs text-slate-500 mt-1">Angka terkecil (0) akan tampil paling atas di web.</p>
        </div>
        <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white font-bold py-3 px-6 rounded-xl transition-all">Simpan Kategori</button>
    </form>
</div>
@endsection