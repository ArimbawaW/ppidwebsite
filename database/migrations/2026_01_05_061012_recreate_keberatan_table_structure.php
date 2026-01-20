<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop tabel lama jika ada (hati-hati dengan data!)
        Schema::dropIfExists('keberatan');
        
        // Buat tabel baru dengan struktur yang benar
        Schema::create('keberatan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi')->unique();
            
            // Relasi ke Permohonan
            $table->string('nomor_registrasi_permohonan');
            $table->unsignedBigInteger('permohonan_id')->nullable();
            $table->foreign('permohonan_id')->references('id')->on('permohonan')->onDelete('set null');
            
            // Data Pemohon
            $table->string('nama_pemohon');
            $table->text('alamat');
            $table->string('nomor_kontak', 20);
            $table->string('pekerjaan');
            
            // File Upload
            $table->string('kartu_identitas_path'); // KTP/KK/SIM/Paspor
            
            // Informasi yang Diminta
            $table->text('informasi_diminta');
            $table->text('tujuan_penggunaan');
            
            // Alasan Keberatan (Pasal 35 ayat 1)
            $table->enum('alasan_keberatan', [
                'penolakan_pasal_17',
                'tidak_disediakan_berkala',
                'tidak_ditanggapi',
                'tidak_sesuai_permintaan',
                'tidak_dipenuhi',
                'biaya_tidak_wajar',
                'melebihi_jangka_waktu'
            ]);
            
            // Uraian Keberatan
            $table->text('uraian_keberatan');
            
            // Status & Keterangan
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keberatan');
    }
};