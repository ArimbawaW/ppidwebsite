<?php
// app/Http/Controllers/Frontend/KeberatanController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;

class KeberatanController extends Controller
{
    public function index()
    {
        return view('frontend.keberatan.index');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nomor_registrasi_permohonan' => 'required|string|max:255',
            'nama_pemohon'                => 'required|string|max:255',
            'alamat'                      => 'required|string',
            'nomor_kontak'                => 'required|string|max:20',
            'pekerjaan'                   => 'required|string|max:255',
            'kartu_identitas'             => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'informasi_diminta'           => 'required|string',
            'tujuan_penggunaan'           => 'required|string',
            'alasan_keberatan'            => 'required|in:penolakan_pasal_17,tidak_disediakan_berkala,tidak_ditanggapi,tidak_sesuai_permintaan,tidak_dipenuhi,biaya_tidak_wajar,melebihi_jangka_waktu',
            'uraian_keberatan'            => 'required|string',
        ]);

        // Validasi Nomor Registrasi Permohonan
        $permohonan = Permohonan::where('nomor_registrasi', $validated['nomor_registrasi_permohonan'])->first();
        
        if (!$permohonan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor registrasi permohonan tidak ditemukan. Silakan periksa kembali.');
        }

        // Generate Nomor Registrasi Keberatan
        $nomorRegistrasi = Keberatan::generateNomorRegistrasi();

        // Upload Kartu Identitas
        $kartuIdentitasPath = $request->file('kartu_identitas')->store('keberatan/identitas', 'public');

        // Simpan ke Database
        $keberatan = Keberatan::create([
            'nomor_registrasi'             => $nomorRegistrasi,
            'nomor_registrasi_permohonan'  => $validated['nomor_registrasi_permohonan'],
            'permohonan_id'                => $permohonan->id,
            'nama_pemohon'                 => $validated['nama_pemohon'],
            'alamat'                       => $validated['alamat'],
            'nomor_kontak'                 => $validated['nomor_kontak'],
            'pekerjaan'                    => $validated['pekerjaan'],
            'kartu_identitas_path'         => $kartuIdentitasPath,
            'informasi_diminta'            => $validated['informasi_diminta'],
            'tujuan_penggunaan'            => $validated['tujuan_penggunaan'],
            'alasan_keberatan'             => $validated['alasan_keberatan'],
            'uraian_keberatan'             => $validated['uraian_keberatan'],
            'status'                       => 'pending',
        ]);

        $mailer = app(GraphMailService::class);
        $content =
            "Keberatan baru diterima:\n\n" .
            "Nomor Registrasi Keberatan : {$keberatan->nomor_registrasi}\n" .
            "Nomor Registrasi Permohonan : {$keberatan->nomor_registrasi_permohonan}\n" .
            "Nama Pemohon                : {$keberatan->nama_pemohon}\n" .
            "Alasan Keberatan            : {$keberatan->alasan_keberatan_label}";

        $mailer->send(config('mail.from.address'), 'Keberatan Baru - PPID', $content);

        return redirect()
            ->route('keberatan.index')
            ->with('success', 'Keberatan berhasil dikirim! Nomor Registrasi: ' . $nomorRegistrasi);
    }

    public function cek()
    {
        return view('frontend.keberatan.cek');
    }

    public function cekProses(Request $request)
    {
        $request->validate([
            'nomor_registrasi' => 'required|string'
        ]);

        $keberatan = Keberatan::where('nomor_registrasi', $request->nomor_registrasi)->first();

        if (!$keberatan) {
            return back()->with('error', 'Nomor registrasi tidak ditemukan.');
        }

        return view('frontend.keberatan.hasil', compact('keberatan'));
    }
}