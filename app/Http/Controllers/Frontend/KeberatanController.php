<?php
// app/Http/Controllers/Frontend/KeberatanController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KeberatanController extends Controller
{
    public function index()
    {
        return view('frontend.keberatan.index');
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nomor_registrasi_permohonan' => 'required|string|max:255',
            'nama_pemohon'                => 'required|string|max:255',
            'alamat'                      => 'required|string',
            'nomor_kontak'                => 'required|string|max:20',
            'email'                       => 'required|email|max:255',
            'pekerjaan'                   => 'required|string|max:255',
            'kartu_identitas'             => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'informasi_diminta'           => 'required|string',
            'tujuan_penggunaan'           => 'required|string',
            'alasan_keberatan'            => 'required|in:penolakan_pasal_17,tidak_disediakan_berkala,tidak_ditanggapi,tidak_sesuai_permintaan,tidak_dipenuhi,biaya_tidak_wajar,melebihi_jangka_waktu',
            'uraian_keberatan'            => 'required|string',
        ]);

        // 2. Validasi Nomor Registrasi Permohonan
        $permohonan = Permohonan::where('nomor_registrasi', $validated['nomor_registrasi_permohonan'])->first();
        
        if (!$permohonan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor registrasi permohonan tidak ditemukan. Silakan periksa kembali.');
        }

        // 3. Validasi Email Harus Sama dengan Permohonan Asal
        if (strtolower(trim($permohonan->email)) !== strtolower(trim($validated['email']))) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email yang Anda masukkan tidak sesuai dengan email yang terdaftar pada permohonan tersebut. Silakan gunakan email yang sama saat mengajukan permohonan.');
        }

        // 4. Cek apakah sudah ada keberatan yang masih aktif
        if ($permohonan->hasActiveKeberatan()) {
            $activeKeberatan = $permohonan->getActiveKeberatan();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda masih memiliki keberatan yang sedang diproses. No. Registrasi: ' . $activeKeberatan->nomor_registrasi . ' (Status: ' . $activeKeberatan->status_label . ').');
        }

        // 5. Proses Data & File
        $nomorRegistrasi = Keberatan::generateNomorRegistrasi();
        $kartuIdentitasPath = $request->file('kartu_identitas')->store('keberatan/identitas', 'public');

        // 6. Simpan ke Database
        $keberatan = Keberatan::create([
            'nomor_registrasi'             => $nomorRegistrasi,
            'nomor_registrasi_permohonan'  => $validated['nomor_registrasi_permohonan'],
            'permohonan_id'                => $permohonan->id,
            'nama_pemohon'                 => $validated['nama_pemohon'],
            'alamat'                       => $validated['alamat'],
            'nomor_kontak'                 => $validated['nomor_kontak'],
            'email'                        => $validated['email'],
            'pekerjaan'                    => $validated['pekerjaan'],
            'kartu_identitas_path'         => $kartuIdentitasPath,
            'informasi_diminta'            => $validated['informasi_diminta'],
            'tujuan_penggunaan'            => $validated['tujuan_penggunaan'],
            'alasan_keberatan'             => $validated['alasan_keberatan'],
            'uraian_keberatan'             => $validated['uraian_keberatan'],
            'status'                       => 'pending',
        ]);

        // 7. Kirim Notifikasi Email
        $mailer = app(GraphMailService::class);
        
        // Notifikasi ke Admin
        $adminContent = "Keberatan baru diterima:\n\n" .
            "Nomor Registrasi Keberatan : {$keberatan->nomor_registrasi}\n" .
            "Nomor Registrasi Permohonan : {$keberatan->nomor_registrasi_permohonan}\n" .
            "Nama Pemohon                : {$keberatan->nama_pemohon}\n" .
            "Email                       : {$keberatan->email}\n" .
            "Alasan Keberatan            : {$keberatan->alasan_keberatan_label}\n" .
            "Status                      : Perlu Diverifikasi";

        if (!$mailer->send(config('mail.from.address'), 'Keberatan Baru - PPID', $adminContent)) {
            Log::error('Email admin keberatan gagal dikirim.');
        }

        // Notifikasi ke Pemohon
        if ($keberatan->email) {
            $pemohonContent = "Halo {$keberatan->nama_pemohon},\n\n" .
                "Keberatan Anda telah kami terima.\n" .
                "Nomor Registrasi Keberatan: {$keberatan->nomor_registrasi}\n" .
                "Nomor Registrasi Permohonan: {$keberatan->nomor_registrasi_permohonan}\n" .
                "Status: Menunggu Verifikasi\n\n" .
                "Simpan nomor registrasi ini untuk mengecek status keberatan Anda secara berkala.";

            if (!$mailer->send($keberatan->email, 'Nomor Registrasi Keberatan - PPID', $pemohonContent)) {
                Log::error('Email ke pemohon keberatan gagal dikirim.', ['email' => $keberatan->email]);
            }
        }

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
        $validated = $request->validate([
            'nomor_registrasi' => 'required|string',
            'email' => 'required|email',
        ], [
            'nomor_registrasi.required' => 'Nomor registrasi keberatan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $keberatan = Keberatan::where('nomor_registrasi', $validated['nomor_registrasi'])->first();

        if (!$keberatan) {
            return back()
                ->withInput()
                ->with('error', 'Nomor registrasi keberatan tidak ditemukan. Silakan periksa kembali.');
        }

        // Validasi email harus sesuai
        if (strtolower(trim($keberatan->email)) !== strtolower(trim($validated['email']))) {
            return back()
                ->withInput()
                ->with('error', 'Email yang Anda masukkan tidak sesuai dengan email yang terdaftar pada keberatan ini.');
        }

        return view('frontend.keberatan.hasil', compact('keberatan'));
    }

    public function submitTanggapan(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggapan_pemohon' => 'required|string|min:10',
            'email' => 'required|email',
        ], [
            'tanggapan_pemohon.required' => 'Tanggapan wajib diisi.',
            'tanggapan_pemohon.min' => 'Tanggapan minimal 10 karakter.',
            'email.required' => 'Email wajib diisi untuk verifikasi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $keberatan = Keberatan::findOrFail($id);

        // Validasi email harus sesuai
        if (strtolower(trim($keberatan->email)) !== strtolower(trim($validated['email']))) {
            return back()
                ->withInput()
                ->with('error', 'Email yang Anda masukkan tidak sesuai. Anda tidak memiliki akses untuk memberikan tanggapan pada keberatan ini.');
        }

        // Update tanggapan pemohon
        $keberatan->tanggapan_pemohon = $validated['tanggapan_pemohon'];
        $keberatan->save();

        // Kirim notifikasi ke admin
        $mailer = app(GraphMailService::class);
        $adminContent =
            "Pemohon telah memberikan tanggapan pada keberatan:\n\n" .
            "Nomor Registrasi Keberatan: {$keberatan->nomor_registrasi}\n" .
            "Nama Pemohon: {$keberatan->nama_pemohon}\n" .
            "Email: {$keberatan->email}\n\n" .
            "Tanggapan Pemohon:\n{$validated['tanggapan_pemohon']}";

        if (!$mailer->send(config('mail.from.address'), 'Tanggapan Baru pada Keberatan - PPID', $adminContent)) {
            Log::error('Email notifikasi tanggapan pemohon gagal dikirim.');
        }

        return redirect()
            ->route('keberatan.cek')
            ->with('success', 'Tanggapan Anda berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }
}