<?php

namespace App\Services;

use App\Models\PageSection;

class ResearchSchema
{
    public function forSection(PageSection $section): array
    {
        return config("research.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
