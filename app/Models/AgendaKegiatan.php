<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AgendaKegiatan extends Model
{
    use HasFactory;

    protected $table = 'agenda_kegiatan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'penyelenggara',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Accessor untuk format tanggal Indonesia
    public function getTanggalFormatAttribute(): string
    {
        return Carbon::parse($this->tanggal)->locale('id')->isoFormat('D MMMM YYYY');
    }

    // Accessor untuk hari
    public function getHariAttribute(): string
    {
        return Carbon::parse($this->tanggal)->locale('id')->isoFormat('dddd');
    }

    // Accessor untuk tanggal singkat (3 Juli)
    public function getTanggalSingkatAttribute(): string
    {
        return Carbon::parse($this->tanggal)->locale('id')->isoFormat('D MMMM');
    }

    // Scope untuk agenda aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk agenda upcoming (mendatang)
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString())
                     ->orderBy('tanggal', 'asc');
    }

    // Scope untuk agenda bulan ini
    public function scopeBulanIni($query)
    {
        return $query->whereYear('tanggal', now()->year)
                     ->whereMonth('tanggal', now()->month);
    }
}