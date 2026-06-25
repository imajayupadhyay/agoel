<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\SeoFiles;
use Illuminate\Http\Response;

class SeoFilesController extends Controller
{
    public function sitemap(SeoFiles $files): Response
    {
        return response($files->sitemap(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function robots(SeoFiles $files): Response
    {
        return response($files->robots(), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
