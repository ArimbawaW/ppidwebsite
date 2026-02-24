<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel sesuai dengan database Anda
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'published_at', // Kolom baru ditambahkan di sini
        'gambar',
        'kategori',
        'is_published',
        'views',
        'user_id',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'views' => 'integer',
            'published_at' => 'datetime', // Casting ke datetime agar mudah dimanipulasi dengan Carbon
        ];
    }

    /**
     * Boot function untuk menghandle slug otomatis.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            // Update slug jika judul berubah dan slug tidak diisi manual
            if ($berita->isDirty('judul') && $berita->isDirty('slug') === false) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    /**
     * Relasi ke User (Penulis).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Method untuk menambah jumlah view.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Accessor untuk label kategori yang lebih rapi.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'berita' => 'Berita',
            'artikel' => 'Artikel',
            'pengumuman' => 'Pengumuman',
            default => $this->kategori,
        };
    }

    /**
     * Scope untuk mengambil berita yang sudah layak terbit 
     * (is_published true DAN tanggal publikasi sudah lewat/saat ini)
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }
}