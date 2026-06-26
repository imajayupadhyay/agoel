<?php

namespace App\Services;

use App\Models\PageSection;

class AboutSchema
{
    public function forSection(PageSection $section): array
    {
        return config("about.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
