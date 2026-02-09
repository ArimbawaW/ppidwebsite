<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class PermohonanController extends Controller
{
    /**
     * Tampilkan form permohonan
     */
    public function index()
    {
        return view('frontend.permohonan.index');
    }

    /**
     * Proses penyimpanan permohonan
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $rules = [
            'kategori_pemohon' => 'required|in:perorangan,kelompok,badan_hukum',
            'nama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'rincian_informasi' => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'persetujuan_terms' => 'required|accepted',
        ];

        $messages = [
            'kategori_pemohon.required' => '⚠️ Kategori pemohon wajib dipilih!',
            'persetujuan_terms.accepted' => 'Anda harus mencentang persetujuan untuk melanjutkan.',
            'file_identitas.required' => 'File kartu identitas wajib diupload.',
            'file_identitas.max' => 'Ukuran file maksimal 2MB.',
        ];

        // Validasi tambahan berdasarkan kategori
        if ($request->kategori_pemohon === 'perorangan') {
            $rules['jenis_identitas'] = 'required|string|max:50';
            $rules['nomor_identitas'] = 'required|string|max:100';
            $rules['file_identitas'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        } elseif ($request->kategori_pemohon === 'kelompok') {
            $rules['nomor_ktp_pemberi_kuasa'] = 'required|string|max:100';
            $rules['file_surat_kuasa'] = 'required|file|mimes:pdf|max:2048';
            $rules['file_ktp_pemberi_kuasa'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        } elseif ($request->kategori_pemohon === 'badan_hukum') {
            $rules['nomor_akta_ahu'] = 'required|string|max:100';
            $rules['file_akta_ahu'] = 'required|file|mimes:pdf|max:2048';
            $rules['file_ad_art'] = 'required|file|mimes:pdf|max:2048';
        }

        $validated = $request->validate($rules, $messages);

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // Nomor registrasi akan di-generate otomatis oleh Model
            // melalui event booted() pada saat creating
            
            $data = [
                'kategori_pemohon' => $validated['kategori_pemohon'],
                'nama' => $validated['nama'],
                'pekerjaan' => $validated['pekerjaan'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'email' => $validated['email'],
                'rincian_informasi' => $validated['rincian_informasi'],
                'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
                'persetujuan_terms' => true,
                'status' => 'perlu_verifikasi',
            ];

            // 3. Proses Upload File
            if ($request->kategori_pemohon === 'perorangan') {
                $data['jenis_identitas'] = $validated['jenis_identitas'];
                $data['nomor_identitas'] = $validated['nomor_identitas'];
                $data['file_identitas_path'] = $request->file('file_identitas')->store('permohonan/identitas', 'public');
            } elseif ($request->kategori_pemohon === 'kelompok') {
                $data['nomor_ktp_pemberi_kuasa'] = $validated['nomor_ktp_pemberi_kuasa'];
                $data['file_surat_kuasa_path'] = $request->file('file_surat_kuasa')->store('permohonan/surat-kuasa', 'public');
                $data['file_ktp_pemberi_kuasa_path'] = $request->file('file_ktp_pemberi_kuasa')->store('permohonan/ktp-kuasa', 'public');
            } elseif ($request->kategori_pemohon === 'badan_hukum') {
                $data['nomor_akta_ahu'] = $validated['nomor_akta_ahu'];
                $data['file_akta_ahu_path'] = $request->file('file_akta_ahu')->store('permohonan/akta-ahu', 'public');
                $data['file_ad_art_path'] = $request->file('file_ad_art')->store('permohonan/ad-art', 'public');
            }

            // 4. Simpan ke Database
            // Nomor registrasi akan di-generate otomatis
            $permohonan = Permohonan::create($data);

            // Jika sampai sini tidak ada error, commit transaksi
            DB::commit();

            // 5. Kirim Email (Setelah Commit agar jika email gagal, data tetap tersimpan)
            $this->sendNotifications($permohonan);

            return redirect()->route('permohonan.index')
                ->with('success', '✅ Permohonan berhasil dikirim! Nomor Registrasi: ' . $permohonan->nomor_registrasi);

        } catch (Exception $e) {
            // Jika ada error, batalkan semua perubahan database
            DB::rollBack();
            
            Log::error('Gagal simpan permohonan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Kirim email notifikasi dengan template resmi
     */
    private function sendNotifications($permohonan)
    {
        try {
            $mailer = app(GraphMailService::class);
            
            // ============================================
            // EMAIL UNTUK PEMOHON (FORMAT RESMI)
            // ============================================
            $pemohonContent = $this->generateEmailTemplatePemohon($permohonan);
            $mailer->send(
                $permohonan->email, 
                'Konfirmasi Penerimaan Permohonan Informasi Publik - PPID Kementerian PUPR', 
                $pemohonContent
            );

            // ============================================
            // EMAIL UNTUK ADMIN (NOTIFIKASI INTERNAL)
            // ============================================
            $adminContent = $this->generateEmailTemplateAdmin($permohonan);
            $mailer->send(
                config('mail.from.address'), 
                '[PPID] Permohonan Informasi Baru - ' . $permohonan->nomor_registrasi, 
                $adminContent
            );
            
        } catch (Exception $e) {
            Log::error('Email Notif Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate template email untuk pemohon (Format Resmi Kementerian)
     */
    private function generateEmailTemplatePemohon($permohonan)
    {
        $template = "Yth. {$permohonan->nama},\n\n";
        $template .= "Permohonan informasi publik dengan Nomor Tiket: {$permohonan->nomor_registrasi} telah kami terima dan akan diverifikasi.\n\n";
        $template .= "Nomor tiket digunakan untuk mengecek status permohonan informasi. Permohonan informasi Bapak/Ibu akan kami verifikasi dan kami berikan tanggapan sesuai dengan ketentuan paling lambat 10 (Sepuluh) hari kerja.\n\n";
        $template .= "Apabila dalam proses pemenuhan informasi diperlukan perpanjangan waktu, maka penyelesaian akan diperpanjang selama 7 (Tujuh) Hari Kerja berikutnya.\n\n";
        $template .= "Bapak/Ibu dapat melakukan pengecekan status pengajuan secara berkala melalui kanal permohonan yang digunakan.\n\n";
        $template .= "----------------------------------------\n";
        $template .= "DETAIL PERMOHONAN\n";
        $template .= "----------------------------------------\n";
        $template .= "Nomor Tiket: {$permohonan->nomor_registrasi}\n";
        $template .= "Nama Pemohon: {$permohonan->nama}\n";
        $template .= "Kategori: " . $this->getKategoriLabel($permohonan->kategori_pemohon) . "\n";
        $template .= "Tanggal Pengajuan: " . $permohonan->created_at->format('d F Y, H:i') . " WIB\n";
        $template .= "----------------------------------------\n\n";
        $template .= "Untuk mengecek status permohonan, silakan kunjungi:\n";
        $template .= url('/cek-status') . "\n\n";
        $template .= "Hormat Kami,\n";
        $template .= "PPID Kementerian Perumahan Kawasan dan Permukiman\n\n";
        $template .= "----------------------------------------\n";
        $template .= "Email ini dikirim secara otomatis, mohon tidak membalas email ini.\n";
        $template .= "Untuk pertanyaan lebih lanjut, silakan hubungi PPID melalui saluran resmi.\n";

        return $template;
    }

    /**
     * Generate template email untuk admin (Notifikasi Internal)
     */
    private function generateEmailTemplateAdmin($permohonan)
    {
        $template = "==============================================\n";
        $template .= "NOTIFIKASI PERMOHONAN INFORMASI BARU\n";
        $template .= "==============================================\n\n";
        $template .= "Ada permohonan informasi publik baru yang perlu ditindaklanjuti.\n\n";
        $template .= "DETAIL PERMOHONAN:\n";
        $template .= "----------------------------------------\n";
        $template .= "Nomor Tiket: {$permohonan->nomor_registrasi}\n";
        $template .= "Nama Pemohon: {$permohonan->nama}\n";
        $template .= "Email: {$permohonan->email}\n";
        $template .= "No. Telepon: {$permohonan->no_telepon}\n";
        $template .= "Kategori: " . $this->getKategoriLabel($permohonan->kategori_pemohon) . "\n";
        $template .= "Pekerjaan: {$permohonan->pekerjaan}\n";
        $template .= "Alamat: {$permohonan->alamat}\n\n";
        $template .= "RINCIAN INFORMASI:\n";
        $template .= "----------------------------------------\n";
        $template .= "{$permohonan->rincian_informasi}\n\n";
        $template .= "TUJUAN PENGGUNAAN:\n";
        $template .= "----------------------------------------\n";
        $template .= "{$permohonan->tujuan_penggunaan}\n\n";
        $template .= "WAKTU:\n";
        $template .= "----------------------------------------\n";
        $template .= "Tanggal Masuk: " . $permohonan->created_at->format('d F Y, H:i') . " WIB\n";
        $template .= "Status: Perlu Verifikasi\n";
        $template .= "Batas Waktu: 10 Hari Kerja (s.d. " . $permohonan->deadline->format('d F Y') . ")\n\n";
        $template .= "----------------------------------------\n";
        $template .= "Link Detail: " . route('admin.permohonan.show', $permohonan->id) . "\n";
        $template .= "----------------------------------------\n\n";
        $template .= "Harap segera melakukan verifikasi dan tindak lanjut.\n\n";
        $template .= "Sistem PPID Kementerian PUPR\n";

        return $template;
    }

    /**
     * Helper untuk get label kategori pemohon
     */
    private function getKategoriLabel($kategori)
    {
        return match($kategori) {
            'perorangan' => 'Perorangan',
            'kelompok' => 'Kelompok Orang',
            'badan_hukum' => 'Badan Hukum',
            default => $kategori,
        };
    }
}