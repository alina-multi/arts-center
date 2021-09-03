<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use App\Work;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('full')) {
            $follows = Follow::where(
                'user_id',
                Auth::id()
            )->with([
                        'followable' => function (
                            MorphTo $morphTo
                        ) {
                            $morphTo->morphWith([
                                                    Work::class => [
                                                        'image'
                                                    ],
                                                    User::class => [
                                                        'photo'
                                                    ]
                                                ]);
                        }
                    ])->get();
            $users = [];
            $works = [];
            foreach ($follows as &$follow) {
                if ($follow->followable instanceof User) {
                    if (empty($users[$follow->followable->id])) {
                        $users[$follow->followable->id] = $follow->followable;
                    }
                } elseif ($follow->followable instanceof Work) {
                    if (empty($works[$follow->followable->id])) {
                        $works[$follow->followable->id] = $follow->followable;
                    }
                }
                $follow->unsetRelation('followable');
            }
            return compact('follows', 'users', 'works');
        } else {
            return Follow::where('user_id', Auth::id())->get();
        }
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
                               'followable_type' => ['required', 'string', Rule::in(array_keys(Relation::morphMap()))],
                               'followable_id' => [
                                   'required',
                                   'integer',
                                   Rule::exists($request->followable_type . 's', 'id'),
                                   Rule::unique('follows')->where(function ($query) use ($request) {
                                       return $query->where('followable_type', $request->followable_type)
                                           ->where('followable_id', $request->followable_id);
                                   })
                               ],
                           ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        return Follow::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Follow $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Follow $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        if ($follow->user_id == Auth::id()) {
            $follow->delete();
        } else {
            abort(401);
        }
    }
}
