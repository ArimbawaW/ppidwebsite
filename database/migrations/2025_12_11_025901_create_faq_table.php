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
    Schema::create('faq', function (Blueprint $table) {
        $table->id();
        $table->string('pertanyaan');
        $table->text('jawaban');
        $table->string('kategori')->nullable();
        $table->integer('urutan')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
};
