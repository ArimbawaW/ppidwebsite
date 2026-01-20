<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasi = Regulasi::where('is_active', true)
            ->orderBy('tanggal_terbit', 'desc')
            ->paginate(12);
        
        return view('frontend.regulasi.index', compact('regulasi'));
    }
}