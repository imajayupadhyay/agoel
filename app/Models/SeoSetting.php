<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'site_name',
        'robots_override_enabled',
        'robots_content',
        'sitemap_override_enabled',
        'sitemap_content',
    ];

    protected function casts(): array
    {
        return [
            'robots_override_enabled' => 'boolean',
            'sitemap_override_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => 'Anmol Pushjai Goel',
        ]);
    }
}
