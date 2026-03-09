@extends('layouts.admin')

@section('title', 'Manajemen Event')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Data Event Acara</h1>
        <p class="text-gray-500 mt-1">Kelola seluruh acara kompetisi dan atur harga per voting.</p>
    </div>

    <a href="{{ route('admin.events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm inline-flex items-center transition-colors shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Buat Event Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Event Info</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Harga/Vote</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider">Periode Acara</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider text-center">Status</th>
                    <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($events as $event)
                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50">
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            @if($event->logo_path)
                            <img src="{{ asset('storage/' . $event->logo_path) }}" class="w-10 h-10 rounded-lg object-cover mr-3 border border-gray-200">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-100">
                                EV
                            </div>
                            @endif
                            <div>
                                <div class="font-bold text-gray-900">{{ $event->name }}</div>
                                <div class="text-xs text-blue-600 font-mono mt-0.5">/{{ $event->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 font-black text-gray-800">
                        Rp {{ number_format($event->price_per_vote, 0, ',', '.') }}
                    </td>
                    <td class="py-4 px-6 text-gray-600">
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} - <br>
                        {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($event->status === 'active')
                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Active</span>
                        @elseif($event->status === 'completed')
                        <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Completed</span>
                        @else
                        <span class="bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Draft</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm transition-colors px-2">Edit</a>

                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" id="delete-form-{{ $event->id }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $event->id }})" class="text-red-600 hover:text-red-800 font-bold text-sm transition-colors px-2">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500">Belum ada data event.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $events->links() }}
    </div>
    @endif
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Event Ini?',
            text: "Semua data kandidat dan suara terkait event ini bisa bermasalah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
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