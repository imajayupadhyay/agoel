<?php

if (! function_exists('asset_version')) {
    /**
     * Return an asset URL with a cache-busting query string.
     *
     * The version is derived from the file's last-modified time so that a new
     * deploy (fresh checkout) invalidates browser/CDN caches automatically.
     * Falls back to the plain URL if the file is missing.
     */
    function asset_version(string $path): string
    {
        $url = asset($path);
        $full = public_path($path);

        if (! is_file($full)) {
            return $url;
        }

        return $url.(str_contains($url, '?') ? '&' : '?').'v='.filemtime($full);
    }
}
