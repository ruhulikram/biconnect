<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoHub extends Model
{
    protected $table = 'info_hub';

    protected $fillable = [
        'title',
        'poster_image',
        'poster_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
