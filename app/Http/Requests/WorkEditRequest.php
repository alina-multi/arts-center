<?php

namespace App\Http\Requests;

use App\Enums\TagTypes;
use App\Models\Work;
use App\Rules\TagType;
use App\Rules\UploadedImage;
use DragonCode\Support\Helpers\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class WorkEditRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags($this->title),
            'description' => strip_tags($this->description),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'main' => ['string', new UploadedImage()],
            'more.*' => ['string', new UploadedImage()],
            'title'=> ['string', 'required', 'min:4', 'max:40'],
            'description'=> ['string'],
            'category'=> ['required', 'array'],
            'category.*' => ['numeric', 'exists:tags,id', new TagType(TagTypes::CATEGORY)]
        ];
    }
}
