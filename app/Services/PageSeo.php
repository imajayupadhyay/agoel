<?php

namespace App\Services;

use App\Models\Industry;
use App\Models\Page;
use App\Models\SeoSetting;

class PageSeo
{
    public function schema(Page $page): array
    {
        if ($page->schema_override_enabled && $page->schema_markup) {
            return json_decode($page->schema_markup, true, 512, JSON_THROW_ON_ERROR);
        }

        return $this->defaultSchema($page);
    }

    public function defaultSchemaJson(Page $page): string
    {
        return json_encode(
            $this->defaultSchema($page),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
    }

    public function canonical(Page $page): string
    {
        return $page->canonical_url ?: $this->pageUrl($page);
    }

    public function robots(Page $page): string
    {
        return implode(', ', [
            $page->robots_index ? 'index' : 'noindex',
            $page->robots_follow ? 'follow' : 'nofollow',
            'max-image-preview:large',
        ]);
    }

    private function defaultSchema(Page $page): array
    {
        $siteName = SeoSetting::current()->site_name;
        $url = $this->pageUrl($page);
        $base = [
            '@context' => 'https://schema.org',
            '@type' => $page->key === 'industries' ? 'CollectionPage' : 'WebPage',
            '@id' => $url.'#webpage',
            'url' => $url,
            'name' => $page->seo_title,
            'description' => $page->meta_description,
            'inLanguage' => 'en-IN',
            'isPartOf' => [
                '@type' => 'WebSite',
                '@id' => route('home').'#website',
                'url' => route('home'),
                'name' => $siteName,
            ],
            'about' => [
                '@type' => 'Person',
                '@id' => route('home').'#person',
                'name' => 'Anmol Pushjai Goel',
                'url' => route('home'),
            ],
        ];

        if ($page->key === 'home') {
            return [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'WebSite',
                        '@id' => route('home').'#website',
                        'url' => route('home'),
                        'name' => $siteName,
                        'inLanguage' => 'en-IN',
                    ],
                    [
                        ...$base,
                        '@type' => 'ProfilePage',
                        'mainEntity' => [
                            '@type' => 'Person',
                            '@id' => route('home').'#person',
                            'name' => 'Anmol Pushjai Goel',
                            'url' => route('home'),
                            'jobTitle' => 'Founder & CEO, Nuclear Edge',
                            'worksFor' => [
                                '@type' => 'Organization',
                                'name' => 'Nuclear Edge',
                            ],
                        ],
                    ],
                ],
            ];
        }

        if ($page->key === 'industries') {
            $base['hasPart'] = Industry::query()
                ->where('is_enabled', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Industry $industry) => [
                    '@type' => 'Article',
                    'headline' => $industry->name,
                    'description' => trim($industry->body_before.' '.$industry->body_accent.' '.$industry->body_after),
                    'url' => route('industries').'#ind-'.$industry->slug,
                ])
                ->values()
                ->all();
        }

        return $base;
    }

    private function pageUrl(Page $page): string
    {
        return match ($page->key) {
            'home' => route('home'),
            'industries' => route('industries'),
            'philanthropy' => route('philanthropy'),
            default => url($page->slug),
        };
    }
}
