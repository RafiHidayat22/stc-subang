<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Public gallery page.
     * Semua foto aktif dikirim sekaligus ke view —
     * filter, search, dan paginasi ditangani oleh JS di client-side.
     * paginate(999) agar ->total() tersedia untuk stat counter di hero.
     */
    public function index()
    {
        $galleries = Gallery::active()
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->paginate(999);

        // Kategori unik untuk filter pills
        $categories = Gallery::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('gallery.index', compact('galleries', 'categories'));
    }

    // ── Admin CRUD ────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $galleries = Gallery::orderBy('order')->orderByDesc('created_at')->paginate(20);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption'   => 'required|string|max:255',
            'image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'category'  => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order'     => 'integer|min:0',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'caption'   => $validated['caption'],
            'image'     => $path,
            'category'  => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'order'     => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto gallery berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'caption'   => 'required|string|max:255',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'category'  => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order'     => 'integer|min:0',
        ]);

        $data = [
            'caption'   => $validated['caption'],
            'category'  => $validated['category'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'order'     => $validated['order'] ?? $gallery->order,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data gallery berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto gallery berhasil dihapus.');
    }

    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => ! $gallery->is_active]);
        return response()->json(['success' => true, 'is_active' => $gallery->is_active]);
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)->update(['order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}