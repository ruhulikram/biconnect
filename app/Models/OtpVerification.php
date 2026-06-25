<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Manually handle created_at since timestamps is false.
     */
    protected static function booted(): void
    {
        static::creating(function (OtpVerification $otp) {
            $otp->created_at = $otp->created_at ?? now();
        });
    }

    // ─── Scopes ──────────────────────────────────────────────

    /**
     * Only OTPs that haven't expired and haven't been used.
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                     ->whereNull('used_at');
    }
}
