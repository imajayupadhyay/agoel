<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = config('homepage.page');

        $page = DB::table('pages')->where('key', 'home')->first();

        if (! $page) {
            DB::table('pages')->insert([
                'key' => 'home',
                'title' => $defaults['title'],
                'slug' => '/',
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
                'sitemap_priority' => 1.0,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $pageId = DB::table('pages')->where('key', 'home')->value('id');

        foreach (config('homepage.sections') as $key => $section) {
            $isHiddenLegacySection = (bool) ($section['admin_hidden'] ?? false);
            $existing = DB::table('page_sections')
                ->where('page_id', $pageId)
                ->where('key', $key)
                ->first();

            if (! $existing) {
                DB::table('page_sections')->insert([
                    'page_id' => $pageId,
                    'key' => $key,
                    'name' => $section['name'],
                    'type' => $section['type'],
                    'content' => json_encode($section['content'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'is_enabled' => ! $isHiddenLegacySection,
                    'is_custom' => false,
                    'sort_order' => $section['sort_order'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                continue;
            }

            $existingContent = json_decode($existing->content, true) ?: [];
            $content = array_replace_recursive($section['content'], $existingContent);

            DB::table('page_sections')
                ->where('id', $existing->id)
                ->update([
                    'name' => $section['name'],
                    'type' => $section['type'],
                    'content' => json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'is_enabled' => $isHiddenLegacySection ? false : $existing->is_enabled,
                    'is_custom' => false,
                    'sort_order' => $section['sort_order'],
                    'updated_at' => $now,
                ]);
        }
    }

    public function down(): void
    {
        //
    }
};
