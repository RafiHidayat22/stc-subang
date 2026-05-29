<?php
// app/Models/ProgramCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'description_long',
        'thumbnail',
        'icon',                   // Material Symbol name
        'duration',               // e.g. "1-12 Hari"
        'certification_body',     // e.g. "BNSP"
        'target_participant',
        'price_display',          // e.g. "Rp 3.500.000"
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Scopes ───────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Relations ────────────────────────────────────────────────────

    public function programs()
    {
        return $this->hasMany(Program::class, 'category_id');
    }

    // ─── Route model binding ──────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
