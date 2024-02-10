<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlacklistRequest;
use App\Models\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index(Request $request)
    {
        // Todo simplify this someday :)
        return $request
            ->user()
            ->load('blacklists.blacklist', 'blacklists.blacklist.photo', 'blacklists.blacklist.photo.variants')
            ->blacklists->map(fn($row) => $row->blacklist->toArray())
            ->toArray();
    }

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
