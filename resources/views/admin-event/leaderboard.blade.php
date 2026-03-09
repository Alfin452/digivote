@extends('layouts.admin-event')

@section('title', 'Leaderboard & Kandidat')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-100">Leaderboard & Kandidat</h1>
        <p class="text-slate-400 mt-1">Peringkat perolehan suara sekaligus manajemen data kandidat.</p>
    </div>

    <a href="{{ route('admin-event.team.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm inline-flex items-center transition-colors shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kandidat Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-emerald-500/10 text-emerald-400 p-4 rounded-xl border border-emerald-500/20 font-bold text-sm shadow-sm flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-slate-900 rounded-2xl shadow-sm border border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-950/50 border-b border-slate-800">
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center w-20">Peringkat</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider w-24">No. Urut</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Profil Kandidat</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-right">Perolehan Suara</th>
                    <th class="py-4 px-6 font-bold text-xs text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($teams as $index => $team)
                <tr class="hover:bg-slate-800/50 transition-colors border-b border-slate-800/50">
                    <td class="py-4 px-6 text-center">
                        @if($index === 0)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 font-bold text-sm">1</span>
                        @elseif($index === 1)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-700 text-slate-300 border border-slate-600 font-bold text-sm">2</span>
                        @elseif($index === 2)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30 font-bold text-sm">3</span>
                        @else
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-slate-400 font-bold text-sm">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center font-black text-xl text-slate-500">{{ $team->number }}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            @if($team->image_path)
                            <img src="{{ asset('storage/' . $team->image_path) }}" class="w-10 h-10 rounded-full object-cover mr-3 border border-slate-700">
                            @else
                            <div class="w-10 h-10 rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center font-bold mr-3">
                                {{ $team->number }}
                            </div>
                            @endif
                            <div>
                                <div class="font-bold text-slate-200">{{ $team->name }}</div>
                                <div class="text-xs text-slate-400">{{ $team->location }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-slate-300">{{ $team->category->name ?? 'Umum' }}</td>
                    <td class="py-4 px-6 text-right font-black text-2xl text-cyan-400">{{ number_format($team->vote_count, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin-event.team.edit', $team->id) }}" class="text-purple-400 hover:text-purple-300 font-bold text-sm transition-colors px-2">Edit</a>

                            <form action="{{ route('admin-event.team.destroy', $team->id) }}" method="POST" id="delete-form-{{ $team->id }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $team->id }})" class="text-red-400 hover:text-red-300 font-bold text-sm transition-colors px-2">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-slate-500">
                        Belum ada kandidat yang didaftarkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id) {
        swalDark.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data kandidat yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection