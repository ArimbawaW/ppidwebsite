<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqKategori = Faq::where('is_active', true)
            ->select('kategori')
            ->distinct()
            ->get();
        
        $faqs = Faq::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('kategori');
        
        return view('frontend.faq.index', compact('faqs', 'faqKategori'));
    }
}