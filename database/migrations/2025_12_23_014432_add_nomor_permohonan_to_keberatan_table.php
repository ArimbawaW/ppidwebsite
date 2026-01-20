<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keberatan', function (Blueprint $table) {
            // Tambah nomor permohonan yang menjadi dasar keberatan
            $table->string('nomor_permohonan')->after('nomor_registrasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('keberatan', function (Blueprint $table) {
            $table->dropColumn('nomor_permohonan');
        });
    }
};