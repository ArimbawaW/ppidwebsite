<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keberatan', function (Blueprint $table) {
            // Hapus kolom lama yang tidak diperlukan
            if (Schema::hasColumn('keberatan', 'ktp_path')) {
                $table->dropColumn('ktp_path');
            }
            if (Schema::hasColumn('keberatan', 'surat_keberatan_path')) {
                $table->dropColumn('surat_keberatan_path');
            }
            
            // Tambah kolom baru
            $table->string('nomor_registrasi_permohonan')->after('nomor_registrasi');
            $table->string('alamat')->after('email');
            $table->string('pekerjaan')->after('alamat');
            $table->string('kartu_identitas')->after('pekerjaan'); // path file
            $table->text('informasi_diminta')->after('kartu_identitas');
            $table->text('tujuan_penggunaan')->after('informasi_diminta');
            $table->string('kategori_keberatan')->after('tujuan_penggunaan');
            $table->text('uraian_keberatan')->after('kategori_keberatan');
            $table->string('file_pengajuan')->nullable()->after('uraian_keberatan');
            
            // Hapus kolom 'alasan_keberatan' jika ada (diganti dengan uraian_keberatan)
            if (Schema::hasColumn('keberatan', 'alasan_keberatan')) {
                $table->dropColumn('alasan_keberatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('keberatan', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_registrasi_permohonan',
                'alamat',
                'pekerjaan',
                'kartu_identitas',
                'informasi_diminta',
                'tujuan_penggunaan',
                'kategori_keberatan',
                'uraian_keberatan',
                'file_pengajuan'
            ]);
        });
    }
};