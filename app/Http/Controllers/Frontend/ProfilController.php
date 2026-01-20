<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        return view('frontend.profil.index');
    }

    public function strukturOrganisasi()
    {
        return view('frontend.profil.struktur-organisasi');
    }

    public function dasarHukum()
    {
        return view('frontend.profil.dasar-hukum');
    }

    public function tugasFungsi()
    {
        return view('frontend.profil.tugas-fungsi');
    }

    public function visiMisi()
    {
        return view('frontend.profil.visi-misi');
    }
}

