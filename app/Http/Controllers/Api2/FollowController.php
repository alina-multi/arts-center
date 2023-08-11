<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(FollowRequest $request)
    {
        return Follow::firstOrCreate([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowRequest $request)
    {
        $follow = Follow::where([
           ...$request->all(),
           'user_id' => $request->user()->id
        ])->firstOrFail();
        return $follow->delete();
    }
}
