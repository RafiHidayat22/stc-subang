<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_contacts_table
 *
 * Menyimpan semua pesan masuk dari form kontak website STC Indonesia.
 *
 * Cara pakai:
 *   php artisan migrate
 *
 * Rollback:
 *   php artisan migrate:rollback
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {

            $table->id();

            // ── Pengirim ────────────────────────────────────────────────
            $table->string('name',    100);
            $table->string('email',   150)->index();
            $table->string('phone',    20)->nullable();
            $table->string('company', 150)->nullable();

            // ── Isi pesan ────────────────────────────────────────────────
            $table->enum('subject', [
                'daftar_pelatihan',
                'konsultasi_karir',
                'kerjasama',
                'informasi_umum',
            ])->nullable()->default('informasi_umum');

            $table->text('message');        // max 2000 chars, validated at app layer

            // ── Status workflow ──────────────────────────────────────────
            $table->enum('status', [
                'unread',
                'read',
                'replied',
                'spam',
            ])->default('unread')->index();

            $table->timestamp('replied_at')->nullable();

            // ── Security / audit ─────────────────────────────────────────
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 512)->nullable();

            $table->timestamps();   // created_at = waktu kirim, updated_at = waktu status berubah

            // ── Composite index untuk admin listing (status + date) ───────
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};