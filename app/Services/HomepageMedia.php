<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HomepageMedia
{
    public function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    public function store(UploadedFile $file, string $sectionKey): string
    {
        return $file->store("pages/home/{$sectionKey}", 'public');
    }

    public function deleteManaged(?string $path): void
    {
        if (! $path || str_starts_with($path, 'images/') || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
