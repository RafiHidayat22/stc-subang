<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'certification_category_id',
        'name',           // Nama sertifikasi, e.g. "Basic Electrical Training"
        'slug',           // URL slug
        'code',           // Kode program, e.g. "BNSP-001"
        'issuer',         // Lembaga penerbit, e.g. "BNSP"
        'level',          // Level: Operator, Teknisi, Profesional, Spesialis, Internasional
        'duration',       // Durasi, e.g. "4 Hari"
        'description',    // Deskripsi panjang
        'thumbnail',      // Path thumbnail (storage)
        'cover_image',    // Path gambar cover (storage)
        'modules',        // JSON array of {icon, title, description}
        'requirements',   // JSON array of string persyaratan
        'schedule_info',  // JSON {batch, date, location}
        'badge_label',    // e.g. "BNSP", "Kemnaker"
        'badge_color',    // Tailwind bg class, e.g. "bg-blue-500"
        'icon',           // Material Symbol icon
        'topics',         // JSON array of string topik singkat
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'modules'      => 'array',
        'requirements' => 'array',
        'topics'       => 'array',
        'schedule_info'=> 'array',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(CertificationCategory::class, 'certification_category_id');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}