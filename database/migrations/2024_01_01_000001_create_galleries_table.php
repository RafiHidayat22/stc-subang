<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();

            // Teks keterangan foto yang tampil di overlay
            $table->string('caption', 255);

            // Path ke storage (relatif dari disk 'public'), contoh: gallery/abc.jpg
            $table->string('image');

            // Opsional: kategori untuk filter (mis. "K3", "Welding", "Automotive")
            $table->string('category', 100)->nullable()->index();

            // Kontrol tampil / sembunyikan
            $table->boolean('is_active')->default(true)->index();

            // Urutan tampil (semakin kecil = lebih awal)
            $table->unsignedSmallInteger('order')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};