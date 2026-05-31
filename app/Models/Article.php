<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
        'article_category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'thumbnail',
        'featured_image',
        'author_name',
        'author_role',
        'tags',
        'is_featured',
        'is_published',
        'views',
        'published_at',
    ];

    protected $casts = [
        'tags'         => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // ── Relations ──────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ── Accessors ──────────────────────────────────────────────────────────

    /**
     * URL of the card thumbnail, with fallback to a placeholder.
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? Storage::url($this->thumbnail)
            : asset('images/placeholder-article.jpg');
    }

    /**
     * URL of the detail hero image, falling back to thumbnail.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }

        return $this->thumbnail_url;
    }

    /**
     * Human-readable published date, e.g. "12 Oktober 2024".
     */
    public function getPublishedDateAttribute(): string
    {
        if (! $this->published_at) {
            return '';
        }

        // Use Carbon's locale-aware formatting (requires Carbon locale set to id).
        return $this->published_at->translatedFormat('d F Y');
    }

    /**
     * Author initials for the avatar circle (up to 2 chars).
     */
    public function getAuthorInitialsAttribute(): string
    {
        $words = explode(' ', $this->author_name);

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($this->author_name, 0, 2));
    }

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    // ── Route model binding ────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}