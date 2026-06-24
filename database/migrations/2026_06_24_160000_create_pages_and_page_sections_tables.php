<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('seo_title');
            $table->text('meta_description');
            $table->string('og_image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->string('name');
            $table->string('type');
            $table->json('content');
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_custom')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['page_id', 'key']);
            $table->index(['page_id', 'is_enabled', 'sort_order']);
        });

        $now = now();
        $defaults = config('homepage.page');

        $pageId = DB::table('pages')->insertGetId([
            'key' => 'home',
            'title' => $defaults['title'],
            'slug' => '/',
            'seo_title' => $defaults['seo_title'],
            'meta_description' => $defaults['meta_description'],
            'og_image' => $defaults['og_image'],
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        foreach (config('homepage.sections') as $key => $section) {
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
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
    }
};
