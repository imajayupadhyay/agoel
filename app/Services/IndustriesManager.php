<?php

namespace App\Services;

use App\Http\Requests\Admin\UpdateIndustriesRequest;
use App\Models\Industry;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IndustriesManager
{
    public function __construct(
        private readonly IndustriesSchema $schema,
        private readonly IndustriesMedia $media,
    ) {}

    public function update(Page $page, UpdateIndustriesRequest $request): void
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

            $sections = $page->sections()->get()->keyBy('id');

            foreach ($request->validated('sections', []) as $sectionId => $submitted) {
                $section = $sections->get((int) $sectionId);

                if (! $section) {
                    continue;
                }

                $content = $section->content ?? [];
                $submittedContent = $submitted['content'] ?? [];

                foreach ($this->schema->forSection($section)['fields'] as $fieldName => $field) {
                    $content[$fieldName] = $field['type'] === 'image'
                        ? $this->processSectionImage($request, $section, $fieldName, $content[$fieldName] ?? null)
                        : $this->cleanValue($submittedContent[$fieldName] ?? null);
                }

                $section->update([
                    'content' => $content,
                    'is_enabled' => (bool) ($submitted['is_enabled'] ?? false),
                    'sort_order' => (int) ($submitted['sort_order'] ?? $section->sort_order),
                ]);
            }

            $industries = Industry::query()->get()->keyBy('id');

            foreach ($request->validated('industries', []) as $industryId => $submitted) {
                $industry = $industries->get((int) $industryId);

                if (! $industry) {
                    continue;
                }

                $image = $industry->image;

                if ($request->boolean("industries.{$industry->id}.remove_image")) {
                    $this->media->deleteManaged($image);
                    $image = null;
                }

                if ($upload = $request->file("industries.{$industry->id}.image_upload")) {
                    $this->media->deleteManaged($image);
                    $image = $this->media->store($upload, 'items');
                }

                $industry->update([
                    'name' => $this->clean($submitted['name']),
                    'slug' => $this->uniqueSlug($this->clean($submitted['name']), $industry),
                    'tag' => $this->clean($submitted['tag']),
                    'body_before' => $this->clean($submitted['body_before']),
                    'body_accent' => $this->cleanNullable($submitted['body_accent'] ?? null),
                    'body_after' => $this->cleanNullable($submitted['body_after'] ?? null),
                    'pull_quote' => $this->clean($submitted['pull_quote']),
                    'facts' => collect($submitted['facts'] ?? [])
                        ->map(fn ($fact) => $this->clean((string) $fact))
                        ->filter()
                        ->values()
                        ->all(),
                    'image' => $image,
                    'image_alt' => $this->cleanNullable($submitted['image_alt'] ?? null),
                    'is_enabled' => (bool) ($submitted['is_enabled'] ?? false),
                    'sort_order' => (int) $submitted['sort_order'],
                ]);
            }
        });
    }

    private function processSectionImage(
        UpdateIndustriesRequest $request,
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

    private function uniqueSlug(string $name, Industry $industry): string
    {
        $base = Str::slug($name) ?: 'industry';
        $slug = $base;
        $suffix = 2;

        while (Industry::query()->where('slug', $slug)->whereKeyNot($industry->id)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    private function cleanValue(mixed $value): mixed
    {
        if (is_string($value)) {
            return $this->clean($value);
        }

        if (is_array($value)) {
            return collect($value)->map(function ($item) {
                if (! is_array($item)) {
                    return $item;
                }

                return collect($item)
                    ->map(fn ($value) => is_string($value) ? $this->clean($value) : $value)
                    ->all();
            })->all();
        }

        return $value;
    }

    private function cleanNullable(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = $this->clean($value);

        return $value === '' ? null : $value;
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
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
