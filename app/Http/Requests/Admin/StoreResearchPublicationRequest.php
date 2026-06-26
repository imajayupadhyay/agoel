<?php

namespace App\Http\Requests\Admin;

use App\Models\ResearchCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResearchPublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:220'],
            'research_category_id' => ['required', Rule::exists(ResearchCategory::class, 'id')],
        ];
    }
}
