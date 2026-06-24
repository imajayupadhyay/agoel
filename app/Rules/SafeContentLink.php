<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeContentLink implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value)) {
            $fail('The :attribute must be a valid link.');

            return;
        }

        $isSafe = str_starts_with($value, '#')
            || (str_starts_with($value, '/') && ! str_starts_with($value, '//'))
            || str_starts_with($value, 'mailto:')
            || filter_var($value, FILTER_VALIDATE_URL);

        if (! $isSafe || preg_match('/^\s*javascript:/i', $value)) {
            $fail('The :attribute must be an HTTPS URL, relative URL, anchor, or email link.');
        }
    }
}
