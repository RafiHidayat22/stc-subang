<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int         $id
 * @property string      $name
 * @property string      $email
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $subject
 * @property string      $message
 * @property string      $ip_address
 * @property string|null $user_agent
 * @property string      $status        unread | read | replied | spam
 * @property string|null $replied_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Contact extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'replied_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants – subject labels
    |--------------------------------------------------------------------------
    */
    public const SUBJECT_LABELS = [
        'daftar_pelatihan' => 'Pendaftaran Training',
        'konsultasi_karir' => 'Info Sertifikasi BNSP',
        'kerjasama'        => 'Inhouse Training / Corporate',
        'informasi_umum'   => 'Informasi Umum',
    ];

    public const STATUS_UNREAD  = 'unread';
    public const STATUS_READ    = 'read';
    public const STATUS_REPLIED = 'replied';
    public const STATUS_SPAM    = 'spam';

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Human-readable subject label.
     */
    public function getSubjectLabelAttribute(): string
    {
        return self::SUBJECT_LABELS[$this->subject] ?? 'Informasi Umum';
    }

    /**
     * Whether this message has been read.
     */
    public function getIsReadAttribute(): bool
    {
        return $this->status !== self::STATUS_UNREAD;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_UNREAD);
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_READ);
    }

    public function scopeReplied(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_REPLIED);
    }

    public function scopeSpam(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SPAM);
    }

    public function scopeBySubject(Builder $query, string $subject): Builder
    {
        return $query->where('subject', $subject);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Mark this message as read.
     */
    public function markAsRead(): static
    {
        $this->update(['status' => self::STATUS_READ]);
        return $this;
    }

    /**
     * Mark this message as replied.
     */
    public function markAsReplied(): static
    {
        $this->update([
            'status'     => self::STATUS_REPLIED,
            'replied_at' => now(),
        ]);
        return $this;
    }

    /**
     * Mark this message as spam.
     */
    public function markAsSpam(): static
    {
        $this->update(['status' => self::STATUS_SPAM]);
        return $this;
    }
}