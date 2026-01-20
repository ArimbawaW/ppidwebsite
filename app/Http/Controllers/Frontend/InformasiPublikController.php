<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    /**
     * Halaman utama Informasi Publik
     * Hanya menampilkan 3 button kategori yang link ke halaman statis
     */
    public function index(Request $request)
    {
        // View sudah tidak memerlukan data $informasi
        // Karena hanya menampilkan 3 button link
        return view('frontend.informasi-publik.index');
    }

    /**
     * Detail informasi publik (jika masih diperlukan)
     */
    public function show($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        return view('frontend.informasi-publik.show', compact('informasi'));
    }

    /**
     * Download file informasi publik
     */
    public function download($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        
        if ($informasi->file_path && file_exists(storage_path('app/public/' . $informasi->file_path))) {
            $informasi->incrementDownload();
            return response()->download(storage_path('app/public/' . $informasi->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}