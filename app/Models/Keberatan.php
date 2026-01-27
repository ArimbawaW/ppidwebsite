<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keberatan extends Model
{
    use HasFactory;

    protected $table = 'keberatan';

   protected $fillable = [
    'nomor_registrasi',
    'nomor_registrasi_permohonan',
    'permohonan_id',
    'nama_pemohon',
    'alamat',
    'nomor_kontak',
    'email', 
    'pekerjaan',
    'kartu_identitas_path',
    'informasi_diminta',
    'tujuan_penggunaan',
    'alasan_keberatan',
    'uraian_keberatan',
    'status',
    'keterangan',
];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relasi ke Permohonan
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    // Generate Nomor Registrasi
    public static function generateNomorRegistrasi(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastKeberatan = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastKeberatan ? (int) substr($lastKeberatan->nomor_registrasi, -4) + 1 : 1;
        return 'KEB-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Accessor untuk Label Alasan Keberatan
    public function getAlasanKeberatanLabelAttribute(): string
    {
        $labels = [
            'penolakan_pasal_17' => 'a. Penolakan Berdasarkan alasan sebagaimana dimaksud dalam Pasal 17 UU KIP',
            'tidak_disediakan_berkala' => 'b. Tidak disediakan informasi berkala',
            'tidak_ditanggapi' => 'c. Tidak ditanggapinya permintaan informasi',
            'tidak_sesuai_permintaan' => 'd. Permintaan informasi tidak ditanggapi sebagaimana yang diminta',
            'tidak_dipenuhi' => 'e. Tidak dipenuhinya permintaan informasi',
            'biaya_tidak_wajar' => 'f. Pengenaan biaya yang tidak wajar',
            'melebihi_jangka_waktu' => 'g. Penyampaian informasi yang melebihi jangka waktu yang diatur dalam UU KIP',
        ];

        return $labels[$this->alasan_keberatan] ?? $this->alasan_keberatan;
    }

    // Accessor untuk Label Status
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }
}