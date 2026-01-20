<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('regulasi', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('nomor')->nullable();
        $table->text('deskripsi')->nullable();
        $table->string('file')->nullable();
        $table->string('kategori')->nullable(); // UU, PP, Permen, dll
        $table->date('tanggal_terbit')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
};
