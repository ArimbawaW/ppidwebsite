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

        $oldStatus = $permohonan->status;
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

        // Kirim email pemberitahuan perubahan status ke pemohon (HANYA JIKA STATUS BERUBAH)
        if ($oldStatus !== $request->status && $permohonan->email) {
            try {
                $this->sendStatusChangeEmail($permohonan, $oldStatusLabel);
            } catch (\Exception $e) {
                Log::error('Error saat mengirim email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.permohonan.show', $permohonan)
            ->with('success', 'Status permohonan berhasil diperbarui.');
    }

    /**
     * Kirim email notifikasi perubahan status dengan template resmi
     */
    private function sendStatusChangeEmail($permohonan, $oldStatusLabel)
    {
        $mailer = app(GraphMailService::class);
        
        // Konversi status ke versi user-friendly
        $oldStatusPublic = $this->convertToPublicStatus($oldStatusLabel);
        $newStatusPublic = $permohonan->status_label_public;
        
        // Generate email content berdasarkan status baru
        $emailContent = $this->generateStatusEmailTemplate(
            $permohonan, 
            $oldStatusPublic, 
            $newStatusPublic
        );
        
        $subject = $this->generateEmailSubject($permohonan->status);
        
        if (!$mailer->send($permohonan->email, $subject, $emailContent)) {
            Log::error('Gagal mengirim email status permohonan (Graph).', [
                'permohonan_id' => $permohonan->id,
                'email' => $permohonan->email,
            ]);
        }
    }

    /**
     * Generate subject email berdasarkan status
     */
    private function generateEmailSubject($status)
    {
        return match($status) {
            'perlu_verifikasi' => 'Permohonan Informasi Menunggu Verifikasi - PPID Kementerian PUPR',
            'diproses' => 'Permohonan Informasi Sedang Diproses - PPID Kementerian PUPR',
            'ditunda' => 'Pemberitahuan Penundaan Permohonan Informasi - PPID Kementerian PUPR',
            'dikabulkan_seluruhnya', 'dikabulkan_sebagian' => 'Permohonan Informasi Disetujui - PPID Kementerian PUPR',
            'ditolak' => 'Pemberitahuan Penolakan Permohonan Informasi - PPID Kementerian PUPR',
            default => 'Pembaruan Status Permohonan Informasi - PPID Kementerian PUPR',
        };
    }

    /**
     * Convert status label admin ke public
     */
    private function convertToPublicStatus($statusLabel)
    {
        return match($statusLabel) {
            'Perlu Verifikasi' => 'Menunggu Verifikasi',
            'Sedang Diproses' => 'Sedang Diproses',
            'Ditunda' => 'Ditunda',
            'Dikabulkan Seluruhnya' => 'Disetujui',
            'Dikabulkan Sebagian' => 'Disetujui',
            'Ditolak' => 'Ditolak',
            default => $statusLabel,
        };
    }

    /**
     * Generate template email berdasarkan status
     */
    private function generateStatusEmailTemplate($permohonan, $oldStatus, $newStatus)
    {
        $template = "Yth. {$permohonan->nama},\n\n";
        $template .= "Terdapat pembaruan status pada permohonan informasi publik Bapak/Ibu.\n\n";
        
        // Informasi Permohonan
        $template .= "========================================\n";
        $template .= "INFORMASI PERMOHONAN\n";
        $template .= "========================================\n";
        $template .= "Nomor Tiket: {$permohonan->nomor_registrasi}\n";
        $template .= "Nama Pemohon: {$permohonan->nama}\n";
        $template .= "Tanggal Pengajuan: " . $permohonan->created_at->format('d F Y') . "\n\n";
        
        // Status Update
        $template .= "========================================\n";
        $template .= "PEMBARUAN STATUS\n";
        $template .= "========================================\n";
        $template .= "Status Sebelumnya: {$oldStatus}\n";
        $template .= "Status Saat Ini: {$newStatus}\n";
        $template .= "Tanggal Update: " . now()->format('d F Y, H:i') . " WIB\n\n";
        
        // Pesan khusus berdasarkan status
        $template .= $this->getStatusSpecificMessage($permohonan);
        
        // Catatan Admin (jika ada)
        if ($permohonan->catatan_admin) {
            $template .= "========================================\n";
            $template .= "CATATAN DARI PPID\n";
            $template .= "========================================\n";
            $template .= $permohonan->catatan_admin . "\n\n";
        }
        
        // Informasi Tambahan
        $template .= "========================================\n";
        $template .= "INFORMASI LEBIH LANJUT\n";
        $template .= "========================================\n";
        $template .= "Bapak/Ibu dapat melakukan pengecekan status secara berkala melalui:\n";
        $template .= url('/cek-status') . "\n\n";
        $template .= "Gunakan Nomor Tiket dan Email yang terdaftar untuk melakukan pengecekan.\n\n";
        
        // Penutup
        $template .= "Hormat Kami,\n";
        $template .= "PPID Kementerian Pekerjaan Umum dan Perumahan Rakyat\n\n";
        $template .= "----------------------------------------\n";
        $template .= "Email ini dikirim secara otomatis, mohon tidak membalas email ini.\n";
        $template .= "Untuk pertanyaan lebih lanjut, silakan hubungi PPID melalui saluran resmi.\n";
        
        return $template;
    }

    /**
     * Get pesan spesifik berdasarkan status
     */
    private function getStatusSpecificMessage($permohonan)
    {
        $message = "";
        
        switch ($permohonan->status) {
            case 'perlu_verifikasi':
                $message .= "Permohonan Bapak/Ibu sedang dalam tahap verifikasi awal.\n";
                $message .= "Kami akan segera memproses dan memberikan tanggapan dalam waktu 10 (Sepuluh) hari kerja.\n\n";
                break;
                
            case 'diproses':
                $message .= "Permohonan Bapak/Ibu telah diverifikasi dan saat ini sedang dalam proses pemenuhan informasi.\n";
                $message .= "Tim kami sedang mengumpulkan dan menyiapkan informasi yang Bapak/Ibu butuhkan.\n\n";
                break;
                
            case 'ditunda':
                $message .= "Permohonan Bapak/Ibu saat ini ditunda untuk sementara waktu.\n";
                $message .= "Sesuai ketentuan, apabila diperlukan perpanjangan waktu, penyelesaian akan diperpanjang selama 7 (Tujuh) Hari Kerja berikutnya.\n";
                $message .= "Kami akan segera menginformasikan perkembangan selanjutnya.\n\n";
                break;
                
            case 'dikabulkan_seluruhnya':
            case 'dikabulkan_sebagian':
                $message .= "Permohonan informasi Bapak/Ibu telah DISETUJUI.\n";
                $message .= "Informasi yang diminta telah tersedia dan dapat diakses sesuai dengan instruksi yang telah diberikan.\n\n";
                
                if ($permohonan->tanggal_selesai) {
                    $message .= "Tanggal Penyelesaian: " . $permohonan->tanggal_selesai->format('d F Y') . "\n\n";
                }
                
                $message .= "Terima kasih atas kepercayaan Bapak/Ibu kepada layanan informasi publik kami.\n\n";
                break;
                
            case 'ditolak':
                $message .= "Permohonan informasi Bapak/Ibu TIDAK DAPAT DIPENUHI.\n\n";
                $message .= "Sesuai dengan Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik,\n";
                $message .= "Bapak/Ibu memiliki hak untuk mengajukan keberatan atas keputusan ini.\n\n";
                $message .= "Untuk mengajukan keberatan, silakan kunjungi:\n";
                $message .= url('/keberatan') . "\n\n";
                $message .= "Keberatan dapat diajukan paling lambat 30 (tiga puluh) hari kerja setelah permohonan ditolak.\n\n";
                break;
                
            default:
                $message .= "Silakan cek secara berkala untuk update status terbaru.\n\n";
        }
        
        return $message;
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