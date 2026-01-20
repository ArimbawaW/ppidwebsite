<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StandarLayanan extends Model
{
    protected $table = 'standar_layanan';
    
    protected $fillable = [
        'nama_layanan',      // ← INI yang dipakai di database Anda
        'jenis_layanan',
        'slug',
        'gambar',
        'deskripsi',
        'konten',
        'persyaratan',
        'prosedur',
        'waktu_penyelesaian',
        'biaya',
        'produk_layanan',
        'file',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            if (empty($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama_layanan ?? 'layanan-' . time());
            }
        });

        static::updating(function ($layanan) {
            if ($layanan->isDirty('nama_layanan') && empty($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama_layanan);
            }
        });
    }
}