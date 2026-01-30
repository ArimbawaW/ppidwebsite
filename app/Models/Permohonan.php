<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable = [
        'nomor_registrasi',
        'kategori_pemohon',
        'nama',
        'pekerjaan',
        'alamat',
        'no_telepon',
        'email',
        'rincian_informasi',
        'tujuan_penggunaan',
        'persetujuan_terms',
        'status',
        // Untuk Perorangan
        'jenis_identitas',
        'nomor_identitas',
        'file_identitas_path',
        // Untuk Kelompok
        'nomor_ktp_pemberi_kuasa',
        'file_surat_kuasa_path',
        'file_ktp_pemberi_kuasa_path',
        // Untuk Badan Hukum
        'nomor_akta_ahu',
        'file_akta_ahu_path',
        'file_ad_art_path',
        // Admin fields
        'catatan_admin',
        'tanggal_selesai',
        // Admin input fields
        'kategori_informasi',
        'jenis_permohonan_informasi',
        'jenis_permohonan_lainnya',
        'status_informasi',
        'bentuk_informasi',
        'jenis_permintaan',
    ];

    protected $casts = [
        'persetujuan_terms' => 'boolean',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ========================================
    // WAKTU & INDIKATOR METHODS
    // ========================================
    
    /**
     * Konstanta batas waktu maksimal (hari kerja)
     */
    const BATAS_WAKTU_HARI_KERJA = 10;

    /**
     * Hitung sisa hari kerja dari permohonan
     * Menghitung hari kerja (Senin-Jumat), tidak termasuk weekend
     */
    public function getSisaHariKerjaAttribute()
    {
        // Jika sudah selesai, tidak perlu hitung lagi
        if ($this->tanggal_selesai) {
            return 0;
        }

        $tanggalAwal = $this->created_at;
        $tanggalSekarang = Carbon::now();
        
        // Hitung hari kerja antara tanggal awal dan sekarang
        $hariKerjaTerpakai = $this->hitungHariKerja($tanggalAwal, $tanggalSekarang);
        
        // Sisa hari kerja
        $sisaHari = self::BATAS_WAKTU_HARI_KERJA - $hariKerjaTerpakai;
        
        return max(0, $sisaHari); // Minimal 0, tidak boleh negatif
    }

    /**
     * Hitung berapa hari kerja sudah terpakai
     */
    public function getHariKerjaTerpakaiAttribute()
    {
        if ($this->tanggal_selesai) {
            return $this->hitungHariKerja($this->created_at, $this->tanggal_selesai);
        }

        return $this->hitungHariKerja($this->created_at, Carbon::now());
    }

    /**
     * Helper function untuk menghitung hari kerja
     */
    private function hitungHariKerja($tanggalAwal, $tanggalAkhir)
    {
        $awal = Carbon::parse($tanggalAwal);
        $akhir = Carbon::parse($tanggalAkhir);
        
        $hariKerja = 0;
        
        while ($awal->lte($akhir)) {
            // Senin = 1, Jumat = 5
            if ($awal->dayOfWeek >= 1 && $awal->dayOfWeek <= 5) {
                $hariKerja++;
            }
            $awal->addDay();
        }
        
        return $hariKerja;
    }

    /**
     * Get status warna indikator berdasarkan sisa hari
     * H1-H5 = Hijau (Aman)
     * H6-H8 = Kuning (Perhatian)
     * H9-H10 = Merah (Urgent)
     * >H10 = Merah Tua (Terlambat)
     */
    public function getIndikatorWaktuAttribute()
    {
        // Jika sudah selesai, tidak perlu indikator
        if ($this->tanggal_selesai) {
            return [
                'warna' => 'success',
                'warna_hex' => '#28a745',
                'bg_class' => 'bg-success',
                'text_class' => 'text-success',
                'badge_class' => 'badge-success',
                'label' => 'Selesai',
                'icon' => 'check-circle',
                'sisa_hari' => 0,
                'hari_terpakai' => $this->hari_kerja_terpakai,
                'persentase' => 100,
            ];
        }

        $sisaHari = $this->sisa_hari_kerja;
        $hariTerpakai = $this->hari_kerja_terpakai;
        $persentase = min(100, ($hariTerpakai / self::BATAS_WAKTU_HARI_KERJA) * 100);

        // H1-H5 (Hari ke-1 sampai ke-5) = HIJAU (Masih aman, sisa 5 hari atau lebih)
        if ($sisaHari >= 5) {
            return [
                'warna' => 'success',
                'warna_hex' => '#28a745',
                'bg_class' => 'bg-success',
                'text_class' => 'text-success',
                'badge_class' => 'badge-success',
                'label' => 'Aman',
                'icon' => 'check-circle',
                'sisa_hari' => $sisaHari,
                'hari_terpakai' => $hariTerpakai,
                'persentase' => $persentase,
            ];
        }
        
        // H6-H8 (Hari ke-6 sampai ke-8) = KUNING (Perhatian, sisa 2-4 hari)
        if ($sisaHari >= 2 && $sisaHari <= 4) {
            return [
                'warna' => 'warning',
                'warna_hex' => '#ffc107',
                'bg_class' => 'bg-warning',
                'text_class' => 'text-warning',
                'badge_class' => 'badge-warning',
                'label' => 'Perhatian',
                'icon' => 'exclamation-triangle',
                'sisa_hari' => $sisaHari,
                'hari_terpakai' => $hariTerpakai,
                'persentase' => $persentase,
            ];
        }
        
        // H9-H10 (Hari ke-9 sampai ke-10) = MERAH (Urgent, sisa 0-1 hari)
        if ($sisaHari >= 0 && $sisaHari <= 1) {
            return [
                'warna' => 'danger',
                'warna_hex' => '#dc3545',
                'bg_class' => 'bg-danger',
                'text_class' => 'text-danger',
                'badge_class' => 'badge-danger',
                'label' => 'Urgent',
                'icon' => 'exclamation-circle',
                'sisa_hari' => $sisaHari,
                'hari_terpakai' => $hariTerpakai,
                'persentase' => $persentase,
            ];
        }

        // Lebih dari H10 = MERAH TUA (Terlambat)
        return [
            'warna' => 'danger',
            'warna_hex' => '#a71d2a',
            'bg_class' => 'bg-danger',
            'text_class' => 'text-danger',
            'badge_class' => 'badge-danger',
            'label' => 'Terlambat',
            'icon' => 'times-circle',
            'sisa_hari' => 0,
            'hari_terpakai' => $hariTerpakai,
            'persentase' => 100,
            'terlambat' => true,
            'hari_keterlambatan' => abs($sisaHari),
        ];
    }

    /**
     * Check apakah permohonan sudah urgent (H9-H10)
     */
    public function getIsUrgentAttribute()
    {
        $indikator = $this->indikator_waktu;
        return $indikator['label'] === 'Urgent' || $indikator['label'] === 'Terlambat';
    }

    /**
     * Check apakah permohonan terlambat
     */
    public function getIsTerlambatAttribute()
    {
        return isset($this->indikator_waktu['terlambat']) && $this->indikator_waktu['terlambat'] === true;
    }

    /**
     * Get tanggal deadline (hari kerja)
     */
    public function getDeadlineAttribute()
    {
        $tanggal = $this->created_at->copy();
        $hariKerjaCounter = 0;
        
        while ($hariKerjaCounter < self::BATAS_WAKTU_HARI_KERJA) {
            $tanggal->addDay();
            
            // Hitung hanya hari kerja (Senin-Jumat)
            if ($tanggal->dayOfWeek >= 1 && $tanggal->dayOfWeek <= 5) {
                $hariKerjaCounter++;
            }
        }
        
        return $tanggal;
    }

    // ========================================
    // EXISTING METHODS
    // ========================================

    /**
     * Get kategori label
     */
    public function getKategoriLabelAttribute()
    {
        return match($this->kategori_pemohon) {
            'perorangan' => 'Perorangan',
            'kelompok' => 'Kelompok Orang',
            'badan_hukum' => 'Badan Hukum',
            default => $this->kategori_pemohon,
        };
    }

    /**
     * Get kategori informasi label
     */
    public function getKategoriInformasiLabelAttribute()
    {
        return match($this->kategori_informasi) {
            'informasi_berkala' => 'Informasi Berkala',
            'informasi_setiap_saat' => 'Informasi Setiap Saat',
            'informasi_serta_merta' => 'Informasi Serta Merta',
            'informasi_dikecualikan' => 'Informasi Dikecualikan',
            default => '-',
        };
    }

    /**
     * Get jenis permohonan informasi label
     */
    public function getJenisPermohonanInformasiLabelAttribute()
    {
        $labels = [
            'aplikasi_sistem_informasi' => 'Aplikasi/Sistem Informasi',
            'kemitraan_kerja_sama' => 'Kemitraan/Kerja Sama',
            'jabatan_fungsional' => 'Jabatan Fungsional',
            'kebijakan_regulasi' => 'Kebijakan/Regulasi',
            'konsultasi_teknis' => 'Konsultasi Teknis',
            'perizinan' => 'Perizinan',
            'bsps' => 'BSPS',
            'rumah_susun' => 'Rumah Susun',
            'rumah_khusus' => 'Rumah Khusus',
            'pembiayaan_perumahan' => 'Pembiayaan Perumahan (FLPP & SBUM)',
            'bantuan_permukiman' => 'Bantuan Permukiman',
            'kpp_kur_perumahan' => 'KPP/KUR Perumahan',
            'pelayanan_publik' => 'Pelayanan Publik',
            'lain_lain' => 'Lain-lain',
        ];

        if ($this->jenis_permohonan_informasi === 'lain_lain' && $this->jenis_permohonan_lainnya) {
            return 'Lain-lain: ' . $this->jenis_permohonan_lainnya;
        }

        return $labels[$this->jenis_permohonan_informasi] ?? '-';
    }

    /**
     * Get status informasi label
     */
    public function getStatusInformasiLabelAttribute()
    {
        return match($this->status_informasi) {
            'ya' => 'Ya',
            'dibawah_penguasaan' => 'Di Bawah Penguasaan',
            'tidak_dibawah_penguasaan' => 'Tidak Di Bawah Penguasaan',
            'belum_didokumentasikan' => 'Belum Didokumentasikan',
            default => '-',
        };
    }

    /**
     * Get bentuk informasi label
     */
    public function getBentukInformasiLabelAttribute()
    {
        return match($this->bentuk_informasi) {
            'softcopy' => 'Softcopy',
            'hardcopy' => 'Hardcopy',
            'softcopy_hardcopy' => 'Softcopy & Hardcopy',
            default => '-',
        };
    }

    /**
     * Get jenis permintaan label
     */
    public function getJenisPermintaanLabelAttribute()
    {
        return match($this->jenis_permintaan) {
            'melihat_mengetahui' => 'Melihat/Mengetahui',
            'meminta_salinan' => 'Meminta Salinan',
            'melihat_dan_salinan' => 'Melihat/Mengetahui & Meminta Salinan',
            default => '-',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'perlu_verifikasi' => 'warning',
            'diproses' => 'info',
            'ditunda' => 'secondary',
            'dikabulkan_seluruhnya' => 'success',
            'dikabulkan_sebagian' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status label (Admin View)
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'perlu_verifikasi' => 'Perlu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'ditunda' => 'Ditunda',
            'dikabulkan_seluruhnya' => 'Dikabulkan Seluruhnya',
            'dikabulkan_sebagian' => 'Dikabulkan Sebagian',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Get status label for public/user view
     */
    public function getStatusLabelPublicAttribute()
    {
        return match($this->status) {
            'perlu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'ditunda' => 'Ditunda',
            'dikabulkan_seluruhnya' => 'Disetujui',
            'dikabulkan_sebagian' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Scope queries
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePerluVerifikasi($query)
    {
        return $query->where('status', 'perlu_verifikasi');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeDitunda($query)
    {
        return $query->where('status', 'ditunda');
    }

    public function scopeDikabulkanSeluruhnya($query)
    {
        return $query->where('status', 'dikabulkan_seluruhnya');
    }

    public function scopeDikabulkanSebagian($query)
    {
        return $query->where('status', 'dikabulkan_sebagian');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope untuk permohonan yang masih aktif (belum selesai)
     */
    public function scopeAktif($query)
    {
        return $query->whereNull('tanggal_selesai');
    }

    /**
     * Scope untuk permohonan yang urgent (H9-H10)
     */
    public function scopeUrgent($query)
    {
        return $query->whereNull('tanggal_selesai')
            ->where('created_at', '<=', Carbon::now()->subDays(8));
    }

    /**
     * Relasi ke Keberatan
     */
    public function keberatan()
    {
        return $this->hasMany(Keberatan::class, 'permohonan_id');
    }

    /**
     * Cek apakah ada keberatan yang masih aktif (pending atau diproses)
     */
    public function hasActiveKeberatan(): bool
    {
        return $this->keberatan()
            ->whereIn('status', ['pending', 'diproses'])
            ->exists();
    }

    /**
     * Get keberatan aktif (pending atau diproses)
     */
    public function getActiveKeberatan()
    {
        return $this->keberatan()
            ->whereIn('status', ['pending', 'diproses'])
            ->orderBy('created_at', 'desc')
            ->first();
    }
}