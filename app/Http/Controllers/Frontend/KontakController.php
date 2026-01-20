<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        try {
            Mail::raw("Pesan kontak baru telah diterima.\n\nNama: {$kontak->nama}\nEmail: {$kontak->email}\nSubjek: {$kontak->subjek}\n\nPesan:\n{$kontak->pesan}", function ($message) use ($kontak) {
                $message->to(config('mail.from.address'))
                    ->subject('Pesan Kontak Baru: ' . $kontak->subjek);
            });
        } catch (\Exception $e) {
            // Log error jika email gagal
        }

        return redirect()->route('kontak.index')
            ->with('success', 'Pesan berhasil dikirim. Kami akan merespons segera.');
    }
}

