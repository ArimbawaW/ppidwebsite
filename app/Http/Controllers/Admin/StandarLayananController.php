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
            'nama_layanan' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:standar_layanan,slug',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'konten' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'urutan' => 'nullable|integer',
        ]);

        // Auto-generate slug jika kosong
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_layanan']);
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('standar-layanan', 'public');
        }

        // Upload file
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('standar-layanan', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        StandarLayanan::create($validated);

        return redirect()->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil ditambahkan');
    }

    public function edit(StandarLayanan $standarLayanan)
    {
        return view('admin.standar-layanan.edit', compact('standarLayanan'));
    }

    public function update(Request $request, StandarLayanan $standarLayanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:standar_layanan,slug,' . $standarLayanan->id,
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'konten' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'urutan' => 'nullable|integer',
        ]);

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            if ($standarLayanan->gambar) {
                Storage::disk('public')->delete($standarLayanan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('standar-layanan', 'public');
        }

        // Upload file baru
        if ($request->hasFile('file')) {
            if ($standarLayanan->file) {
                Storage::disk('public')->delete($standarLayanan->file);
            }
            $validated['file'] = $request->file('file')->store('standar-layanan', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $standarLayanan->update($validated);

        return redirect()->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil diperbarui');
    }

    public function destroy(StandarLayanan $standarLayanan)
    {
        if ($standarLayanan->gambar) {
            Storage::disk('public')->delete($standarLayanan->gambar);
        }
        
        if ($standarLayanan->file) {
            Storage::disk('public')->delete($standarLayanan->file);
        }

        $standarLayanan->delete();

        return redirect()->route('admin.standar-layanan.index')
            ->with('success', 'Halaman Standar Layanan berhasil dihapus');
    }
}