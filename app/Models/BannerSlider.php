<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer'
    ];

    /**
     * Scope untuk hanya mengambil banner aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk sorting berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get banner aktif yang sudah diurutkan
     */
    public static function getActiveBanners()
    {
        return self::active()->ordered()->get();
    }
}