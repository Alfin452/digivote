<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $eventAdmin = Auth::guard('event_admin')->user();

        // Ambil kategori hanya untuk event milik panitia ini saja
        $categories = Category::where('event_id', $eventAdmin->event_id)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin-event.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin-event.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $eventAdmin = Auth::guard('event_admin')->user();

        Category::create([
            'event_id' => $eventAdmin->event_id,
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0, // Default 0 jika dikosongkan
        ]);

        return redirect()->route('admin-event.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $eventAdmin = Auth::guard('event_admin')->user();

        // Pastikan hanya bisa mengedit kategori dari event miliknya
        $category = Category::where('event_id', $eventAdmin->event_id)->findOrFail($id);

        return view('admin-event.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $eventAdmin = Auth::guard('event_admin')->user();
        $category = Category::where('event_id', $eventAdmin->event_id)->findOrFail($id);

        $category->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin-event.categories.index')->with('success', 'Data kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $eventAdmin = Auth::guard('event_admin')->user();
        $category = Category::where('event_id', $eventAdmin->event_id)->findOrFail($id);

        // Keamanan: Cek apakah di kategori ini masih ada kandidat/tim?
        $hasTeams = \App\Models\Team::where('category_id', $category->id)->exists();

        if ($hasTeams) {
            return redirect()->route('admin-event.categories.index')
                ->with('error', 'Gagal! Kategori tidak bisa dihapus karena masih ada kandidat/peserta di dalamnya. Pindahkan atau hapus kandidat terlebih dahulu.');
        }

        $category->delete();

        return redirect()->route('admin-event.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
