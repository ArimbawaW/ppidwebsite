<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class InformasiPublikController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $informasi = InformasiPublik::query();
                return DataTables::of($informasi)
                    ->addColumn('action', function ($item) {
                        return view('admin.informasi-publik.action', compact('item'))->render();
                    })
                    ->editColumn('kategori', function ($item) {
                        return $item->kategori_label;
                    })
                    ->editColumn('is_active', function ($item) {
                        return $item->is_active 
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-secondary">Tidak Aktif</span>';
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Fallback: Simple pagination
        $informasi = InformasiPublik::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.informasi-publik.index', compact('informasi'));
    }

    public function create()
    {
        return view('admin.informasi-publik.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|in:informasi_berkala,informasi_setiap_saat,informasi_serta_merta,informasi_dikecualikan',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'link_download' => 'nullable|url',
            ]);

            if ($request->hasFile('file')) {
                $validated['file_path'] = $request->file('file')->store('informasi-publik', 'public');
            }

            $validated['is_active'] = $request->has('is_active') ? true : false;

            InformasiPublik::create($validated);

            return redirect()->route('admin.informasi-publik.index')
                ->with('success', 'Informasi publik berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error creating informasi publik: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan informasi publik: ' . $e->getMessage());
        }
    }

    public function edit($informasi_publik)
    {
        $informasi = InformasiPublik::findOrFail($informasi_publik);
        return view('admin.informasi-publik.edit', compact('informasi'));
    }

    public function update(Request $request, $informasi_publik)
    {
        try {
            $informasi = InformasiPublik::findOrFail($informasi_publik);

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|in:informasi_berkala,informasi_setiap_saat,informasi_serta_merta,informasi_dikecualikan',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'link_download' => 'nullable|url',
            ]);

            if ($request->hasFile('file')) {
                if ($informasi->file_path) {
                    Storage::disk('public')->delete($informasi->file_path);
                }
                $validated['file_path'] = $request->file('file')->store('informasi-publik', 'public');
            }

            $validated['is_active'] = $request->has('is_active') ? true : false;

            $informasi->update($validated);

            return redirect()->route('admin.informasi-publik.index')
                ->with('success', 'Informasi publik berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating informasi publik: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui informasi publik: ' . $e->getMessage());
        }
    }

    public function destroy($informasi_publik)
    {
        $informasi = InformasiPublik::findOrFail($informasi_publik);
        
        if ($informasi->file_path) {
            Storage::disk('public')->delete($informasi->file_path);
        }

        $informasi->delete();

        return redirect()->route('admin.informasi-publik.index')
            ->with('success', 'Informasi publik berhasil dihapus.');
    }
}

