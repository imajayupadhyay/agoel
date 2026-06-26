<?php

namespace App\Http\Requests\Admin;

use App\Models\Page;
use App\Rules\SafeContentLink;
use App\Rules\ValidJsonLd;
use App\Services\BooksSchema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBooksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $rules = [
            'page' => ['required', 'array'],
            'page.title' => ['required', 'string', 'max:160'],
            'page.seo_title' => ['required', 'string', 'max:180'],
            'page.meta_description' => ['required', 'string', 'max:320'],
            'page.canonical_url' => ['nullable', 'url:http,https', 'max:2048'],
            'page.is_published' => ['nullable', 'boolean'],
            'page.robots_index' => ['nullable', 'boolean'],
            'page.robots_follow' => ['nullable', 'boolean'],
            'page.schema_override_enabled' => ['nullable', 'boolean'],
            'page.schema_markup' => [
                Rule::requiredIf($this->boolean('page.schema_override_enabled')),
                'nullable',
                'string',
                'max:100000',
                new ValidJsonLd,
            ],
            'page.sitemap_included' => ['nullable', 'boolean'],
            'page.sitemap_change_frequency' => ['required', Rule::in(['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])],
            'page.sitemap_priority' => ['required', 'numeric', 'min:0', 'max:1'],
            'page.og_image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'page.remove_og_image' => ['nullable', 'boolean'],
            'sections' => ['required', 'array'],
        ];

        $page = Page::query()->where('key', 'books')->with('sections')->first();

        if (! $page) {
            return $rules;
        }

        $schema = app(BooksSchema::class);

        foreach ($page->sections as $section) {
            $prefix = "sections.{$section->id}";
            $rules["{$prefix}.is_enabled"] = ['nullable', 'boolean'];
            $rules["{$prefix}.sort_order"] = ['required', 'integer', 'min:0', 'max:10000'];
            $rules["{$prefix}.content"] = ['required', 'array'];

            foreach ($schema->forSection($section)['fields'] as $fieldName => $field) {
                $this->addFieldRules($rules, "{$prefix}.content.{$fieldName}", $field);

                if ($field['type'] === 'image') {
                    $rules["{$prefix}.uploads.{$fieldName}"] = [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png,webp',
                        'max:8192',
                    ];
                    $rules["{$prefix}.remove_images.{$fieldName}"] = ['nullable', 'boolean'];
                }
            }
        }

        return $rules;
    }

    private function addFieldRules(array &$rules, string $path, array $field): void
    {
        $max = $field['max'] ?? 1000;

        $rules[$path] = match ($field['type']) {
            'text', 'textarea' => ['nullable', 'string', "max:{$max}"],
            'email' => ['nullable', 'email:rfc', "max:{$max}"],
            'link' => ['nullable', 'string', "max:{$max}", new SafeContentLink],
            'select' => ['nullable', Rule::in(array_keys($field['options']))],
            'image' => [],
            'repeater' => ['nullable', 'array', 'max:'.($field['max_items'] ?? 30)],
            default => ['nullable'],
        };

        if ($field['type'] !== 'repeater') {
            return;
        }

        $rules["{$path}.*._key"] = ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'];

        foreach ($field['fields'] as $itemFieldName => $itemField) {
            $itemPath = "{$path}.*.{$itemFieldName}";

            if ($itemField['type'] === 'image') {
                $rules["{$itemPath}_upload"] = [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:8192',
                ];
                $rules["{$path}.*.remove_{$itemFieldName}"] = ['nullable', 'boolean'];

                continue;
            }

            $this->addFieldRules($rules, $itemPath, $itemField);
        }
    }
}
