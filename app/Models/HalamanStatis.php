<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalamanStatis extends Model
{
    use HasFactory;

    protected $table = 'halaman_statis';

    protected $fillable = [
        'slug',
        'judul',
        'konten',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'konten' => 'array',
        ];
    }
}