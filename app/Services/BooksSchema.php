<?php

namespace App\Services;

use App\Models\PageSection;

class BooksSchema
{
    public function forSection(PageSection $section): array
    {
        return config("books.sections.{$section->key}", [
            'name' => $section->name,
            'type' => $section->type,
            'fields' => [],
        ]);
    }
}
