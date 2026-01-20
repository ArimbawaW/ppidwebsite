<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;

class HalamanStatisController extends Controller
{
    public function show($slug)
    {
        $halaman = HalamanStatis::where('slug', $slug)
                                ->where('is_active', true)
                                ->firstOrFail();
        
        return view('frontend.halaman-statis.show', compact('halaman'));
    }
}