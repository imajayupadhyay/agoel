<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = config('books.page');

        DB::table('pages')->updateOrInsert(
            ['key' => 'books'],
            [
                'title' => $defaults['title'],
                'slug' => '/books',
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

        $pageId = DB::table('pages')->where('key', 'books')->value('id');

        foreach (config('books.sections') as $key => $section) {
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
        $pageId = DB::table('pages')->where('key', 'books')->value('id');

        if ($pageId) {
            DB::table('page_sections')->where('page_id', $pageId)->delete();
        }
    }
};
