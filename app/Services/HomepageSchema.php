<?php

namespace App\Services;

use App\Models\PageSection;

class HomepageSchema
{
    public function forSection(PageSection $section): array
    {
        if ($section->is_custom) {
            return config('homepage.custom_section');
        }

        return config("homepage.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
