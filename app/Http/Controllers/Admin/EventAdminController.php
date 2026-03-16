<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventAdmin;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class EventAdminController extends Controller
{
    public function index(Request $request) // PERBAIKAN: Tambahkan Request $request
    {
        $query = EventAdmin::with('event');

        // 1. Fitur Search (Nama atau Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filter Status Event (Sudah Tertaut / Belum)
        if ($request->filled('event_filter')) {
            if ($request->event_filter === 'linked') {
                $query->whereNotNull('event_id');
            } elseif ($request->event_filter === 'unlinked') {
                $query->whereNull('event_id');
            }
        }

        // 3. Fitur Urutkan (Sort)
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Eksekusi query dengan pagination
        $admins = $query->paginate(10);
        return view('admin.event_admins.index', compact('admins'));
    }

    public function create()
    {
        // Ambil semua event untuk pilihan di dropdown
        $events = Event::orderByDesc('created_at')->get();
        return view('admin.event_admins.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id|unique:event_admins,event_id', // 1 Event = 1 Akun Panitia
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:event_admins,email',
            'password' => 'required|min:6',
        ], [
            'event_id.unique' => 'Event ini sudah memiliki akun panitia!',
            'email.unique' => 'Email ini sudah terdaftar!'
        ]);

        EventAdmin::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        return redirect()->route('admin.event-admins.index')->with('success', 'Akun Panitia berhasil dibuat!');
    }

    public function edit($id)
    {
        // Ubah variabel $admin menjadi $eventAdmin
        $eventAdmin = EventAdmin::findOrFail($id);
        $events = Event::orderByDesc('created_at')->get();

        // Sesuaikan compact memanggil 'eventAdmin'
        return view('admin.event_admins.edit', compact('eventAdmin', 'events'));
    }

    public function update(Request $request, $id)
    {
        $admin = EventAdmin::findOrFail($id);

        $request->validate([
            'event_id' => 'required|exists:events,id|unique:event_admins,event_id,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:event_admins,email,' . $id,
            'password' => 'nullable|min:6', // Password opsional saat diedit
        ], [
            'event_id.unique' => 'Event ini sudah memiliki akun panitia!',
            'email.unique' => 'Email ini sudah dipakai oleh akun lain!'
        ]);

        $data = [
            'event_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.event-admins.index')->with('success', 'Data Akun Panitia berhasil diperbarui!');
    }

    public function destroy($id)
    {
        EventAdmin::findOrFail($id)->delete();
        return redirect()->route('admin.event-admins.index')->with('success', 'Akun Panitia berhasil dihapus!');
    }
}
