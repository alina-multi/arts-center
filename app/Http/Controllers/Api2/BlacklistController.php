<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlacklistRequest;
use App\Models\Blacklist;

class BlacklistController extends Controller
{
    public function store(BlacklistRequest $request)
    {
        return Blacklist::firstOrCreate([
            'blacklist_user_id' => $request->user_id,
            'user_id' => $request->user()->id
        ]);
    }

    public function destroy(BlacklistRequest $request)
    {
        return Blacklist::where([
            'blacklist_user_id' => $request->user_id,
            'user_id' => $request->user()->id
        ])->firstOrFail()->delete();
    }
}
