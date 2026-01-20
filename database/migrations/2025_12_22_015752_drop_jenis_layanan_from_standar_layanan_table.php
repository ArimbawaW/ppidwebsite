<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            if (Schema::hasColumn('standar_layanan', 'jenis_layanan')) {
                $table->dropColumn('jenis_layanan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            $table->string('jenis_layanan')->nullable();
        });
    }
};
