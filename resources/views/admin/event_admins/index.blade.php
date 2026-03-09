@extends('layouts.admin')

@section('title', 'Akun Panitia')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-black text-gray-900">Akun Panitia (Klien)</h1>
        <p class="text-gray-500 mt-1">Kelola akses login untuk masing-masing panitia penyelenggara event.</p>
    </div>
    <a href="{{ route('admin.event-admins.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all">
        + Buat Akun Panitia
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase">Nama & Email</th>
                <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase">Tertaut Pada Event</th>
                <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase">Tgl Dibuat</th>
                <th class="py-4 px-6 font-bold text-xs text-gray-400 uppercase text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $adm)
            <tr class="hover:bg-gray-50 border-b border-gray-100 transition-all">
                <td class="py-4 px-6">
                    <div class="font-bold text-gray-900">{{ $adm->name }}</div>
                    <div class="text-sm text-gray-500">{{ $adm->email }}</div>
                </td>
                <td class="py-4 px-6">
                    @if($adm->event)
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg text-xs font-bold">{{ $adm->event->name }}</span>
                    @else
                    <span class="text-red-500 text-xs font-bold">Event Tidak Ditemukan/Dihapus</span>
                    @endif
                </td>
                <td class="py-4 px-6 text-sm text-gray-500 font-medium">
                    {{ $adm->created_at->format('d M Y') }}
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('admin.event-admins.edit', $adm->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm transition-colors">Edit</a>
                        <form action="{{ route('admin.event-admins.destroy', $adm->id) }}" method="POST" id="delete-form-{{ $adm->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $adm->id }})" class="text-red-600 hover:text-red-800 font-bold text-sm transition-colors">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 bg-gray-50 border-t">
        {{ $admins->links() }}
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Akun Panitia?',
            text: "Panitia tidak akan bisa login lagi ke sistem!",
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