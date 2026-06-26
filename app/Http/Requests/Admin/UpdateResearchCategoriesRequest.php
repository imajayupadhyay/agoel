<?php

namespace App\Http\Requests\Admin;

use App\Models\ResearchCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResearchCategoriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $rules = [
            'categories' => ['nullable', 'array', 'max:50'],
        ];

        foreach (ResearchCategory::query()->get() as $category) {
            $prefix = "categories.{$category->id}";
            $rules["{$prefix}.name"] = ['required', 'string', 'max:120'];
            $rules["{$prefix}.label"] = ['required', 'string', 'max:120'];
            $rules["{$prefix}.slug"] = [
                'required',
                'string',
                'max:80',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('research_categories', 'slug')->ignore($category->id),
            ];
            $rules["{$prefix}.is_enabled"] = ['nullable', 'boolean'];
            $rules["{$prefix}.sort_order"] = ['required', 'integer', 'min:0', 'max:10000'];
        }

        return $rules;
    }
}
