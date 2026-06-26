<?php

namespace App\Services;

use App\Models\SiteHeaderNavItem;
use App\Models\SiteHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SiteHeader
{
    public function settings(): SiteHeaderSetting
    {
        return SiteHeaderSetting::current();
    }

    public function enabledItems(): Collection
    {
        return SiteHeaderNavItem::query()
            ->where('is_enabled', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function allItems(): Collection
    {
        return SiteHeaderNavItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function isActive(SiteHeaderNavItem $item, Request $request): bool
    {
        $url = trim($item->url);

        if ($url === '' || $url === '#') {
            return false;
        }

        $path = parse_url($url, PHP_URL_PATH) ?: $url;

        if (! str_starts_with($path, '/')) {
            return false;
        }

        $currentPath = '/'.trim($request->path(), '/');
        $itemPath = rtrim($path, '/') ?: '/';

        return $currentPath === $itemPath;
    }

    public function isExternal(string $url): bool
    {
        return (bool) filter_var($url, FILTER_VALIDATE_URL);
    }

    public function href(string $url): string
    {
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return url($url);
        }

        return $url;
    }
}
