<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('halaman_statis', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // informasi-berkala, informasi-setiap-saat
            $table->string('judul');
            $table->text('konten'); // JSON format untuk menyimpan list items
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('halaman_statis');
    }
};