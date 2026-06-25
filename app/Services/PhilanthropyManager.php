<?php

namespace App\Services;

use App\Http\Requests\Admin\UpdatePhilanthropyRequest;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PhilanthropyManager
{
    public function __construct(
        private readonly PhilanthropySchema $schema,
        private readonly PhilanthropyMedia $media,
    ) {}

    public function update(Page $page, UpdatePhilanthropyRequest $request): void
    {
        DB::transaction(function () use ($page, $request): void {
            $pageData = $request->validated('page');
            $ogImage = $page->og_image;

            if ($request->boolean('page.remove_og_image')) {
                $this->media->deleteManaged($ogImage);
                $ogImage = null;
            }

            if ($upload = $request->file('page.og_image_upload')) {
                $this->media->deleteManaged($ogImage);
                $ogImage = $this->media->store($upload, 'seo');
            }

            $page->update([
                'title' => $this->clean($pageData['title']),
                'seo_title' => $this->clean($pageData['seo_title']),
                'meta_description' => $this->clean($pageData['meta_description']),
                'og_image' => $ogImage,
                'is_published' => $request->boolean('page.is_published'),
            ]);

            $sections = $page->sections()->get()->keyBy('id');

            foreach ($request->validated('sections', []) as $sectionId => $submitted) {
                $section = $sections->get((int) $sectionId);

                if (! $section) {
                    continue;
                }

                $content = $section->content ?? [];
                $submittedContent = $submitted['content'] ?? [];

                foreach ($this->schema->forSection($section)['fields'] as $fieldName => $field) {
                    $content[$fieldName] = match ($field['type']) {
                        'image' => $this->processSectionImage(
                            $request,
                            $section,
                            $fieldName,
                            $content[$fieldName] ?? null,
                        ),
                        'repeater' => $this->processRepeater(
                            $request,
                            $section,
                            $fieldName,
                            $field,
                            $submittedContent[$fieldName] ?? [],
                            $content[$fieldName] ?? [],
                        ),
                        default => $this->cleanValue($submittedContent[$fieldName] ?? null),
                    };
                }

                $section->update([
                    'content' => $content,
                    'is_enabled' => (bool) ($submitted['is_enabled'] ?? false),
                    'sort_order' => (int) ($submitted['sort_order'] ?? $section->sort_order),
                ]);
            }
        });
    }

    private function processSectionImage(
        UpdatePhilanthropyRequest $request,
        PageSection $section,
        string $fieldName,
        ?string $existing,
    ): ?string {
        if ($request->boolean("sections.{$section->id}.remove_images.{$fieldName}")) {
            $this->media->deleteManaged($existing);
            $existing = null;
        }

        if ($upload = $request->file("sections.{$section->id}.uploads.{$fieldName}")) {
            $this->media->deleteManaged($existing);

            return $this->media->store($upload, $section->key);
        }

        return $existing;
    }

    private function processRepeater(
        UpdatePhilanthropyRequest $request,
        PageSection $section,
        string $fieldName,
        array $field,
        array $submittedItems,
        array $existingItems,
    ): array {
        $existingByKey = collect($existingItems)->keyBy('_key');
        $keptImagePaths = [];
        $items = [];

        foreach (array_values($submittedItems) as $index => $submittedItem) {
            $key = $submittedItem['_key'] ?? 'item-'.Str::uuid();
            $existingItem = $existingByKey->get($key, []);
            $item = ['_key' => $key];

            foreach ($field['fields'] as $itemFieldName => $itemField) {
                if ($itemField['type'] !== 'image') {
                    $item[$itemFieldName] = $this->cleanValue($submittedItem[$itemFieldName] ?? null);

                    continue;
                }

                $image = $existingItem[$itemFieldName] ?? null;
                $basePath = "sections.{$section->id}.content.{$fieldName}.{$index}";

                if ($request->boolean("{$basePath}.remove_{$itemFieldName}")) {
                    $this->media->deleteManaged($image);
                    $image = null;
                }

                if ($upload = $request->file("{$basePath}.{$itemFieldName}_upload")) {
                    $this->media->deleteManaged($image);
                    $image = $this->media->store($upload, $section->key);
                }

                if ($image) {
                    $keptImagePaths[] = $image;
                }

                $item[$itemFieldName] = $image;
            }

            $items[] = $item;
        }

        foreach ($existingItems as $existingItem) {
            foreach ($field['fields'] as $itemFieldName => $itemField) {
                if ($itemField['type'] !== 'image') {
                    continue;
                }

                $path = $existingItem[$itemFieldName] ?? null;

                if ($path && ! in_array($path, $keptImagePaths, true)) {
                    $this->media->deleteManaged($path);
                }
            }
        }

        return $items;
    }

    private function cleanValue(mixed $value): mixed
    {
        return is_string($value) ? $this->clean($value) : $value;
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
    }
}
