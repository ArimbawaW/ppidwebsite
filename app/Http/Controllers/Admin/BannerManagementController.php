<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSlider;
use Illuminate\Http\Request;

class BannerManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = BannerSlider::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.banner-slider.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'gambar.required' => 'Gambar banner wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'urutan.required' => 'Urutan tampil wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);

        $data = $request->only(['judul', 'urutan']);
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/banners'), $filename);
            $data['gambar'] = 'images/banners/' . $filename;
        }

        BannerSlider::create($data);

        return redirect()->route('admin.banner-slider.index')
            ->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerSlider $bannerSlider)
    {
        return view('admin.banner-slider.edit', compact('bannerSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerSlider $bannerSlider)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'urutan.required' => 'Urutan tampil wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);

        $data = $request->only(['judul', 'urutan']);
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($bannerSlider->gambar && file_exists(public_path($bannerSlider->gambar))) {
                unlink(public_path($bannerSlider->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/banners'), $filename);
            $data['gambar'] = 'images/banners/' . $filename;
        }

        $bannerSlider->update($data);

        return redirect()->route('admin.banner-slider.index')
            ->with('success', 'Banner berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerSlider $bannerSlider)
    {
        // Hapus file gambar
        if ($bannerSlider->gambar && file_exists(public_path($bannerSlider->gambar))) {
            unlink(public_path($bannerSlider->gambar));
        }

        $bannerSlider->delete();

        return redirect()->route('admin.banner-slider.index')
            ->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Toggle status aktif banner
     */
    public function toggleStatus(BannerSlider $bannerSlider)
    {
        $bannerSlider->update([
            'is_active' => !$bannerSlider->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $bannerSlider->is_active
        ]);
    }
}