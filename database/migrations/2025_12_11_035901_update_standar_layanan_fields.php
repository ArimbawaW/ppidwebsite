<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            if (!Schema::hasColumn('standar_layanan', 'jenis_layanan')) {
                $table->string('jenis_layanan')->after('nama_layanan');
            }

            if (!Schema::hasColumn('standar_layanan', 'persyaratan')) {
                $table->text('persyaratan')->nullable()->after('deskripsi');
            }

            if (!Schema::hasColumn('standar_layanan', 'prosedur')) {
                $table->text('prosedur')->nullable()->after('persyaratan');
            }

            if (!Schema::hasColumn('standar_layanan', 'waktu_penyelesaian')) {
                $table->string('waktu_penyelesaian')->nullable()->after('prosedur');
            }

            if (!Schema::hasColumn('standar_layanan', 'biaya')) {
                $table->integer('biaya')->nullable()->after('waktu_penyelesaian');
            }

            if (!Schema::hasColumn('standar_layanan', 'produk_layanan')) {
                $table->string('produk_layanan')->nullable()->after('biaya');
            }
        });
    }

    public function down()
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_layanan',
                'persyaratan',
                'prosedur',
                'waktu_penyelesaian',
                'biaya',
                'produk_layanan',
            ]);
        });
    }
};
