<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_category_id')
                  ->nullable()
                  ->constrained('article_categories')
                  ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');           // Short summary shown on index/cards
            $table->longText('body');          // Full HTML content (sanitised before output)

            $table->string('thumbnail')->nullable();   // Storage path for card image
            $table->string('featured_image')->nullable(); // Storage path for detail hero image

            $table->string('author_name')->default('Redaksi STC Indonesia');
            $table->string('author_role')->default('Industrial Specialist & Trainer');

            $table->json('tags')->nullable();  // e.g. ["#BNSP","#SafetyFirst"]

            $table->boolean('is_featured')->default(false); // Shown as hero card on index
            $table->boolean('is_published')->default(false);

            $table->unsignedInteger('views')->default(0);

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['is_published', 'published_at']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};