<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('research_categories')) {
            Schema::create('research_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('label');
                $table->boolean('is_enabled')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('research_publications')) {
            Schema::create('research_publications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('research_category_id')->constrained('research_categories')->restrictOnDelete();
                $table->string('title');
                $table->string('venue')->nullable();
                $table->unsignedSmallInteger('year')->nullable();
                $table->string('status')->nullable();
                $table->text('summary')->nullable();
                $table->json('tags')->nullable();
                $table->string('url', 2048)->nullable();
                $table->boolean('is_enabled')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();

                $table->index(['research_category_id', 'is_enabled', 'sort_order'], 'research_pub_cat_enabled_order_idx');
            });
        }

        $this->seedPage();
        $this->seedCategoriesAndPublications();
    }

    public function down(): void
    {
        Schema::dropIfExists('research_publications');
        Schema::dropIfExists('research_categories');

        $pageId = DB::table('pages')->where('key', 'research')->value('id');

        if ($pageId) {
            DB::table('page_sections')->where('page_id', $pageId)->delete();
        }
    }

    private function seedPage(): void
    {
        $now = now();
        $defaults = config('research.page');

        DB::table('pages')->updateOrInsert(
            ['key' => 'research'],
            [
                'title' => $defaults['title'],
                'slug' => '/research-publications',
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

        $pageId = DB::table('pages')->where('key', 'research')->value('id');

        foreach (config('research.sections') as $key => $section) {
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

    private function seedCategoriesAndPublications(): void
    {
        $now = now();
        $categoryIds = [];

        foreach (config('research.categories') as $category) {
            DB::table('research_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'label' => $category['label'],
                    'is_enabled' => true,
                    'sort_order' => $category['sort_order'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );

            $categoryIds[$category['slug']] = DB::table('research_categories')
                ->where('slug', $category['slug'])
                ->value('id');
        }

        foreach (config('research.publications') as $index => $publication) {
            $categoryId = $categoryIds[$publication['category']] ?? null;

            if (! $categoryId) {
                continue;
            }

            DB::table('research_publications')->updateOrInsert(
                ['title' => $publication['title'], 'research_category_id' => $categoryId],
                [
                    'venue' => $publication['venue'],
                    'year' => $publication['year'],
                    'status' => $publication['status'],
                    'summary' => $publication['summary'],
                    'tags' => json_encode($publication['tags'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'url' => $publication['url'],
                    'is_enabled' => true,
                    'sort_order' => ($index + 1) * 10,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }
};
