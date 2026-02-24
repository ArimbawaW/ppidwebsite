<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * ================================
     * AUTO FORMAT PARAGRAF
     * ================================
     * Mengubah teks mentah menjadi tag HTML <p> 
     * agar tampilan di halaman detail tetap rapi.
     */
    private function formatKonten($konten)
    {
        // Hilangkan spasi/tab berlebih di awal & akhir
        $konten = trim($konten);

        // Jika konten sudah mengandung tag HTML (dari CKEditor), kembalikan langsung
        if (strip_tags($konten) !== $konten) {
            return $konten;
        }

        // Normalize line breaks berlipat-lipat menjadi array paragraf
        $paragraphs = preg_split('/\n\s*\n+/', $konten);

        $formatted = '';

        foreach ($paragraphs as $p) {
            $p = trim($p);
            if ($p === '') continue; // skip paragraf kosong

            // Rapikan spasi berlebihan di dalam kalimat
            $p = preg_replace('/\s+/', ' ', $p);

            // Bungkus menjadi <p>...</p>
            $formatted .= "<p>$p</p>\n";
        }

        return $formatted;
    }

    /**
     * ================================
     * HALAMAN LIST BERITA
     * ================================
     */
    public function index(Request $request)
    {
        // Menggunakan scopePublished() dari Model agar berita 
        // yang dijadwalkan (future date) tidak muncul prematur.
        $query = Berita::published();

        // Filter Berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Berdasarkan Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('konten', 'like', '%' . $searchTerm . '%');
            });
        }

        // Urutkan berdasarkan tanggal publikasi terbaru
        $berita = $query->orderBy('published_at', 'desc')->paginate(9);

        return view('frontend.berita.index', compact('berita'));
    }

    /**
     * ================================
     * HALAMAN DETAIL BERITA
     * ================================
     */
    public function show($slug)
    {
        // Pastikan berita yang dipanggil sudah Published dan tanggalnya sudah lewat
        $berita = Berita::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Tambah jumlah view secara otomatis
        $berita->increment('views');

        // Format konten (hanya jika konten tidak berisi tag HTML dari editor)
        $berita->konten = $this->formatKonten($berita->konten);

        // Ambil berita terbaru lain sebagai rekomendasi di Sidebar (Limit 3)
        $beritaTerbaru = Berita::published()
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('frontend.berita.show', compact('berita', 'beritaTerbaru'));
    }
}