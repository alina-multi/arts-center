<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use App\Models\FavoriteFolder;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(FavoriteRequest $request)
    {
        if ($request->folder_title) {
            $folder_id = FavoriteFolder::create([
                'user_id' => $request->user()->id,
                'title' => $request->folder_title
            ])->id;
        } else {
            $folder_id = $request->folder_id;
        }
        return Favorite::create([
            'user_id' => $request->user()->id,
            'work_id' => $request->work_id,
            'favorite_folder_id' => $folder_id,
        ]);
    }

    public function destroy(FavoriteRequest $request)
    {
        return Favorite::where([
            'user_id' => $request->user()->id,
            'work_id' => $request->work_id,
            'favorite_folder_id' => $request->folder_id,
        ])->firstOrFail()->delete();
    }
}
