<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StandarLayanan;

class StandarLayananController extends Controller
{
    public function show($slug)
    {
        $layanan = StandarLayanan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        // Ambil semua layanan aktif untuk dropdown
        $allLayanan = StandarLayanan::where('is_active', true)
            ->orderBy('urutan')
            ->get();
        
        return view('frontend.standar-layanan.show', compact('layanan', 'allLayanan'));
    }
}