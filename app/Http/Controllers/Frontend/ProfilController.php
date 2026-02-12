<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class ProfilController extends Controller
{
    public function index()
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();
        return view('frontend.profil.index', compact('beritaTerbaru'));
    }

    public function strukturOrganisasi()
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();
        return view('frontend.profil.struktur-organisasi', compact('beritaTerbaru'));
    }

    public function dasarHukum()
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();
        return view('frontend.profil.dasar-hukum', compact('beritaTerbaru'));
    }

    public function tugasFungsi()
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();
        return view('frontend.profil.tugas-fungsi', compact('beritaTerbaru'));
    }

    public function visiMisi()
    {
        $beritaTerbaru = Berita::latest()->take(3)->get();
        return view('frontend.profil.visi-misi', compact('beritaTerbaru'));
    }
}