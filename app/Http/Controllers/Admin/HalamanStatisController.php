<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use Illuminate\Http\Request;

class HalamanStatisController extends Controller
{
    public function index()
    {
        $halaman = HalamanStatis::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.halaman-statis.index', compact('halaman'));
    }

    public function create()
    {
        return view('admin.halaman-statis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:halaman_statis,slug',
            'judul' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Konten dari dynamic form
        $konten = [];
        if ($request->has('sections')) {
            foreach ($request->sections as $index => $section) {
                $items = [];
                if (isset($request->items[$index])) {
                    foreach ($request->items[$index] as $itemIndex => $itemText) {
                        $items[] = [
                            'text' => $itemText,
                            'file_url' => $request->file_urls[$index][$itemIndex] ?? null,
                        ];
                    }
                }
                
                $konten[] = [
                    'section' => $section,
                    'items' => $items,
                ];
            }
        }

        HalamanStatis::create([
            'slug' => $validated['slug'],
            'judul' => $validated['judul'],
            'konten' => $konten,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil ditambahkan');
    }

    public function edit(HalamanStatis $halamanStatis)
    {
        return view('admin.halaman-statis.edit', compact('halamanStatis'));
    }

    public function update(Request $request, HalamanStatis $halamanStatis)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:halaman_statis,slug,' . $halamanStatis->id,
            'judul' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Konten dari dynamic form
        $konten = [];
        if ($request->has('sections')) {
            foreach ($request->sections as $index => $section) {
                $items = [];
                if (isset($request->items[$index])) {
                    foreach ($request->items[$index] as $itemIndex => $itemText) {
                        $items[] = [
                            'text' => $itemText,
                            'file_url' => $request->file_urls[$index][$itemIndex] ?? null,
                        ];
                    }
                }
                
                $konten[] = [
                    'section' => $section,
                    'items' => $items,
                ];
            }
        }

        $halamanStatis->update([
            'slug' => $validated['slug'],
            'judul' => $validated['judul'],
            'konten' => $konten,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil diupdate');
    }

    public function destroy(HalamanStatis $halamanStatis)
    {
        $halamanStatis->delete();

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil dihapus');
    }
}