<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tag');
            $table->text('body_before');
            $table->string('body_accent')->nullable();
            $table->text('body_after')->nullable();
            $table->text('pull_quote');
            $table->json('facts');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_enabled', 'sort_order']);
        });

        $now = now();
        $defaults = config('industries.page');

        $pageId = DB::table('pages')->insertGetId([
            'key' => 'industries',
            'title' => $defaults['title'],
            'slug' => '/industries',
            'seo_title' => $defaults['seo_title'],
            'meta_description' => $defaults['meta_description'],
            'og_image' => $defaults['og_image'],
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        foreach (config('industries.sections') as $key => $section) {
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

        foreach (config('industries.items') as $index => $industry) {
            DB::table('industries')->insert([
                ...$industry,
                'slug' => Str::slug($industry['name']),
                'facts' => json_encode($industry['facts'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'is_enabled' => true,
                'sort_order' => ($index + 1) * 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('pages')->where('key', 'industries')->delete();
        Schema::dropIfExists('industries');
    }
};
