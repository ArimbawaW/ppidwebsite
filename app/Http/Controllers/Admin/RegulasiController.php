<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegulasiController extends Controller
{
    public function index(Request $request)
{
    $query = Regulasi::query();

    // Filter pencarian judul / nomor
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->search . '%')
              ->orWhere('nomor', 'like', '%' . $request->search . '%');
        });
    }

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('is_active', $request->status === 'aktif');
    }

    $regulasi = $query
        ->orderBy('tanggal_terbit', 'desc')
        ->paginate(15)
        ->withQueryString();

    return view('admin.regulasi.index', compact('regulasi'));
}

    public function create()
    {
        return view('admin.regulasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'nomor' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
           'kategori' => 'required|in:Undang-Undang,Peraturan Pemerintah,Peraturan Presiden,Peraturan Menteri,Peraturan Daerah,Surat Edaran,Keputusan,Lainnya',
            'tanggal_terbit' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('regulasi', 'public');
        }

        // Convert status string ke boolean
        $validated['is_active'] = ($request->status === 'aktif');

        // Hapus field 'status' karena tidak ada di database
        unset($validated['status']);

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
        'judul' => 'required|string',
        'nomor' => 'nullable|string|max:100',
        'deskripsi' => 'nullable|string',
        'kategori' => 'required|in:Undang-Undang,Peraturan Pemerintah,Peraturan Presiden,Peraturan Menteri,Peraturan Daerah,Surat Edaran,Keputusan,Lainnya',
        'tanggal_terbit' => 'nullable|date', // ← Ini yang kurang!
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        'status' => 'required|in:aktif,tidak_aktif',
    ]);

    if ($request->hasFile('file')) {
        if ($regulasi->file) {
            Storage::disk('public')->delete($regulasi->file);
        }
        $validated['file'] = $request->file('file')->store('regulasi', 'public');
    }

    // Convert status string ke boolean
    $validated['is_active'] = ($request->status === 'aktif');

    // Hapus field 'status' karena tidak ada di database
    unset($validated['status']);

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