<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $berita = Berita::with('user');
                return DataTables::of($berita)
                    ->addColumn('action', function ($item) {
                        return view('admin.berita.action', compact('item'))->render();
                    })
                    ->editColumn('is_published', function ($item) {
                        return $item->is_published 
                            ? '<span class="badge bg-success">Published</span>'
                            : '<span class="badge bg-secondary">Draft</span>';
                    })
                    ->editColumn('kategori', function ($item) {
                        return ucfirst($item->kategori);
                    })
                    ->rawColumns(['action', 'is_published'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Fallback: Simple pagination jika DataTables tidak bekerja
        $berita = Berita::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'konten' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'kategori' => 'required|in:berita,artikel,pengumuman',
            ]);

            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
            }

            $validated['user_id'] = auth()->id();
            $validated['is_published'] = $request->has('is_published') ? true : false;

            Berita::create($validated);

            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error creating berita: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan berita: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'konten' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'kategori' => 'required|in:berita,artikel,pengumuman',
            ]);

            if ($request->hasFile('gambar')) {
                if ($berita->gambar) {
                    Storage::disk('public')->delete($berita->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
            }

            $validated['is_published'] = $request->has('is_published') ? true : false;

            $berita->update($validated);

            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating berita: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

