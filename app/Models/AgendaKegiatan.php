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

    // ========== ACCESSOR STATUS DINAMIS ==========
    
    /**
     * Accessor untuk status dinamis berdasarkan tanggal
     * Status akan otomatis berubah sesuai tanggal saat ini
     */
    public function getStatusDinamisAttribute(): string
    {
        $now = now()->startOfDay();
        $tanggal = $this->tanggal->startOfDay();
        
        if ($tanggal->isFuture()) {
            return 'upcoming';
        } elseif ($tanggal->isToday()) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }

    /**
     * Accessor untuk text badge status
     * Mengembalikan text yang user-friendly
     */
    public function getStatusBadgeAttribute(): string
    {
        $status = $this->status_dinamis;
        
        return match($status) {
            'upcoming' => 'Akan Datang',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Accessor untuk class badge Bootstrap
     * Mengembalikan class CSS sesuai status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        $status = $this->status_dinamis;
        
        return match($status) {
            'upcoming' => 'bg-primary',
            'ongoing' => 'bg-success',
            'completed' => 'bg-secondary',
            default => 'bg-dark'
        };
    }
}