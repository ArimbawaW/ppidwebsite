<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $galeri = Galeri::query();
                return DataTables::of($galeri)
                    ->addColumn('action', function ($item) {
                        return view('admin.galeri.action', compact('item'))->render();
                    })
                    ->addColumn('gambar_preview', function ($item) {
                        return '<img src="' . asset('storage/' . $item->gambar) . '" alt="' . $item->judul . '" style="max-width: 100px; height: auto;">';
                    })
                    ->editColumn('is_active', function ($item) {
                        return $item->is_active 
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-secondary">Tidak Aktif</span>';
                    })
                    ->rawColumns(['action', 'gambar_preview', 'is_active'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Fallback: Simple pagination
        $galeri = Galeri::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            ]);

            $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
            $validated['is_active'] = $request->has('is_active') ? true : false;

            Galeri::create($validated);

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error creating galeri: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan galeri: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        try {
            $galeri = Galeri::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                if ($galeri->gambar) {
                    Storage::disk('public')->delete($galeri->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
            }

            $validated['is_active'] = $request->has('is_active') ? true : false;

            $galeri->update($validated);

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating galeri: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui galeri: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}

