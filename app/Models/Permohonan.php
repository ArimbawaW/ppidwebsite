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
    ];

    protected $casts = [
        'persetujuan_terms' => 'boolean',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // TIDAK ADA relasi user() karena sistem publik

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