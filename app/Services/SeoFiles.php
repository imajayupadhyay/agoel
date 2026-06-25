<?php

namespace App\Services;

use App\Models\Page;
use App\Models\SeoSetting;
use Illuminate\Support\Str;

class SeoFiles
{
    public function robots(): string
    {
        $settings = SeoSetting::current();

        if ($settings->robots_override_enabled && filled($settings->robots_content)) {
            return Str::finish(trim($settings->robots_content), "\n");
        }

        return $this->defaultRobots();
    }

    public function sitemap(): string
    {
        $settings = SeoSetting::current();

        if ($settings->sitemap_override_enabled && filled($settings->sitemap_content)) {
            return trim($settings->sitemap_content)."\n";
        }

        return $this->defaultSitemap();
    }

    public function defaultRobots(): string
    {
        return "User-agent: *\nAllow: /\nDisallow: /sanchalak\nSitemap: ".route('sitemap')."\n";
    }

    public function defaultSitemap(): string
    {
        $pages = Page::query()
            ->where('is_published', true)
            ->where('sitemap_included', true)
            ->orderByDesc('sitemap_priority')
            ->orderBy('id')
            ->get();

        return view('sitemap', ['pages' => $pages])->render();
    }
}
