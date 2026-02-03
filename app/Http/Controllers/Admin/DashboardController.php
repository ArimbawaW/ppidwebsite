<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\InformasiPublik;
use App\Models\Keberatan;
use App\Models\Kontak;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [

            // =========================
            // PERMOHONAN
            // =========================
            // Pending permohonan = perlu_verifikasi
            'permohonan_pending' => Permohonan::where('status', 'perlu_verifikasi')->count(),

            // =========================
            // KEBERATAN
            // =========================
            // Pending keberatan = pending
            'keberatan_pending' => Keberatan::where('status', 'pending')->count(),

            // =========================
            // LAINNYA
            // =========================
            'kontak_unread' => Kontak::where('status', 'unread')->count(),
            'berita_total' => Berita::count(),
            'informasi_total' => InformasiPublik::count(),
            'galeri_total' => Galeri::count(),
        ];

        // =========================
        // DATA TERBARU
        // =========================
        $permohonanTerbaru = Permohonan::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $keberatanTerbaru = Keberatan::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'permohonanTerbaru',
            'keberatanTerbaru'
        ));
    }
}
