<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.galeri.index', compact('galeri'));
    }
}

