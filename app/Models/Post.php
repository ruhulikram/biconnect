<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'image',
        'deadline',
        'campus_area',
        'project_type',
        'is_active',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline'  => 'date',
            'is_active' => 'boolean',
            'status'    => 'string',
        ];
    }

    // ─── Relationships ───────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'post_skills');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function interests(): HasMany
    {
        return $this->hasMany(PostInterest::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDiscussion($query)
    {
        return $query->where('type', 'discussion');
    }

    public function scopeProject($query)
    {
        return $query->where('type', 'project');
    }
}
