<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',           // Nama kategori, e.g. "BNSP", "KEMNAKER"
        'slug',           // URL slug, e.g. "bnsp", "kemnaker"
        'description',    // Deskripsi singkat kategori
        'logo',           // Path logo (storage)
        'badge_label',    // Label badge, e.g. "BNSP", "Regulasi"
        'badge_icon',     // Material Symbol icon name untuk badge
        'accent_color',   // Tailwind class, e.g. "bg-primary", "bg-safety-orange"
        'cover_image',    // Path gambar cover (storage)
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function items()
    {
        return $this->hasMany(CertificationItem::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}