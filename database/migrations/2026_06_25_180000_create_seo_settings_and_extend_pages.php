<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('meta_description');
            $table->boolean('robots_index')->default(true)->after('og_image');
            $table->boolean('robots_follow')->default(true)->after('robots_index');
            $table->boolean('schema_override_enabled')->default(false)->after('robots_follow');
            $table->longText('schema_markup')->nullable()->after('schema_override_enabled');
            $table->boolean('sitemap_included')->default(true)->after('schema_markup');
            $table->string('sitemap_change_frequency', 20)->default('monthly')->after('sitemap_included');
            $table->decimal('sitemap_priority', 2, 1)->default(0.8)->after('sitemap_change_frequency');
        });

        DB::table('pages')->where('key', 'home')->update(['sitemap_priority' => 1.0]);

        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Anmol Pushjai Goel');
            $table->boolean('robots_override_enabled')->default(false);
            $table->text('robots_content')->nullable();
            $table->boolean('sitemap_override_enabled')->default(false);
            $table->longText('sitemap_content')->nullable();
            $table->timestamps();
        });

        DB::table('seo_settings')->insert([
            'site_name' => 'Anmol Pushjai Goel',
            'robots_override_enabled' => false,
            'robots_content' => null,
            'sitemap_override_enabled' => false,
            'sitemap_content' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'canonical_url',
                'robots_index',
                'robots_follow',
                'schema_override_enabled',
                'schema_markup',
                'sitemap_included',
                'sitemap_change_frequency',
                'sitemap_priority',
            ]);
        });
    }
};
