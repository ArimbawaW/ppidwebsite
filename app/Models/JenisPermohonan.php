<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPermohonan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenis_permohonan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all permohonan for this jenis permohonan.
     */
    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'jenis_permohonan_id');
    }

    /**
     * Scope untuk jenis permohonan yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}