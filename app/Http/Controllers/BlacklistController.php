<?php

namespace App\Http\Controllers;

use App\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blacklists = Blacklist::where(
            'user_id',
            Auth::id()
        )->with(['blacklist', 'blacklist.photo', 'user', 'user.photo'])->get();
        $users = [];
        foreach ($blacklists as &$blacklist) {
            if (empty($users[$blacklist->user->id])) {
                $users[$blacklist->user->id] = $blacklist->user;
            }
            if (empty($users[$blacklist->blacklist->id])) {
                $users[$blacklist->blacklist->id] = $blacklist->blacklist;
            }
            $blacklist->unsetRelation('user');
            $blacklist->unsetRelation('blacklist');
        }
        return compact('blacklists', 'users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                               'blacklist_user_id' => [
                                   'required',
                                   'integer',
                                   Rule::exists('users', 'id')
                               ],
                           ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        return Blacklist::create($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Blacklist $blacklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blacklist $blacklist)
    {
        if ($blacklist->user_id == Auth::id()) {
            $blacklist->delete();
        } else {
            abort(401);
        }
    }
}
