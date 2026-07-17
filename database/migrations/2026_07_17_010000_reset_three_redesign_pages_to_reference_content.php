<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $resetPage = function (string $key, string $slug, string $configKey, float $priority) use ($now): int {
            $defaults = config("{$configKey}.page");

            DB::table('pages')->updateOrInsert(
                ['key' => $key],
                [
                    'title' => $defaults['title'],
                    'slug' => $slug,
                    'seo_title' => $defaults['seo_title'],
                    'meta_description' => $defaults['meta_description'],
                    'canonical_url' => null,
                    'og_image' => $defaults['og_image'],
                    'robots_index' => true,
                    'robots_follow' => true,
                    'schema_override_enabled' => false,
                    'schema_markup' => null,
                    'sitemap_included' => true,
                    'sitemap_change_frequency' => 'monthly',
                    'sitemap_priority' => $priority,
                    'is_published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );

            $pageId = (int) DB::table('pages')->where('key', $key)->value('id');
            $sectionKeys = array_keys(config("{$configKey}.sections"));

            DB::table('page_sections')
                ->where('page_id', $pageId)
                ->whereNotIn('key', $sectionKeys)
                ->update([
                    'is_enabled' => false,
                    'updated_at' => $now,
                ]);

            foreach (config("{$configKey}.sections") as $sectionKey => $section) {
                DB::table('page_sections')->updateOrInsert(
                    [
                        'page_id' => $pageId,
                        'key' => $sectionKey,
                    ],
                    [
                        'name' => $section['name'],
                        'type' => $section['type'],
                        'content' => json_encode($section['content'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'is_enabled' => ! (bool) ($section['admin_hidden'] ?? false),
                        'is_custom' => false,
                        'sort_order' => $section['sort_order'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                );
            }

            return $pageId;
        };

        $resetPage('home', '/', 'homepage', 1.0);
        $resetPage('industries', '/industries', 'industries', 0.8);
        $resetPage('philanthropy', '/philanthropy', 'philanthropy', 0.8);

        DB::table('industries')->update([
            'is_enabled' => false,
            'updated_at' => $now,
        ]);

        foreach (config('industries.items') as $index => $industry) {
            $slug = Str::slug($industry['name']);

            DB::table('industries')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $industry['name'],
                    'tag' => $industry['tag'],
                    'body_before' => $industry['body_before'],
                    'body_accent' => $industry['body_accent'],
                    'body_after' => $industry['body_after'],
                    'pull_quote' => $industry['pull_quote'],
                    'facts' => json_encode($industry['facts'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'image' => $industry['image'],
                    'image_alt' => $industry['image_alt'],
                    'is_enabled' => true,
                    'sort_order' => ($index + 1) * 10,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }

    public function down(): void
    {
        //
    }
};
