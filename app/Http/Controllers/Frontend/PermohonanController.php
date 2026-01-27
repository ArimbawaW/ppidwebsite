<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            // Validasi dasar untuk semua kategori
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

            // Custom error messages
            $messages = [
                // Kategori Pemohon
                'kategori_pemohon.required' => '⚠️ Kategori pemohon wajib dipilih! Silakan pilih salah satu: Perorangan, Kelompok Orang, atau Badan Hukum.',
                'kategori_pemohon.in' => 'Kategori pemohon tidak valid. Pilih salah satu dari opsi yang tersedia.',
                
                // Data Pemohon
                'nama.required' => 'Nama lengkap wajib diisi.',
                'nama.max' => 'Nama lengkap maksimal 255 karakter.',
                'pekerjaan.required' => 'Pekerjaan wajib diisi.',
                'pekerjaan.max' => 'Pekerjaan maksimal 255 karakter.',
                'alamat.required' => 'Alamat lengkap wajib diisi.',
                'no_telepon.required' => 'Nomor telepon/HP wajib diisi.',
                'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid. Contoh: nama@email.com',
                'email.max' => 'Email maksimal 255 karakter.',
                
                // Rincian Permohonan
                'rincian_informasi.required' => 'Rincian informasi yang dibutuhkan wajib diisi.',
                'tujuan_penggunaan.required' => 'Tujuan penggunaan informasi wajib diisi.',
                
                // Persetujuan
                'persetujuan_terms.required' => 'Anda harus menyetujui pernyataan di atas.',
                'persetujuan_terms.accepted' => 'Anda harus mencentang persetujuan untuk melanjutkan.',
            ];

            // Validasi tambahan berdasarkan kategori pemohon
            if ($request->kategori_pemohon === 'perorangan') {
                $rules['jenis_identitas'] = 'required|string|max:50';
                $rules['nomor_identitas'] = 'required|string|max:100';
                $rules['file_identitas'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
                
                // Custom messages untuk perorangan
                $messages['jenis_identitas.required'] = 'Jenis kartu identitas wajib dipilih.';
                $messages['nomor_identitas.required'] = 'Nomor identitas wajib diisi.';
                $messages['nomor_identitas.max'] = 'Nomor identitas maksimal 100 karakter.';
                $messages['file_identitas.required'] = 'File kartu identitas wajib diupload.';
                $messages['file_identitas.mimes'] = 'File identitas harus berformat PDF, JPG, JPEG, atau PNG.';
                $messages['file_identitas.max'] = 'Ukuran file identitas maksimal 2MB.';
            } 
            elseif ($request->kategori_pemohon === 'kelompok') {
                $rules['nomor_ktp_pemberi_kuasa'] = 'required|string|max:100';
                $rules['file_surat_kuasa'] = 'required|file|mimes:pdf|max:2048';
                $rules['file_ktp_pemberi_kuasa'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
                
                // Custom messages untuk kelompok
                $messages['nomor_ktp_pemberi_kuasa.required'] = 'Nomor KTP pemberi kuasa wajib diisi.';
                $messages['nomor_ktp_pemberi_kuasa.max'] = 'Nomor KTP pemberi kuasa maksimal 100 karakter.';
                $messages['file_surat_kuasa.required'] = 'File surat kuasa wajib diupload.';
                $messages['file_surat_kuasa.mimes'] = 'File surat kuasa harus berformat PDF.';
                $messages['file_surat_kuasa.max'] = 'Ukuran file surat kuasa maksimal 2MB.';
                $messages['file_ktp_pemberi_kuasa.required'] = 'File KTP pemberi kuasa wajib diupload.';
                $messages['file_ktp_pemberi_kuasa.mimes'] = 'File KTP pemberi kuasa harus berformat PDF, JPG, JPEG, atau PNG.';
                $messages['file_ktp_pemberi_kuasa.max'] = 'Ukuran file KTP pemberi kuasa maksimal 2MB.';
            } 
            elseif ($request->kategori_pemohon === 'badan_hukum') {
                $rules['nomor_akta_ahu'] = 'required|string|max:100';
                $rules['file_akta_ahu'] = 'required|file|mimes:pdf|max:2048';
                $rules['file_ad_art'] = 'required|file|mimes:pdf|max:2048';
                
                // Custom messages untuk badan hukum
                $messages['nomor_akta_ahu.required'] = 'Nomor akta AHU wajib diisi.';
                $messages['nomor_akta_ahu.max'] = 'Nomor akta AHU maksimal 100 karakter.';
                $messages['file_akta_ahu.required'] = 'File akta AHU wajib diupload.';
                $messages['file_akta_ahu.mimes'] = 'File akta AHU harus berformat PDF.';
                $messages['file_akta_ahu.max'] = 'Ukuran file akta AHU maksimal 2MB.';
                $messages['file_ad_art.required'] = 'File AD/ART wajib diupload.';
                $messages['file_ad_art.mimes'] = 'File AD/ART harus berformat PDF.';
                $messages['file_ad_art.max'] = 'Ukuran file AD/ART maksimal 2MB.';
            }

            // Validasi dengan custom messages
            $validated = $request->validate($rules, $messages);

            // Generate nomor registrasi
            $nomorRegistrasi = $this->generateNomorRegistrasi();

            // Data dasar
            $data = [
                'nomor_registrasi' => $nomorRegistrasi,
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

            // Upload file berdasarkan kategori
            try {
                if ($request->kategori_pemohon === 'perorangan') {
                    $data['jenis_identitas'] = $validated['jenis_identitas'];
                    $data['nomor_identitas'] = $validated['nomor_identitas'];
                    
                    if ($request->hasFile('file_identitas')) {
                        $file = $request->file('file_identitas');
                        $filename = time() . '_identitas_' . $file->getClientOriginalName();
                        $data['file_identitas_path'] = $file->storeAs('permohonan/identitas', $filename, 'public');
                    }
                } 
                elseif ($request->kategori_pemohon === 'kelompok') {
                    $data['nomor_ktp_pemberi_kuasa'] = $validated['nomor_ktp_pemberi_kuasa'];
                    
                    if ($request->hasFile('file_surat_kuasa')) {
                        $file = $request->file('file_surat_kuasa');
                        $filename = time() . '_surat_kuasa_' . $file->getClientOriginalName();
                        $data['file_surat_kuasa_path'] = $file->storeAs('permohonan/surat-kuasa', $filename, 'public');
                    }
                    
                    if ($request->hasFile('file_ktp_pemberi_kuasa')) {
                        $file = $request->file('file_ktp_pemberi_kuasa');
                        $filename = time() . '_ktp_kuasa_' . $file->getClientOriginalName();
                        $data['file_ktp_pemberi_kuasa_path'] = $file->storeAs('permohonan/ktp-kuasa', $filename, 'public');
                    }
                } 
                elseif ($request->kategori_pemohon === 'badan_hukum') {
                    $data['nomor_akta_ahu'] = $validated['nomor_akta_ahu'];
                    
                    if ($request->hasFile('file_akta_ahu')) {
                        $file = $request->file('file_akta_ahu');
                        $filename = time() . '_akta_ahu_' . $file->getClientOriginalName();
                        $data['file_akta_ahu_path'] = $file->storeAs('permohonan/akta-ahu', $filename, 'public');
                    }
                    
                    if ($request->hasFile('file_ad_art')) {
                        $file = $request->file('file_ad_art');
                        $filename = time() . '_ad_art_' . $file->getClientOriginalName();
                        $data['file_ad_art_path'] = $file->storeAs('permohonan/ad-art', $filename, 'public');
                    }
                }
            } catch (Exception $e) {
                Log::error('Error uploading files: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ Gagal mengupload file. Pastikan file tidak corrupt dan ukurannya tidak melebihi 2MB. Error: ' . $e->getMessage());
            }

            // Simpan ke database
            try {
                $permohonan = Permohonan::create($data);
                
                Log::info('Permohonan berhasil dibuat', [
                    'nomor_registrasi' => $permohonan->nomor_registrasi,
                    'kategori' => $permohonan->kategori_pemohon,
                    'nama' => $permohonan->nama
                    
                    
                ]);
                
            } catch (Exception $e) {
                Log::error('Error creating permohonan: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ Gagal menyimpan permohonan ke database. Silakan coba lagi. Error: ' . $e->getMessage());
            }

            $mailer = app(GraphMailService::class);
            $kategoriLabel = match($permohonan->kategori_pemohon) {
                'perorangan' => 'Perorangan',
                'kelompok' => 'Kelompok Orang',
                'badan_hukum' => 'Badan Hukum',
                default => $permohonan->kategori_pemohon,
            };

            $adminContent =
                "Permohonan informasi baru telah diterima.\n\n" .
                "Nomor Registrasi: {$permohonan->nomor_registrasi}\n" .
                "Kategori Pemohon: {$kategoriLabel}\n" .
                "Nama: {$permohonan->nama}\n" .
                "Email: {$permohonan->email}\n" .
                "Pekerjaan: {$permohonan->pekerjaan}";

            if (!$mailer->send(config('mail.from.address'), 'Permohonan Informasi Baru - PPID', $adminContent)) {
                Log::error('Email admin permohonan gagal dikirim (Graph).');
            }

            $pemohonContent =
             "Halo {$permohonan->nama},\n\n" .
            "Permohonan informasi Anda telah kami terima.\n" .
            "Nomor Registrasi: {$permohonan->nomor_registrasi}\n" .
            "Status awal: Menunggu Verifikasi\n\n" .
            "Simpan nomor registrasi ini untuk mengecek status permohonan Anda.";

            if (!$mailer->send($permohonan->email, 'Nomor Registrasi Permohonan Informasi - PPID', $pemohonContent)) {
                Log::error('Email ke pemohon gagal dikirim (Graph).');
            }

            return redirect()->route('permohonan.index')
                ->with('success', '✅ Permohonan berhasil dikirim! Nomor Registrasi Anda: ' . $nomorRegistrasi . '. Simpan nomor ini untuk mengecek status permohonan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi dengan pesan yang lebih informatif
            $errors = $e->errors();
            
            // Cek apakah error kategori_pemohon
            if (isset($errors['kategori_pemohon'])) {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('error', '❌ Kategori pemohon belum dipilih! Silakan pilih salah satu: Perorangan, Kelompok Orang, atau Badan Hukum.');
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', '❌ Validasi gagal! Periksa kembali data yang Anda masukkan. Pastikan semua field yang wajib diisi sudah terisi dengan benar.');
                
        } catch (Exception $e) {
            Log::error('Error umum saat menyimpan permohonan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
        }
    }

    /**
     * Generate nomor registrasi
     */
    private function generateNomorRegistrasi()
    {
        $tahun = date('Y');
        $bulan = date('m');
        
        $count = Permohonan::whereYear('created_at', $tahun)
                          ->whereMonth('created_at', $bulan)
                          ->count();
        
        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        
        return "PPID/PERMOHONAN/{$tahun}/{$bulan}/{$urutan}";
    }
}