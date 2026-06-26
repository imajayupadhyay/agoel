<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResearchPublication extends Model
{
    protected $fillable = [
        'research_category_id',
        'title',
        'venue',
        'year',
        'status',
        'summary',
        'tags',
        'url',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
            'year' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResearchCategory::class, 'research_category_id');
    }
}
