<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->updateOrInsert(
            ['key' => 'news'],
            [
                'title' => 'In the News',
                'slug' => '/in-the-news',
                'seo_title' => 'In the News — Anmol Pushjai Goel',
                'meta_description' => 'Anmol Pushjai Goel in News — featured across The Tribune, The Wire, ThePrint, Business Standard, Wisconsin Journal and more.',
                'canonical_url' => null,
                'og_image' => 'images/news/nuclear-edge-office.jpg',
                'robots_index' => true,
                'robots_follow' => true,
                'schema_override_enabled' => false,
                'schema_markup' => null,
                'sitemap_included' => true,
                'sitemap_change_frequency' => 'monthly',
                'sitemap_priority' => 0.7,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        DB::table('pages')->where('key', 'news')->delete();
    }
};
