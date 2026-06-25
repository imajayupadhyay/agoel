<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tag',
        'body_before',
        'body_accent',
        'body_after',
        'pull_quote',
        'facts',
        'image',
        'image_alt',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'facts' => 'array',
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
