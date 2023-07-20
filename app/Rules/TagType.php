<?php

namespace App\Rules;

use App\Models\Tag;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TagType implements ValidationRule
{
    function __construct(protected $type)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tag = Tag::firstWhere('id', $value);
        if (!$tag) {
            $fail('No such tag exists');
        }
        if ($tag->type_id !== $this->type) {
            $fail('Tag has wrong type');
        }
    }
}
