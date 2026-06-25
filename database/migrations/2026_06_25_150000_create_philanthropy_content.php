<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = config('philanthropy.page');

        $pageId = DB::table('pages')->insertGetId([
            'key' => 'philanthropy',
            'title' => $defaults['title'],
            'slug' => '/philanthropy',
            'seo_title' => $defaults['seo_title'],
            'meta_description' => $defaults['meta_description'],
            'og_image' => $defaults['og_image'],
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        foreach (config('philanthropy.sections') as $key => $section) {
            DB::table('page_sections')->insert([
                'page_id' => $pageId,
                'key' => $key,
                'name' => $section['name'],
                'type' => $section['type'],
                'content' => json_encode($section['content'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'is_enabled' => true,
                'is_custom' => false,
                'sort_order' => $section['sort_order'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('pages')->where('key', 'philanthropy')->delete();
    }
};
