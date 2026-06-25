<?php

namespace App\Services;

use App\Models\PageSection;

class IndustriesSchema
{
    public function forSection(PageSection $section): array
    {
        return config("industries.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
