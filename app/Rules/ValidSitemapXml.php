<?php

namespace App\Rules;

use Closure;
use DOMDocument;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSitemapXml implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return;
        }

        $previous = libxml_use_internal_errors(true);
        $document = new DOMDocument;
        $loaded = $document->loadXML($value, LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (! $loaded) {
            $fail('The sitemap override must be valid XML.');

            return;
        }

        if (! in_array($document->documentElement?->localName, ['urlset', 'sitemapindex'], true)) {
            $fail('The sitemap root element must be urlset or sitemapindex.');
        }
    }
}
