<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop tabel lama jika ada
        Schema::dropIfExists('permohonan');
        
        // Buat ulang dengan struktur lengkap
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi')->unique();
            $table->enum('kategori_pemohon', ['perorangan', 'kelompok', 'badan_hukum']);
            
            // Data Pemohon
            $table->string('nama');
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email');
            
            // Rincian Permohonan
            $table->text('rincian_informasi');
            $table->text('tujuan_penggunaan');
            $table->boolean('persetujuan_terms')->default(true);
            
            // Untuk Perorangan
            $table->string('jenis_identitas')->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->string('file_identitas_path')->nullable();
            
            // Untuk Kelompok
            $table->string('nomor_ktp_pemberi_kuasa')->nullable();
            $table->string('file_surat_kuasa_path')->nullable();
            $table->string('file_ktp_pemberi_kuasa_path')->nullable();
            
            // Untuk Badan Hukum
            $table->string('nomor_akta_ahu')->nullable();
            $table->string('file_akta_ahu_path')->nullable();
            $table->string('file_ad_art_path')->nullable();
            
            // Status
            $table->string('status')->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('nomor_registrasi');
            $table->index('kategori_pemohon');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};