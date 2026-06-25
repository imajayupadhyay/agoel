<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSeoSettingsRequest;
use App\Models\SeoSetting;
use App\Services\SeoFiles;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoSettingsController extends Controller
{
    public function edit(SeoFiles $files): View
    {
        return view('admin.seo.edit', [
            'settings' => SeoSetting::current(),
            'defaultRobots' => $files->defaultRobots(),
            'defaultSitemap' => $files->defaultSitemap(),
        ]);
    }

    public function update(UpdateSeoSettingsRequest $request): RedirectResponse
    {
        SeoSetting::current()->update([
            'site_name' => trim(strip_tags($request->validated('site_name'))),
            'robots_override_enabled' => $request->boolean('robots_override_enabled'),
            'robots_content' => $request->validated('robots_content'),
            'sitemap_override_enabled' => $request->boolean('sitemap_override_enabled'),
            'sitemap_content' => $request->validated('sitemap_content'),
        ]);

        return back()->with('status', 'Global SEO settings updated successfully.');
    }
}
