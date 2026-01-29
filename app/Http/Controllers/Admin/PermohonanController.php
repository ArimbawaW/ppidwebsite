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
        $permohonan = Permohonan::orderBy('created_at', 'desc')->get();
        
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
            'catatan_admin' => 'nullable|string|max:1000',
            'kategori_informasi' => 'nullable|in:informasi_berkala,informasi_setiap_saat,informasi_serta_merta,informasi_dikecualikan',
            'jenis_permohonan_informasi' => 'nullable|string|max:100',
            'jenis_permohonan_lainnya' => 'nullable|string|max:500',
            'status_informasi' => 'nullable|in:ya,dibawah_penguasaan,tidak_dibawah_penguasaan,belum_didokumentasikan',
            'bentuk_informasi' => 'nullable|in:softcopy,hardcopy,softcopy_hardcopy',
            'jenis_permintaan' => 'nullable|in:melihat_mengetahui,meminta_salinan,melihat_dan_salinan',
        ]);

        $permohonan->catatan_admin = $request->catatan_admin;
        $permohonan->kategori_informasi = $request->kategori_informasi;
        $permohonan->jenis_permohonan_informasi = $request->jenis_permohonan_informasi;
        $permohonan->jenis_permohonan_lainnya = $request->jenis_permohonan_lainnya;
        $permohonan->status_informasi = $request->status_informasi;
        $permohonan->bentuk_informasi = $request->bentuk_informasi;
        $permohonan->jenis_permintaan = $request->jenis_permintaan;
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
            'status' => 'required|in:perlu_verifikasi,diproses,ditunda,dikabulkan_seluruhnya,dikabulkan_sebagian,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
            'kategori_informasi' => 'nullable|in:informasi_berkala,informasi_setiap_saat,informasi_serta_merta,informasi_dikecualikan',
            'jenis_permohonan_informasi' => 'nullable|string|max:100',
            'jenis_permohonan_lainnya' => 'nullable|string|max:500',
            'status_informasi' => 'nullable|in:ya,dibawah_penguasaan,tidak_dibawah_penguasaan,belum_didokumentasikan',
            'bentuk_informasi' => 'nullable|in:softcopy,hardcopy,softcopy_hardcopy',
            'jenis_permintaan' => 'nullable|in:melihat_mengetahui,meminta_salinan,melihat_dan_salinan',
        ]);

        $oldStatusLabel = $permohonan->status_label;
        $permohonan->status = $request->status;
        $permohonan->catatan_admin = $request->catatan_admin;
        $permohonan->kategori_informasi = $request->kategori_informasi;
        $permohonan->jenis_permohonan_informasi = $request->jenis_permohonan_informasi;
        $permohonan->jenis_permohonan_lainnya = $request->jenis_permohonan_lainnya;
        $permohonan->status_informasi = $request->status_informasi;
        $permohonan->bentuk_informasi = $request->bentuk_informasi;
        $permohonan->jenis_permintaan = $request->jenis_permintaan;
        
        if (in_array($request->status, ['dikabulkan_seluruhnya', 'dikabulkan_sebagian', 'ditolak'])) {
            $permohonan->tanggal_selesai = now();
        }
        
        $permohonan->save();

        // Kirim email pemberitahuan perubahan status ke pemohon
        if ($permohonan->email) {
            try {
                $mailer = app(GraphMailService::class);
                $content =
                    "Halo {$permohonan->nama},\n\n" .
                    "Status permohonan informasi Anda telah berubah.\n" .
                    "Nomor Registrasi: {$permohonan->nomor_registrasi}\n" .
                    "Status sebelumnya: {$oldStatusLabel}\n" .
                    "Status sekarang: {$permohonan->status_label_public}\n" .
                    ($permohonan->catatan_admin ? "Catatan: {$permohonan->catatan_admin}\n" : '') .
                    "\nAnda dapat mengecek status melalui halaman cek status permohonan.";

                if (!$mailer->send($permohonan->email, 'Pembaruan Status Permohonan Informasi - PPID', $content)) {
                    Log::error('Gagal mengirim email status permohonan (Graph).', [
                        'permohonan_id' => $permohonan->id,
                        'email' => $permohonan->email,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error saat mengirim email: ' . $e->getMessage());
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
            'perlu_verifikasi' => Permohonan::where('status', 'perlu_verifikasi')->count(),
            'diproses' => Permohonan::where('status', 'diproses')->count(),
            'ditunda' => Permohonan::where('status', 'ditunda')->count(),
            'dikabulkan_seluruhnya' => Permohonan::where('status', 'dikabulkan_seluruhnya')->count(),
            'dikabulkan_sebagian' => Permohonan::where('status', 'dikabulkan_sebagian')->count(),
            'ditolak' => Permohonan::where('status', 'ditolak')->count(),
        ];

        $perKategori = Permohonan::selectRaw('kategori_pemohon, COUNT(*) as total')
            ->groupBy('kategori_pemohon')
            ->get();

        return view('admin.permohonan.statistics', compact('stats', 'perKategori'));
    }
}