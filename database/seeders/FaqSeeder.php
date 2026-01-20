<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'kategori' => 'Umum',
                'pertanyaan' => 'Apa itu PPID?',
                'jawaban' => 'PPID (Pejabat Pengelola Informasi dan Dokumentasi) adalah pejabat yang bertanggung jawab dalam pengelolaan dan pelayanan informasi publik.',
                'urutan' => 1,
            ],
            [
                'kategori' => 'Permohonan Informasi',
                'pertanyaan' => 'Bagaimana cara mengajukan permohonan informasi?',
                'jawaban' => 'Anda dapat mengajukan permohonan informasi melalui form online di website ini, atau datang langsung ke kantor PPID dengan membawa KTP.',
                'urutan' => 1,
            ],
            [
                'kategori' => 'Permohonan Informasi',
                'pertanyaan' => 'Berapa lama waktu yang dibutuhkan untuk mendapatkan informasi?',
                'jawaban' => 'Sesuai UU KIP, PPID wajib memberikan tanggapan paling lambat 10 hari kerja sejak permohonan diterima.',
                'urutan' => 2,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}