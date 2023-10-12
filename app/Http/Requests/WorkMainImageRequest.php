<?php

namespace App\Http\Requests;

use App\Enums\TagTypes;
use App\Rules\AspectRatio;
use App\Rules\TagType;
use App\Rules\UploadedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkMainImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'crop'=>['required'],
            'crop.x' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.y' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.width' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.height' => ['numeric', 'required_with:crop', 'min:0', new AspectRatio('crop.width', 4 / 3)],
        ];
    }
}
