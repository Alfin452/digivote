@extends('layouts.admin')

@section('title', 'Akun Panitia')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Akun Panitia</h1>
        <p class="text-slate-400 mt-2 text-sm">Kelola akses login untuk masing-masing panitia penyelenggara event.</p>
    </div>
    <a href="{{ route('admin.event-admins.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 border border-indigo-500/50 rounded-xl text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition-all hover:shadow-indigo-500/40">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
        </svg>
        Buat Akun Panitia
    </a>
</div>

<div class="bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-3xl overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-800/30 border-b border-slate-800">
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama & Email</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tertaut Pada Event</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tgl Dibuat</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @foreach($admins as $adm)
                <tr class="hover:bg-slate-800/20 transition-colors group">
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-slate-400 mr-3">
                                {{ substr($adm->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-200">{{ $adm->name }}</div>
                                <div class="text-[11px] text-slate-500 font-medium">{{ $adm->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($adm->event)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold">
                            {{ $adm->event->name }}
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold">
                            No Event Linked
                        </span>
                        @endif
                    </td>
                    <td class="py-5 px-6">
                        <div class="text-sm text-slate-400">{{ $adm->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.event-admins.edit', $adm->id) }}" class="p-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-lg text-slate-300 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.event-admins.destroy', $adm->id) }}" method="POST" id="delete-form-{{ $adm->id }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $adm->id }})" class="p-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 rounded-lg text-red-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($admins->hasPages())
    <div class="p-4 border-t border-slate-800 bg-slate-900/30">
        {{ $admins->links() }}
    </div>
    @endif
</div>

<script>
    function confirmDelete(id) {
        swalDark.fire({
            title: 'Hapus Akun Panitia?',
            text: "Panitia tidak akan bisa login lagi ke sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#334155',
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