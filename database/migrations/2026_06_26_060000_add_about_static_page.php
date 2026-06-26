<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = config('about.page');

        DB::table('pages')->updateOrInsert(
            ['key' => 'about'],
            [
                'title' => $defaults['title'],
                'slug' => '/about-anmol-goel',
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        DB::table('pages')->where('key', 'about')->delete();
    }
};
