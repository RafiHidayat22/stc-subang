<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color', 'sort_order'];

    // ── Relations ──────────────────────────────────────────────────────────

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /**
     * Count published articles in this category.
     */
    public function publishedArticlesCount(): int
    {
        return $this->articles()->published()->count();
    }

    // ── Route model binding ────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}