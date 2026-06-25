<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Supported platforms with display names and icon names.
     */
    public static function platforms(): array
    {
        return [
            'linkedin'  => 'LinkedIn',
            'github'    => 'GitHub',
            'instagram' => 'Instagram',
            'twitter'   => 'Twitter / X',
            'website'   => 'Website',
        ];
    }
}
