<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResearchCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'label',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function publications(): HasMany
    {
        return $this->hasMany(ResearchPublication::class);
    }
}
