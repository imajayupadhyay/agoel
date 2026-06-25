<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndustryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->email === 'admin@gmail.com';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
        ];
    }
}
