<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateHeaderRequest;
use App\Models\SiteHeaderNavItem;
use App\Models\SiteHeaderSetting;
use App\Services\SiteHeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HeaderController extends Controller
{
    public function edit(SiteHeader $header): View
    {
        return view('admin.header.edit', [
            'settings' => $header->settings(),
            'items' => $header->allItems(),
        ]);
    }

    public function update(UpdateHeaderRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $settings = SiteHeaderSetting::current();
            $settingsData = $request->validated('settings');

            $settings->update([
                'brand_mark' => $this->clean($settingsData['brand_mark']),
                'brand_name' => $this->clean($settingsData['brand_name']),
                'brand_url' => $this->clean($settingsData['brand_url']),
                'is_enabled' => $request->boolean('settings.is_enabled'),
            ]);

            $submittedIds = [];

            foreach ($request->validated('nav_items', []) as $index => $itemData) {
                $id = $itemData['id'] ?? null;
                $attributes = [
                    'label' => $this->clean($itemData['label']),
                    'url' => $this->clean($itemData['url']),
                    'sort_order' => (int) ($itemData['sort_order'] ?? (($index + 1) * 10)),
                    'is_enabled' => (bool) ($itemData['is_enabled'] ?? false),
                    'opens_new_tab' => (bool) ($itemData['opens_new_tab'] ?? false),
                ];

                if ($id) {
                    $item = SiteHeaderNavItem::query()->findOrFail($id);
                    $item->update($attributes);
                    $submittedIds[] = $item->id;

                    continue;
                }

                $item = SiteHeaderNavItem::query()->create($attributes);
                $submittedIds[] = $item->id;
            }

            SiteHeaderNavItem::query()
                ->when($submittedIds !== [], fn ($query) => $query->whereNotIn('id', $submittedIds))
                ->delete();
        });

        return back()->with('status', 'Header updated successfully.');
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
    }
}
