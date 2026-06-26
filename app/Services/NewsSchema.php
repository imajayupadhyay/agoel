<?php

namespace App\Services;

use App\Models\PageSection;

class NewsSchema
{
    public function forSection(PageSection $section): array
    {
        return config("news.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
