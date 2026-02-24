<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StandarLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StandarLayananController extends Controller
{
    public function index()
    {
        $standarLayanan = StandarLayanan::orderBy('urutan')->paginate(15);
        return view('admin.standar-layanan.index', compact('standarLayanan'));
    }

    public function create()
    {
        return view('admin.standar-layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan'  => 'required|string|max:255',
            'slug'          => 'nullable|string|unique:standar_layanan,slug',
            'gambar'        => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'gambar_2'      => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // BARU
            'deskripsi'     => 'nullable|string',
            'deskripsi_2'   => 'nullable|string', // BARU
            'konten'        => 'required|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'urutan'        => 'nullable|integer',
            'is_active'     => 'nullable|boolean',
        ]);

        // Auto-generate slug jika kosong
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['nama_layanan']);
            $slug = $baseSlug;
            $i = 1;
            while (StandarLayanan::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $validated['slug'] = $slug;
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('standar-layanan', 'public');
        }

        // Upload gambar_2 (BARU)
        if ($request->hasFile('gambar_2')) {
            $validated['gambar_2'] = $request->file('gambar_2')->store('standar-layanan', 'public');
        }

        // Upload file
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('standar-layanan', 'public');
        }

        // Default urutan bila null
        if (!isset($validated['urutan'])) {
            $validated['urutan'] = (int) (StandarLayanan::max('urutan') ?? 0) + 1;
        }

        // Boolean publish
        $validated['is_active'] = $request->boolean('is_active');

        StandarLayanan::create($validated);

        return redirect()
            ->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil ditambahkan');
    }

    public function edit(StandarLayanan $standarLayanan)
    {
        return view('admin.standar-layanan.edit', compact('standarLayanan'));
    }

    public function update(Request $request, StandarLayanan $standarLayanan)
    {
        $validated = $request->validate([
            'nama_layanan'  => 'required|string|max:255',
            'slug'          => 'nullable|string|unique:standar_layanan,slug,' . $standarLayanan->id,
            'gambar'        => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'gambar_2'      => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // BARU
            'deskripsi'     => 'nullable|string',
            'deskripsi_2'   => 'nullable|string', // BARU
            'konten'        => 'required|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'urutan'        => 'nullable|integer',
            'is_active'     => 'nullable|boolean',
        ]);

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            if ($standarLayanan->gambar) {
                Storage::disk('public')->delete($standarLayanan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('standar-layanan', 'public');
        }

        // Upload gambar_2 baru (BARU)
        if ($request->hasFile('gambar_2')) {
            if ($standarLayanan->gambar_2) {
                Storage::disk('public')->delete($standarLayanan->gambar_2);
            }
            $validated['gambar_2'] = $request->file('gambar_2')->store('standar-layanan', 'public');
        }

        // Upload file baru
        if ($request->hasFile('file')) {
            if ($standarLayanan->file) {
                Storage::disk('public')->delete($standarLayanan->file);
            }
            $validated['file'] = $request->file('file')->store('standar-layanan', 'public');
        }

        // Default urutan bila null (biarkan nilai lama jika tetap null)
        if (!isset($validated['urutan']) && $standarLayanan->urutan === null) {
            $validated['urutan'] = (int) (StandarLayanan::max('urutan') ?? 0) + 1;
        }

        // Boolean publish
        $validated['is_active'] = $request->boolean('is_active');

        $standarLayanan->update($validated);

        return redirect()
            ->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil diperbarui');
    }

    public function destroy(StandarLayanan $standarLayanan)
    {
        if ($standarLayanan->gambar) {
            Storage::disk('public')->delete($standarLayanan->gambar);
        }

        if ($standarLayanan->gambar_2) { // BARU
            Storage::disk('public')->delete($standarLayanan->gambar_2);
        }

        if ($standarLayanan->file) {
            Storage::disk('public')->delete($standarLayanan->file);
        }

        $standarLayanan->delete();

        return redirect()
            ->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil dihapus');
    }
}