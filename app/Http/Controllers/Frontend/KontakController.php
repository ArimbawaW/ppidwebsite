<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Services\GraphMailService;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('frontend.kontak.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        $kontak = Kontak::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
            'status' => 'unread',
        ]);

        // Kirim email notifikasi ke admin
        $mailer = app(GraphMailService::class);
        $content = "Pesan kontak baru telah diterima.\n\nNama: {$kontak->nama}\nEmail: {$kontak->email}\nSubjek: {$kontak->subjek}\n\nPesan:\n{$kontak->pesan}";
        $mailer->send(config('mail.from.address'), 'Pesan Kontak Baru: ' . $kontak->subjek, $content);

        return redirect()->route('kontak.index')
            ->with('success', 'Pesan berhasil dikirim. Kami akan merespons segera.');
    }
}

