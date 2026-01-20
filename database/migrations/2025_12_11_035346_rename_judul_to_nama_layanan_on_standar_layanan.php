<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            $table->renameColumn('judul', 'nama_layanan');
        });
    }

    public function down()
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            $table->renameColumn('nama_layanan', 'judul');
        });
    }
};
