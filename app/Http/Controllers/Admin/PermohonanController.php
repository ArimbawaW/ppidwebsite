<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.permohonan.index', compact('permohonan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permohonan $permohonan)
    {
        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $permohonan)
    {
        return view('admin.permohonan.edit', compact('permohonan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:1000'
        ]);

        $permohonan->catatan_admin = $request->catatan_admin;
        $permohonan->save();

        return redirect()->route('admin.permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }

    /**
     * Update status permohonan.
     */
    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $permohonan->status;
        $oldStatusLabel = $permohonan->status_label;
        $permohonan->status = $request->status;
        $permohonan->catatan_admin = $request->catatan_admin;
        
        if ($request->status === 'disetujui' || $request->status === 'ditolak') {
            $permohonan->tanggal_selesai = now();
        }
        
        $permohonan->save();

        // Kirim email pemberitahuan perubahan status ke pemohon
        if ($permohonan->email) {
            $mailer = app(GraphMailService::class);
            $content =
                "Halo {$permohonan->nama},\n\n" .
                "Status permohonan informasi Anda telah berubah.\n" .
                "Nomor Registrasi: {$permohonan->nomor_registrasi}\n" .
                "Status sebelumnya: {$oldStatusLabel}\n" .
                "Status sekarang: {$permohonan->status_label}\n" .
                ($permohonan->catatan_admin ? "Catatan: {$permohonan->catatan_admin}\n" : '') .
                "\nAnda dapat mengecek status melalui halaman cek status permohonan.";

            if (!$mailer->send($permohonan->email, 'Pembaruan Status Permohonan Informasi - PPID', $content)) {
                Log::error('Gagal mengirim email status permohonan (Graph).', [
                    'permohonan_id' => $permohonan->id,
                    'email' => $permohonan->email,
                ]);
            }
        }

        return redirect()->route('admin.permohonan.show', $permohonan)
            ->with('success', 'Status permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        // Hapus file-file yang ada
        $files = [
            $permohonan->file_identitas_path,
            $permohonan->file_surat_kuasa_path,
            $permohonan->file_ktp_pemberi_kuasa_path,
            $permohonan->file_akta_ahu_path,
            $permohonan->file_ad_art_path,
        ];

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }
        
        $permohonan->delete();

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Permohonan berhasil dihapus.');
    }

    /**
     * Download file dokumen
     */
    public function downloadFile(Permohonan $permohonan, $type)
    {
        $filePath = match($type) {
            'identitas' => $permohonan->file_identitas_path,
            'surat_kuasa' => $permohonan->file_surat_kuasa_path,
            'ktp_kuasa' => $permohonan->file_ktp_pemberi_kuasa_path,
            'akta_ahu' => $permohonan->file_akta_ahu_path,
            'ad_art' => $permohonan->file_ad_art_path,
            default => null,
        };

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Display statistics.
     */
    public function statistics()
    {
        $stats = [
            'total' => Permohonan::count(),
            'pending' => Permohonan::where('status', 'pending')->count(),
            'diproses' => Permohonan::where('status', 'diproses')->count(),
            'disetujui' => Permohonan::where('status', 'disetujui')->count(),
            'ditolak' => Permohonan::where('status', 'ditolak')->count(),
        ];

        $perKategori = Permohonan::selectRaw('kategori_pemohon, COUNT(*) as total')
            ->groupBy('kategori_pemohon')
            ->get();

        return view('admin.permohonan.statistics', compact('stats', 'perKategori'));
    }
}