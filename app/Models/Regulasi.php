<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    protected $table = 'regulasi';
    
    protected $fillable = [
        'judul',
        'nomor',
        'deskripsi',
        'file',
        'kategori',
        'tanggal_terbit',
        'is_active',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Daftar kategori regulasi yang tersedia
     */
    public static function getKategoriList()
    {
        return [
            'Undang-Undang',
            'Peraturan Pemerintah',
            'Peraturan Presiden',
            'Peraturan Menteri',
            'Peraturan Daerah',
            'Surat Edaran',
            'Keputusan',
            'Lainnya',
        ];
    }

    /**
     * Get badge color based on category
     */
    public function getKategoriBadgeColorAttribute()
    {
        return match($this->kategori) {
            'Undang-Undang' => 'bg-primary',
            'Peraturan Pemerintah' => 'bg-success',
            'Peraturan Presiden' => 'bg-danger',
            'Peraturan Menteri' => 'bg-info',
            'Peraturan Daerah' => 'bg-warning',
            'Keputusan' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}