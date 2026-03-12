@extends('layouts.admin-event')
@section('title', 'Kategori Event')
@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-black text-slate-100 tracking-tight">Kategori Event</h1>
        <p class="text-slate-400 mt-1">Kelola kategori lomba/voting (Contoh: Presiden BEM, Ketua HIMA, dll).</p>
    </div>
    <a href="{{ route('admin-event.categories.create') }}" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl shadow-lg shadow-purple-500/20 transition-all">
        + Buat Kategori
    </a>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-800/50 border-b border-slate-800">
            <tr>
                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase">Nama Kategori</th>
                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase text-center">Urutan Tampil</th>
                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/50">
            @forelse($categories as $cat)
            <tr class="hover:bg-slate-800/20 transition-colors">
                <td class="py-4 px-6 font-bold text-slate-200">{{ $cat->name }}</td>
                <td class="py-4 px-6 text-center text-slate-400">{{ $cat->sort_order }}</td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('admin-event.categories.edit', $cat->id) }}" class="text-blue-400 hover:text-blue-300 font-bold text-sm">Edit</a>
                        <form action="{{ route('admin-event.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Pastikan kosong dari kandidat.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 font-bold text-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="py-8 text-center text-slate-500 font-medium">Belum ada kategori. Silakan buat baru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection