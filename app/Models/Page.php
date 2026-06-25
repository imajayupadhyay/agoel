<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'key',
        'title',
        'slug',
        'seo_title',
        'meta_description',
        'canonical_url',
        'og_image',
        'robots_index',
        'robots_follow',
        'schema_override_enabled',
        'schema_markup',
        'sitemap_included',
        'sitemap_change_frequency',
        'sitemap_priority',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'schema_override_enabled' => 'boolean',
            'sitemap_included' => 'boolean',
            'sitemap_priority' => 'decimal:1',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }
}
