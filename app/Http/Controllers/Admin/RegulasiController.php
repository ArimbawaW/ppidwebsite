<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasi = Regulasi::orderBy('tanggal_terbit', 'desc')->paginate(15);
        return view('admin.regulasi.index', compact('regulasi'));
    }

    public function create()
    {
        return view('admin.regulasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:Undang-Undang,Peraturan Pemerintah,Peraturan Menteri,Peraturan Daerah,Surat Edaran,Keputusan,Lainnya',
            'tanggal_terbit' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('regulasi', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Regulasi::create($validated);

        return redirect()->route('admin.regulasi.index')
            ->with('success', 'Regulasi berhasil ditambahkan');
    }

    public function edit(Regulasi $regulasi)
    {
        return view('admin.regulasi.edit', compact('regulasi'));
    }

    public function update(Request $request, Regulasi $regulasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:Undang-Undang,Peraturan Pemerintah,Peraturan Menteri,Peraturan Daerah,Surat Edaran,Keputusan,Lainnya',
            'tanggal_terbit' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($regulasi->file) {
                Storage::disk('public')->delete($regulasi->file);
            }
            $validated['file'] = $request->file('file')->store('regulasi', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $regulasi->update($validated);

        return redirect()->route('admin.regulasi.index')
            ->with('success', 'Regulasi berhasil diperbarui');
    }

    public function destroy(Regulasi $regulasi)
    {
        if ($regulasi->file) {
            Storage::disk('public')->delete($regulasi->file);
        }

        $regulasi->delete();

        return redirect()->route('admin.regulasi.index')
            ->with('success', 'Regulasi berhasil dihapus');
    }
}