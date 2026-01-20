<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HalamanStatis;

class HalamanStatisSeeder extends Seeder
{
    public function run()
    {
        // Contoh halaman: Informasi Berkala
        HalamanStatis::create([
            'slug' => 'informasi-berkala',
            'judul' => 'Informasi Publik yang Wajib Disediakan dan Diumumkan Secara Berkala',
            'konten' => [
                [
                    'section' => 'A. Informasi tentang Kementerian Perumahan dan Kawasan Permukiman',
                    'items' => [
                        ['text' => 'Alamat Lengkap', 'file_url' => null],
                        ['text' => 'Ruang Lingkup (Kewenangan)', 'file_url' => null],
                        ['text' => 'Tugas & Fungsi serta Kantor Unit dibawahnya', 'file_url' => null],
                        ['text' => 'Struktur Organisasi', 'file_url' => null],
                    ]
                ],
                [
                    'section' => 'B. Laporan Harta Kekayaan Penyelenggara Negara (LHKPN)',
                    'items' => [
                        ['text' => 'Menteri PKP', 'file_url' => null],
                        ['text' => 'Wakil Menteri PKP', 'file_url' => null],
                        ['text' => 'Sekretaris Jenderal', 'file_url' => null],
                        ['text' => 'Inspektur Jenderal', 'file_url' => null],
                        ['text' => 'Direktru Jenderal Kawasan Permukiman', 'file_url' => null],
                        ['text' => 'Direktur Jenderal Perumahan Perdesaan', 'file_url' => null],
                        ['text' => 'Direktur Jenderal Perumahan Perkotaan', 'file_url' => null],
                        ['text' => 'Direktur Jenderal Tata Kelola & Pengendalian Risiko', 'file_url' => null],
                    ]
                ],
            ],
            'is_active' => true,
        ]);
    }
}