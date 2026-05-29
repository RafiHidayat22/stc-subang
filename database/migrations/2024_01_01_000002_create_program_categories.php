<?php
// database/migrations/2024_01_01_000002_create_program_categories_and_update_programs.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── program_categories ───────────────────────────────────────
        Schema::create('program_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_long')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('icon', 60)->default('category');        // Material Symbol name
            $table->string('duration', 80)->nullable();             // e.g. "1-12 Hari"
            $table->string('certification_body', 120)->nullable();  // e.g. "BNSP"
            $table->string('target_participant')->nullable();
            $table->string('price_display', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });

        // ── Alter programs table (add new columns) ───────────────────
        Schema::table('programs', function (Blueprint $table) {
            // Add after 'id'
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('program_categories')
                  ->nullOnDelete();

            $table->text('description_long')->nullable()->after('description');
            $table->json('learning_outcomes')->nullable()->after('modules');
            $table->json('target_participants')->nullable()->after('learning_outcomes');
            $table->string('duration', 80)->nullable()->after('target_participants');
            $table->string('level', 60)->nullable()->after('duration');
            $table->string('price_display', 80)->nullable()->after('level');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'category_id',
                'description_long',
                'learning_outcomes',
                'target_participants',
                'duration',
                'level',
                'price_display',
            ]);
        });

        Schema::dropIfExists('program_categories');
    }
};
