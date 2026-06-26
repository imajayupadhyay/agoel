<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteHeaderSetting extends Model
{
    protected $fillable = [
        'brand_mark',
        'brand_name',
        'brand_url',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return self::query()->firstOrCreate([], [
            'brand_mark' => 'A',
            'brand_name' => 'Anmol Pushjai Goel',
            'brand_url' => '/',
            'is_enabled' => true,
        ]);
    }
}
