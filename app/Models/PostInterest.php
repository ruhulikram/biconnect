<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostInterest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Manually handle created_at since timestamps is false.
     */
    protected static function booted(): void
    {
        static::creating(function (PostInterest $interest) {
            $interest->created_at = $interest->created_at ?? now();
        });
    }

    // ─── Relationships ───────────────────────────────────────

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
