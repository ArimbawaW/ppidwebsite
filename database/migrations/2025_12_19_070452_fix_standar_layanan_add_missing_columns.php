<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            // Tambahkan kolom TANPA constraint AFTER (lebih aman)
            
            if (!Schema::hasColumn('standar_layanan', 'slug')) {
                $table->string('slug')->nullable();
            }
            
            if (!Schema::hasColumn('standar_layanan', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            
            if (!Schema::hasColumn('standar_layanan', 'konten')) {
                $table->text('konten')->nullable();
            }
        });
        
        // Auto-generate slug untuk data existing
        $items = DB::table('standar_layanan')->get();
        foreach ($items as $item) {
            $slugBase = $item->judul ?? $item->nama_layanan ?? 'layanan';
            $slug = Str::slug($slugBase) ?: 'layanan-' . $item->id;
            
            DB::table('standar_layanan')
                ->where('id', $item->id)
                ->update(['slug' => $slug]);
        }
        
        // Buat slug unique setelah semua terisi
        Schema::table('standar_layanan', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('standar_layanan', function (Blueprint $table) {
            if (Schema::hasColumn('standar_layanan', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            
            if (Schema::hasColumn('standar_layanan', 'gambar')) {
                $table->dropColumn('gambar');
            }
            
            if (Schema::hasColumn('standar_layanan', 'konten')) {
                $table->dropColumn('konten');
            }
        });
    }
};