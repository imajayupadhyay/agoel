<?php

namespace App\Http\Requests\Admin;

use App\Models\Industry;
use App\Models\Page;
use App\Rules\SafeContentLink;
use App\Services\IndustriesSchema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIndustriesRequest extends FormRequest
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
            'industries' => ['nullable', 'array', 'max:50'],
        ];

        $page = Page::query()->where('key', 'industries')->with('sections')->first();

        if ($page) {
            $schema = app(IndustriesSchema::class);

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
        }

        foreach (Industry::query()->get() as $industry) {
            $prefix = "industries.{$industry->id}";
            $rules["{$prefix}.name"] = ['required', 'string', 'max:160'];
            $rules["{$prefix}.tag"] = ['required', 'string', 'max:220'];
            $rules["{$prefix}.body_before"] = ['required', 'string', 'max:3000'];
            $rules["{$prefix}.body_accent"] = ['nullable', 'string', 'max:300'];
            $rules["{$prefix}.body_after"] = ['nullable', 'string', 'max:3000'];
            $rules["{$prefix}.pull_quote"] = ['required', 'string', 'max:600'];
            $rules["{$prefix}.facts"] = ['nullable', 'array', 'max:8'];
            $rules["{$prefix}.facts.*"] = ['nullable', 'string', 'max:180'];
            $rules["{$prefix}.image_alt"] = ['nullable', 'string', 'max:180'];
            $rules["{$prefix}.is_enabled"] = ['nullable', 'boolean'];
            $rules["{$prefix}.sort_order"] = ['required', 'integer', 'min:0', 'max:10000'];
            $rules["{$prefix}.image_upload"] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'];
            $rules["{$prefix}.remove_image"] = ['nullable', 'boolean'];
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
            $this->addFieldRules($rules, "{$path}.*.{$itemFieldName}", $itemField);
        }
    }
}
