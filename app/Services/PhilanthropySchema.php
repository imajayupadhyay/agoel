<?php

namespace App\Services;

use App\Models\PageSection;

class PhilanthropySchema
{
    public function forSection(PageSection $section): array
    {
        return config("philanthropy.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
