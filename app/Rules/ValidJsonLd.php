<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidJsonLd implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return;
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded) || json_last_error() !== JSON_ERROR_NONE) {
            $fail('The schema must be valid JSON.');

            return;
        }

        if (($decoded['@context'] ?? null) !== 'https://schema.org') {
            $fail('The schema must contain "@context": "https://schema.org".');

            return;
        }

        if (! isset($decoded['@type']) && ! isset($decoded['@graph'])) {
            $fail('The schema must contain an @type or @graph property.');
        }
    }
}
