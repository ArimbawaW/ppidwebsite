<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $table = 'informasi_publik';

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'file_path',
        'link_download',
        'is_active',
        'download_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'download_count' => 'integer',
        ];
    }

    public function incrementDownload()
    {
        $this->increment('download_count');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'informasi_berkala' => 'Informasi Secara Berkala',
            'informasi_setiap_saat' => 'Informasi Setiap Saat',
            'informasi_serta_merta' => 'Informasi Serta-Merta',
            'informasi_dikecualikan' => 'Informasi Dikecualikan',
            default => $this->kategori,
        };
    }
}

