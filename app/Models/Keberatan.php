<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Keberatan extends Model
{
    use HasFactory;

    protected $table = 'keberatan';

    // ========================================
    // MASS ASSIGNMENT
    // ========================================
    protected $fillable = [
        // Identitas Registrasi
        'nomor_registrasi',
        'nomor_registrasi_permohonan',
        'permohonan_id',

        // Data Pemohon
        'nama_pemohon',
        'alamat',
        'nomor_kontak',
        'email',
        'pekerjaan',
        'kartu_identitas_path',

        // Substansi Keberatan
        'informasi_diminta',
        'tujuan_penggunaan',
        'alasan_keberatan',
        'uraian_keberatan',

        // Status & Proses
        'status',
        'keterangan',
        'tanggal_selesai',

        // Tanggapan & Proses Lanjutan
        'tanggapan_pemohon',
        'tanggapan_ppid',
        'tanggapan_atasan_ppid',
        'nomor_surat_tanggapan',
        'tanggal_surat_tanggapan',
        'nama_atasan_ppid',
        'jabatan_atasan_ppid',
        'keputusan_mediasi',
        'putusan_pengadilan',
    ];

    // ========================================
    // CASTING
    // ========================================
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'tanggal_surat_tanggapan' => 'date',
    ];

    // ========================================
    // KONSTANTA SLA
    // ========================================
    /**
     * Batas waktu keberatan (UU KIP): 30 hari kerja
     */
    const BATAS_WAKTU_HARI_KERJA = 30;

    // ========================================
    // AUTO NUMBERING - RANDOM FORMAT
    // ========================================
    /**
     * Format: KBR-YYYYMMDD-XXXXXX (Random 6 digit alphanumeric)
     * Contoh: KBR-20260206-A3F7K9
     */
    public static function generateNomorRegistrasi()
    {
        $tanggal = Carbon::now()->format('Ymd');
        $maxAttempts = 100;
        $attempt = 0;

        do {
            // Generate random 6 character alphanumeric (uppercase)
            $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
            $nomorRegistrasi = 'KBR-' . $tanggal . '-' . $randomCode;
            
            // Check if this number already exists
            $exists = self::where('nomor_registrasi', $nomorRegistrasi)->exists();
            
            $attempt++;
            
            if ($attempt >= $maxAttempts) {
                // Fallback: use timestamp-based unique code
                $randomCode = strtoupper(substr(md5(microtime()), 0, 6));
                $nomorRegistrasi = 'KBR-' . $tanggal . '-' . $randomCode;
                break;
            }
            
        } while ($exists);

        return $nomorRegistrasi;
    }

    /**
     * Safety auto-generate
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->nomor_registrasi) {
                $model->nomor_registrasi = self::generateNomorRegistrasi();
            }
        });
    }

    // ========================================
    // SLA & WAKTU
    // ========================================
    public function getSisaHariKerjaAttribute()
    {
        if ($this->tanggal_selesai) return 0;

        $hariKerjaTerpakai = $this->hitungHariKerja($this->created_at, Carbon::now());
        return max(0, self::BATAS_WAKTU_HARI_KERJA - $hariKerjaTerpakai);
    }

    public function getHariKerjaTerpakaiAttribute()
    {
        if ($this->tanggal_selesai) {
            return $this->hitungHariKerja($this->created_at, $this->tanggal_selesai);
        }

        return $this->hitungHariKerja($this->created_at, Carbon::now());
    }

    private function hitungHariKerja($tanggalAwal, $tanggalAkhir)
    {
        $awal = Carbon::parse($tanggalAwal);
        $akhir = Carbon::parse($tanggalAkhir);
        $hariKerja = 0;

        while ($awal->lte($akhir)) {
            if ($awal->dayOfWeek >= 1 && $awal->dayOfWeek <= 5) {
                $hariKerja++;
            }
            $awal->addDay();
        }

        return $hariKerja;
    }

    // ========================================
    // INDIKATOR SLA
    // ========================================
    public function getIndikatorWaktuAttribute()
    {
        // Cek jika status selesai, dikabulkan, atau ada tanggal_selesai
        if ($this->tanggal_selesai || in_array($this->status, ['selesai', 'dikabulkan'])) {
            return [
                'label' => 'Selesai',
                'warna' => 'success',
                'icon'  => 'check-circle',
                'sisa_hari' => 0,
                'hari_terpakai' => $this->hari_kerja_terpakai,
                'persentase' => 100,
            ];
        }

        $sisaHari = $this->sisa_hari_kerja;
        $hariTerpakai = $this->hari_kerja_terpakai;
        $persentase = min(100, ($hariTerpakai / self::BATAS_WAKTU_HARI_KERJA) * 100);

        if ($sisaHari >= 16) {
            $label = 'On Schedule'; $warna = 'success';
        } elseif ($sisaHari >= 9) {
            $label = 'Attention'; $warna = 'warning';
        } elseif ($sisaHari >= 0) {
            $label = 'Urgent'; $warna = 'danger';
        } else {
            $label = 'Terlambat'; $warna = 'danger';
        }

        return [
            'label' => $label,
            'warna' => $warna,
            'icon'  => in_array($label, ['On Schedule','Selesai']) ? 'check-circle' : 'exclamation-circle',
            'sisa_hari' => max(0, $sisaHari),
            'hari_terpakai' => $hariTerpakai,
            'persentase' => $persentase,
            'terlambat' => $sisaHari < 0,
            'hari_keterlambatan' => $sisaHari < 0 ? abs($sisaHari) : 0,
        ];
    }

    public function getIsUrgentAttribute()
    {
        return in_array($this->indikator_waktu['label'], ['Urgent', 'Terlambat']);
    }

    // ========================================
    // ACCESSORS
    // ========================================
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Verifikasi',
            'perlu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'ditunda' => 'Ditunda',
            'selesai' => 'Selesai',
            'dikabulkan' => 'Dikabulkan',
            'ditolak' => 'Ditolak',
        ];
        
        return isset($labels[$this->status]) ? $labels[$this->status] : 'Unknown';
    }

    public function getStatusLabelAdminAttribute()
    {
        $labels = [
            'pending' => 'Perlu Diverifikasi',
            'perlu_verifikasi' => 'Perlu Diverifikasi',
            'diproses' => 'Sedang Diproses',
            'ditunda' => 'Ditunda',
            'selesai' => 'Selesai',
            'dikabulkan' => 'Dikabulkan',
            'ditolak' => 'Ditolak',
        ];
        
        return isset($labels[$this->status]) ? $labels[$this->status] : 'Unknown';
    }

    public function getAlasanKeberatanLabelAttribute()
    {
        $labels = [
            'penolakan_pasal_17' => 'Penolakan Pasal 17 UU KIP',
            'tidak_disediakan_berkala' => 'Tidak Disediakan Secara Berkala',
            'tidak_ditanggapi' => 'Tidak Ditanggapi',
            'tidak_sesuai_permintaan' => 'Tidak Sesuai Permintaan',
            'tidak_dipenuhi' => 'Tidak Dipenuhi',
            'biaya_tidak_wajar' => 'Biaya Tidak Wajar',
            'melebihi_jangka_waktu' => 'Melebihi Jangka Waktu',
        ];
        
        return isset($labels[$this->alasan_keberatan]) ? $labels[$this->alasan_keberatan] : 'Tidak Diketahui';
    }

    // ========================================
    // RELASI
    // ========================================
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    // ========================================
    // SCOPES
    // ========================================
    public function scopePending($q)   { 
        return $q->whereIn('status', ['pending', 'perlu_verifikasi']); 
    }
    
    public function scopePerluVerifikasi($q) { 
        return $q->whereIn('status', ['pending', 'perlu_verifikasi']); 
    }
    
    public function scopeDiproses($q)  { return $q->where('status','diproses'); }
    public function scopeDikabulkan($q){ return $q->where('status','dikabulkan'); }
    public function scopeDitolak($q)   { return $q->where('status','ditolak'); }

    public function scopeAktif($q)
    {
        return $q->whereNull('tanggal_selesai');
    }

    public function scopeUrgent($q)
    {
        return $q->whereNull('tanggal_selesai')
                 ->where('created_at', '<=', Carbon::now()->subDays(22));
    }
}