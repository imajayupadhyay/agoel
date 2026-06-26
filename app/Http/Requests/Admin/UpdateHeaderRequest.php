<?php

namespace App\Http\Requests\Admin;

use App\Rules\SafeContentLink;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHeaderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'settings' => ['required', 'array'],
            'settings.brand_mark' => ['required', 'string', 'max:8'],
            'settings.brand_name' => ['required', 'string', 'max:160'],
            'settings.brand_url' => ['required', 'string', 'max:2048', new SafeContentLink],
            'settings.is_enabled' => ['nullable', 'boolean'],
            'nav_items' => ['nullable', 'array', 'max:40'],
            'nav_items.*.id' => ['nullable', 'integer', 'exists:site_header_nav_items,id'],
            'nav_items.*.label' => ['required', 'string', 'max:120'],
            'nav_items.*.url' => ['required', 'string', 'max:2048', new SafeContentLink],
            'nav_items.*.sort_order' => ['required', 'integer', 'min:0', 'max:10000'],
            'nav_items.*.is_enabled' => ['nullable', 'boolean'],
            'nav_items.*.opens_new_tab' => ['nullable', 'boolean'],
        ];
    }
}
