<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk menyimpan log kunjungan
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45); // Support IPv4 & IPv6
            $table->text('user_agent')->nullable();
            $table->string('page_visited')->nullable();
            $table->timestamp('visited_at');
            
            // Index untuk performa
            $table->index('ip_address');
            $table->index('visited_at');
        });

        // Tabel untuk menyimpan statistik harian (opsional, untuk performa)
        Schema::create('visitor_stats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total_visitors')->default(0);
            $table->date('date')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_stats');
        Schema::dropIfExists('visitors');
    }
};