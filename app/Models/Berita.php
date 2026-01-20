<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'kategori',
        'is_published',
        'views',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'views' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'berita' => 'Berita',
            'artikel' => 'Artikel',
            'pengumuman' => 'Pengumuman',
            default => $this->kategori,
        };
    }
}

