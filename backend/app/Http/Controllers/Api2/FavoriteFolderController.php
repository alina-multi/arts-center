<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteFolderRequest;
use App\Models\FavoriteFolder;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class FavoriteFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return FavoriteFolder::where('user_id', $request->user()->id)->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FavoriteFolder $favoriteFolder)
    {
        if ($favoriteFolder->user_id !== $request->user()->id) {
            abort(403);
        }
        return $favoriteFolder->load('works', 'works.titles', 'works.preview');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FavoriteFolderRequest $request, FavoriteFolder $favoriteFolder)
    {
        if ($favoriteFolder->user_id !== $request->user()->id) {
            abort(403);
        }
        return $favoriteFolder->update([
            'title' => $request->get('title')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, FavoriteFolder $favoriteFolder)
    {
        if ($favoriteFolder->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($favoriteFolder->works()->count()) {
            abort(422, "Can't delete non-empty folder");
        }

        return $favoriteFolder->delete();
    }
}
