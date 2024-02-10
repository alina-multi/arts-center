<?php

namespace App\Http\Requests;

use App\Enums\ImageFolders;
use App\Rules\UploadedImage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array'],
            'images.*' => ['required', 'string', new UploadedImage()],
            'folder' => ['required', 'string', Rule::in(ImageFolders::cases())],
            'imageable_id' => ['required', 'integer'],
            'imageable_type' => ['required', Rule::in(array_keys(Relation::morphMap()))],
        ];
    }
}
