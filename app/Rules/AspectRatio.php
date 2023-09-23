<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class AspectRatio implements ValidationRule, DataAwareRule
{
    protected $data;

    public function __construct(protected $field, protected $aspectRatio)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $expectedValue = round(Arr::get($this->data, $this->field) / $this->aspectRatio);
        if ($expectedValue != $value) {
            $fail("Expected $expectedValue with aspect ratio $this->aspectRatio got $value");
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}
