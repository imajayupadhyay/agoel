<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidSitemapXml;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeoSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:160'],
            'robots_override_enabled' => ['nullable', 'boolean'],
            'robots_content' => [
                Rule::requiredIf($this->boolean('robots_override_enabled')),
                'nullable',
                'string',
                'max:50000',
            ],
            'sitemap_override_enabled' => ['nullable', 'boolean'],
            'sitemap_content' => [
                Rule::requiredIf($this->boolean('sitemap_override_enabled')),
                'nullable',
                'string',
                'max:1000000',
                new ValidSitemapXml,
            ],
        ];
    }
}
