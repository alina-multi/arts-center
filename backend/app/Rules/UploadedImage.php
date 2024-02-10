<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class UploadedImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        Storage::exists($value) || $fail("The $attribute does not exist.");
        $mime = Storage::mimeType($value);
        in_array($mime, ['image/jpeg', 'image/png', 'image/webp']) || $fail("The $attribute must be Jpeg/Png/Webp image. Got $mime.");
        Storage::size($value) < 1024 * 1024 * 10 || $fail("The $attribute must be less than 10MB.");
    }
}
