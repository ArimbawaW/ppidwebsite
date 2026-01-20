<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            if (!Schema::hasColumn('permohonan', 'nomor_registrasi')) {
                $table->string('nomor_registrasi')->nullable()->unique()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            if (Schema::hasColumn('permohonan', 'nomor_registrasi')) {
                $table->dropColumn('nomor_registrasi');
            }
        });
    }
};