<?php

namespace App\Http\Controllers;

use App\TagTitle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{

    protected $rules = [
        'name' => 'min:3|max:255'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = $request->input('order', 'rating');
        $country = $request->input('country');
        $tagTitle = $request->input('tag', 'all');
        $page = $request->input('page', 1);
        $perPage = 30;
        $offset = ($page - 1) * $perPage;

        if ($tagTitle !== 'all') {
            $tag = TagTitle::where('title', $tagTitle)->first();
            if (empty($tag)) {
                abort(404, "Tag: $tagTitle not found");
            }
            $ratable_type = 'tag';
            $ratable_id = $tag->id;
        } else {
            $ratable_type = 'user';
            $ratable_id = 'users.id';
        }


        if ($order === 'rating') {
            $users = User::join('user_ratings', function ($join) use ($ratable_type, $ratable_id) {
                $join->on('users.id', '=', 'user_ratings.user_id')
                    ->on('user_ratings.ratable_type', '=', $ratable_type)
                    ->on('user_ratings.ratable_id', '=', $ratable_id);
            })->orderBy('user_ratings.rating', 'DESC')->where('user_ratings.rating', '>', 0);
        } elseif ($order === 'new') {
            $users = User::orderBy('id', 'desc');
        } elseif ($order === 'online') {
        }

        // For rating filtering tag is already handled with join
        if (isset($tag) && $order !== 'rating') {
            $users->whereHas('ratings', function (Builder $query) use ($ratable_type, $ratable_id) {
                $query->where('ratable_type', $ratable_type)->where('ratable_id', $ratable_id)->where('rating', '>', 0);
            });
        }

        // I think 2 chars is safe without any further checks :)
        if ($country and strlen($country) === 2) {
            $users->where('country', $country);
        }

        $usersList = $users->offset($offset)->limit($perPage)->get();
        return ['users' => $usersList];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        $field = is_numeric($id) ? 'id' : 'username';
        $user = User::where($field, $id)->with('photo')->firstOrFail();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $this->validate($request, $this->rules);
        //For now, only allow edit self
        if ($user->id === Auth::id()) {
            $user->fill($request->all());
            $user->save();
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
