<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;

class RegulasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Regulasi::where('is_active', true);

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_terbit', $request->tahun);
        }

        // Search berdasarkan judul, nomor, atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nomor', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $regulasi = $query->orderBy('tanggal_terbit', 'desc')
                         ->paginate(12)
                         ->withQueryString(); // Preserve query parameters in pagination

        // Ambil daftar kategori untuk filter
        $kategoris = Regulasi::where('is_active', true)
                            ->distinct()
                            ->pluck('kategori');

        // Ambil daftar tahun untuk filter
        $tahuns = Regulasi::where('is_active', true)
                         ->whereNotNull('tanggal_terbit')
                         ->selectRaw('YEAR(tanggal_terbit) as tahun')
                         ->distinct()
                         ->orderBy('tahun', 'desc')
                         ->pluck('tahun');

        return view('frontend.regulasi.index', compact('regulasi', 'kategoris', 'tahuns'));
    }
}