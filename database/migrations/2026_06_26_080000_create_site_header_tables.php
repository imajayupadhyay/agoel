<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_header_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('brand_mark', 8)->default('A');
            $table->string('brand_name')->default('Anmol Pushjai Goel');
            $table->string('brand_url', 2048)->default('/');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('site_header_nav_items', function (Blueprint $table): void {
            $table->id();
            $table->string('label', 120);
            $table->string('url', 2048);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('opens_new_tab')->default(false);
            $table->timestamps();
        });

        $now = now();

        DB::table('site_header_settings')->insert([
            'brand_mark' => 'A',
            'brand_name' => 'Anmol Pushjai Goel',
            'brand_url' => '/',
            'is_enabled' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        foreach ([
            ['label' => 'Industries', 'url' => '/industries', 'sort_order' => 10],
            ['label' => 'Philanthropy', 'url' => '/philanthropy', 'sort_order' => 20],
            ['label' => 'In the News', 'url' => '/in-the-news', 'sort_order' => 30],
            ['label' => 'Books', 'url' => '/books', 'sort_order' => 40],
            ['label' => 'Research & Publications', 'url' => '/research-publications', 'sort_order' => 50],
            ['label' => 'About Anmol Goel', 'url' => '/about-anmol-goel', 'sort_order' => 60],
        ] as $item) {
            DB::table('site_header_nav_items')->insert([
                ...$item,
                'is_enabled' => true,
                'opens_new_tab' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_header_nav_items');
        Schema::dropIfExists('site_header_settings');
    }
};
