<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\InformasiPublik;
use App\Models\AgendaKegiatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Berita terbaru (3 berita) ← UBAH COMMENT
        $beritaTerbaru = Berita::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)  // ← UBAH DARI 6 JADI 3
            ->get();

        // Galeri terbaru (6 item)
        $galeriTerbaru = Galeri::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Informasi publik terbaru (5 item)
        $informasiTerbaru = InformasiPublik::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Agenda kegiatan mendatang (9 agenda)
        $agendaKegiatan = AgendaKegiatan::aktif()
            ->upcoming()
            ->limit(9)
            ->get();

        // Statistik permohonan selesai
        $permohonanSelesai = Permohonan::where('status', 'selesai')->count();

        return view('frontend.home', compact(
            'beritaTerbaru', 
            'galeriTerbaru', 
            'informasiTerbaru', 
            'agendaKegiatan',
            'permohonanSelesai'
        ));
    }
}