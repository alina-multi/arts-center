<?php


namespace App\Http\Controllers;


use App\Helpers\ImageHelper;
use App\Jobs\ConvertImage;
use App\Rules\OwnsWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ImageController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'work_id' => ['exists:works,id', new OwnsWork],
            'type' => [
                'required',
                Rule::in(['preview', 'works', 'grid']),
            ],
            'file' => ['required', 'mimes:jpg,webp,png,heif', 'max:20000'],
        ]);
        $user = Auth::user();
        $file = file_get_contents($request->file('file'));

        $folder = $request->type;
        $image = ImageHelper::upload($folder, $file, $user->id , $request->file('file')->extension(), $user->id);
        ConvertImage::dispatch($image)->onQueue('high');
        return response($image->makeVisible('id'));
    }
}
