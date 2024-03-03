<?php

namespace App\Rules;

use App\Service\UrlChecker\UrlCheckerInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeUrl implements ValidationRule
{
    public function __construct(
        private UrlCheckerInterface $urlChecker,
    ) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->urlChecker->isUrlSafe($value)) {
            $fail('The  url :attribute isn\'t safe.');
        }
    }
}
