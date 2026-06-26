<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = config('news.page');

        DB::table('pages')->updateOrInsert(
            ['key' => 'news'],
            [
                'title' => $defaults['title'],
                'slug' => '/in-the-news',
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
                'sitemap_priority' => 0.7,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        $pageId = DB::table('pages')->where('key', 'news')->value('id');

        foreach (config('news.sections') as $key => $section) {
            DB::table('page_sections')->updateOrInsert(
                ['page_id' => $pageId, 'key' => $key],
                [
                    'name' => $section['name'],
                    'type' => $section['type'],
                    'content' => json_encode($section['content'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'is_enabled' => true,
                    'is_custom' => false,
                    'sort_order' => $section['sort_order'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }

    public function down(): void
    {
        $pageId = DB::table('pages')->where('key', 'news')->value('id');

        if ($pageId) {
            DB::table('page_sections')->where('page_id', $pageId)->delete();
        }
    }
};
