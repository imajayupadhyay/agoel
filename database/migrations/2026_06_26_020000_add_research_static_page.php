<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->updateOrInsert(
            ['key' => 'research'],
            [
                'title' => 'Research & Publications',
                'slug' => '/research-publications',
                'seo_title' => 'Research & Publications — Anmol Pushjai Goel',
                'meta_description' => 'Research, articles, essays and recommended studies by Anmol Pushjai Goel.',
                'canonical_url' => null,
                'og_image' => 'images/research/research-hero-collage.jpg',
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
        DB::table('pages')->where('key', 'research')->delete();
    }
};
