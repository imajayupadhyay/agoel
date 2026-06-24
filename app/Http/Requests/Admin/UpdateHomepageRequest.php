<?php

namespace App\Http\Requests\Admin;

use App\Models\Page;
use App\Rules\SafeContentLink;
use App\Services\HomepageSchema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateHomepageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->email === 'admin@gmail.com';
    }

    public function rules(): array
    {
        $rules = [
            'page' => ['required', 'array'],
            'page.title' => ['required', 'string', 'max:160'],
            'page.seo_title' => ['required', 'string', 'max:180'],
            'page.meta_description' => ['required', 'string', 'max:320'],
            'page.is_published' => ['nullable', 'boolean'],
            'page.og_image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'page.remove_og_image' => ['nullable', 'boolean'],
            'sections' => ['required', 'array'],
        ];

        $page = Page::query()->where('key', 'home')->with('sections')->first();

        if (! $page) {
            return $rules;
        }

        $schemaService = app(HomepageSchema::class);

        foreach ($page->sections as $section) {
            $prefix = "sections.{$section->id}";
            $rules["{$prefix}.name"] = [
                Rule::requiredIf($section->is_custom),
                'nullable',
                'string',
                'max:120',
            ];
            $rules["{$prefix}.is_enabled"] = ['nullable', 'boolean'];
            $rules["{$prefix}.sort_order"] = ['required', 'integer', 'min:0', 'max:10000'];
            $rules["{$prefix}.content"] = ['required', 'array'];

            foreach ($schemaService->forSection($section)['fields'] as $fieldName => $field) {
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

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $page = Page::query()->where('key', 'home')->with('sections')->first();

                if (! $page) {
                    return;
                }

                $reserved = ['top', 'industries', 'philanthropy', 'news', 'books', 'research', 'voice', 'meet', 'contact'];
                $anchors = [];

                foreach ($page->sections->where('is_custom', true) as $section) {
                    $anchor = data_get($this->input('sections', []), "{$section->id}.content.anchor");

                    if (! $anchor) {
                        continue;
                    }

                    if (in_array($anchor, $reserved, true) || in_array($anchor, $anchors, true)) {
                        $validator->errors()->add(
                            "sections.{$section->id}.content.anchor",
                            'This section anchor is already in use.',
                        );
                    }

                    $anchors[] = $anchor;
                }
            },
        ];
    }

    private function addFieldRules(array &$rules, string $path, array $field): void
    {
        $max = $field['max'] ?? 1000;

        $rules[$path] = match ($field['type']) {
            'text', 'textarea' => ['nullable', 'string', "max:{$max}"],
            'email' => ['nullable', 'email:rfc', "max:{$max}"],
            'link' => ['nullable', 'string', "max:{$max}", new SafeContentLink],
            'slug' => ['nullable', 'string', "max:{$max}", 'regex:/^[a-z0-9-]*$/'],
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
