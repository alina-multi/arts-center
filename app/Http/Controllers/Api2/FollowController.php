<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('followingUsers',
            'followingUsers.photo',
            'followingUsers.photo.variants',
            'followingWorks',
            'followingWorks.titles',
            'followingWorks.preview',
            'followingWorks.preview.variants'
        );
        return [
            'users' => $user->followingUsers,
            'works' => $user->followingWorks
        ];
    }

    public function store(FollowRequest $request)
    {
        return Follow::firstOrCreate([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]);
    }

    public function destroy(FollowRequest $request)
    {
        return Follow::where([
            ...$request->all(),
            'user_id' => $request->user()->id
        ])->firstOrFail()->delete();
    }

    public function followers(Request $request)
    {
        return Follow::where([
            'followable_type' => 'user',
            'followable_id' => $request->user()->id,
        ])
            ->get()
            ->load('user', 'user.photo', 'user.photo.variants')
            ?->map(fn($row) => $row->user->toArray())
            ->toArray();
    }
}
