<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Illuminate\Http\Request;


class AgendaKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $agenda = AgendaKegiatan::aktif()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('lokasi', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(9)
            ->withQueryString(); // agar q tidak hilang saat paginate

        return view('frontend.agenda-kegiatan.index', compact('agenda', 'q'));
    }
}
