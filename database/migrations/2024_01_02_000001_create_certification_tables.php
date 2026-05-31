<?php
// database/migrations/2024_01_02_000001_create_certification_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certification_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('badge_label', 60)->nullable();
            $table->string('badge_icon', 60)->default('verified');
            $table->string('accent_color', 80)->default('bg-primary');
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // custom index name
            $table->index(
                ['is_active', 'order'],
                'cert_cat_active_order_idx'
            );
        });

        Schema::create('certification_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('certification_category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code', 80)->nullable();
            $table->string('issuer')->nullable();
            $table->string('level', 60)->nullable();
            $table->string('duration', 60)->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();

            $table->json('modules')->nullable();
            $table->json('requirements')->nullable();
            $table->json('topics')->nullable();
            $table->json('schedule_info')->nullable();

            $table->string('badge_label', 60)->nullable();
            $table->string('badge_color', 80)->default('bg-blue-500');
            $table->string('icon', 60)->default('workspace_premium');

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->unsignedSmallInteger('order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // custom index names
            $table->index(
                ['certification_category_id', 'is_active', 'order'],
                'cert_items_cat_active_order_idx'
            );

            $table->index(
                ['is_active', 'is_featured'],
                'cert_items_active_featured_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_items');
        Schema::dropIfExists('certification_categories');
    }
};