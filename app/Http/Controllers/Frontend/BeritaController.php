<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // ================================
    // AUTO FORMAT PARAGRAF
    // ================================
    private function formatKonten($konten)
    {
        // Hilangkan spasi/tab berlebih di awal & akhir
        $konten = trim($konten);

        // Normalize line breaks berlipat-lipat → menjadi PARAGRAF yang sah
        $paragraphs = preg_split('/\n\s*\n+/', $konten);

        $formatted = '';

        foreach ($paragraphs as $p) {
            $p = trim($p);                     // bersihkan
            if ($p === '') continue;           // skip paragraf kosong

            // Rapikan spasi berlebihan (double space → single)
            $p = preg_replace('/\s+/', ' ', $p);

            // Bungkus menjadi <p>...</p>
            $formatted .= "<p>$p</p>\n";
        }

        return $formatted;
    }

    // ================================
    // HALAMAN LIST BERITA
    // ================================
    public function index(Request $request)
    {
        $query = Berita::where('is_published', true);

        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }

        $berita = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('frontend.berita.index', compact('berita'));
    }

    // ================================
    // HALAMAN DETAIL BERITA
    // ================================
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views - Tambahkan langsung
        $berita->increment('views');

        // Format konten otomatis
        $berita->konten = $this->formatKonten($berita->konten);

        // Ambil berita terbaru lain - HANYA 3 BERITA
        $beritaTerbaru = Berita::where('is_published', true)
            ->where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)  // ← UBAH DARI 5 MENJADI 3
            ->get();

        return view('frontend.berita.show', compact('berita', 'beritaTerbaru'));
    }
}