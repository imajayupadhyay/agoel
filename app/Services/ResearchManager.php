<?php

namespace App\Services;

use App\Http\Requests\Admin\UpdateResearchRequest;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\ResearchPublication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResearchManager
{
    public function __construct(
        private readonly ResearchSchema $schema,
        private readonly ResearchMedia $media,
    ) {}

    public function update(Page $page, UpdateResearchRequest $request): void
    {
        DB::transaction(function () use ($page, $request): void {
            $this->updatePage($page, $request);
            $this->updateSections($page, $request);
            $this->updatePublications($request);
        });
    }

    private function updatePage(Page $page, UpdateResearchRequest $request): void
    {
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
            'canonical_url' => $this->cleanNullable($pageData['canonical_url'] ?? null),
            'og_image' => $ogImage,
            'robots_index' => $request->boolean('page.robots_index'),
            'robots_follow' => $request->boolean('page.robots_follow'),
            'schema_override_enabled' => $request->boolean('page.schema_override_enabled'),
            'schema_markup' => $request->boolean('page.schema_override_enabled')
                ? $this->jsonNullable($pageData['schema_markup'] ?? null)
                : null,
            'sitemap_included' => $request->boolean('page.sitemap_included'),
            'sitemap_change_frequency' => $pageData['sitemap_change_frequency'],
            'sitemap_priority' => $pageData['sitemap_priority'],
            'is_published' => $request->boolean('page.is_published'),
        ]);
    }

    private function updateSections(Page $page, UpdateResearchRequest $request): void
    {
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
    }

    private function updatePublications(UpdateResearchRequest $request): void
    {
        $publications = ResearchPublication::query()->get()->keyBy('id');

        foreach ($request->validated('publications', []) as $publicationId => $submitted) {
            $publication = $publications->get((int) $publicationId);

            if (! $publication) {
                continue;
            }

            $publication->update([
                'research_category_id' => (int) $submitted['research_category_id'],
                'title' => $this->clean($submitted['title']),
                'venue' => $this->cleanNullable($submitted['venue'] ?? null),
                'year' => filled($submitted['year'] ?? null) ? (int) $submitted['year'] : null,
                'status' => $this->cleanNullable($submitted['status'] ?? null),
                'summary' => $this->cleanNullable($submitted['summary'] ?? null),
                'url' => $this->cleanNullable($submitted['url'] ?? null),
                'tags' => $this->cleanTags($submitted['tags'] ?? []),
                'is_enabled' => (bool) ($submitted['is_enabled'] ?? false),
                'sort_order' => (int) ($submitted['sort_order'] ?? $publication->sort_order),
            ]);
        }
    }

    private function processSectionImage(
        UpdateResearchRequest $request,
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
        UpdateResearchRequest $request,
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

    private function cleanTags(array $tags): array
    {
        return collect($tags)
            ->map(fn ($tag) => is_string($tag) ? $this->clean($tag) : null)
            ->filter()
            ->values()
            ->all();
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function cleanNullable(?string $value): ?string
    {
        $value = $value === null ? null : $this->clean($value);

        return $value === '' ? null : $value;
    }

    private function jsonNullable(?string $value): ?string
    {
        if (! filled($value)) {
            return null;
        }

        return json_encode(
            json_decode($value, true, 512, JSON_THROW_ON_ERROR),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
    }
}
