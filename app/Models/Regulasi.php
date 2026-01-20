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
}