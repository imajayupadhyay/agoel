<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->updateOrInsert(
            ['key' => 'books'],
            [
                'title' => 'Books',
                'slug' => '/books',
                'seo_title' => 'The Library — Anmol Pushjai Goel',
                'meta_description' => 'The personal library & reading manifesto of Anmol Pushjai Goel — annual reading lists from 2022, an A–Z shelf, and book reviews.',
                'canonical_url' => null,
                'og_image' => 'images/books/hero-library.jpg',
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
        DB::table('pages')->where('key', 'books')->delete();
    }
};
