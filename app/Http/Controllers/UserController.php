<?php

namespace App\Http\Controllers;

use App\TagTitle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $language = $request->input('language');
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
            if (empty($language)) {
                abort(422, "Language required for rating sorting");
            }
            $users = User::select('users.*', 'rating')->join(
                'user_ratings',
                function ($join) use ($ratable_type, $ratable_id, $language) {
                    $join->on('users.id', '=', 'user_ratings.user_id')
                        ->where('user_ratings.ratable_type', $ratable_type)
                        ->where('user_ratings.language', $language);
                    if (is_numeric($ratable_id)) {
                        $join->where('user_ratings.ratable_id', $ratable_id);
                    } else {
                        $join->whereColumn('user_ratings.ratable_id', $ratable_id);
                    }
                }
            )->orderBy('user_ratings.rating', 'DESC')->where('user_ratings.rating', '>', 0);
        } elseif ($order === 'new') {
            $users = User::orderBy('id', 'desc');
        } elseif ($order === 'online') {
        }

        // For rating filtering tag is already handled with join
        if (isset($tag) && $order !== 'rating') {
            $users->whereHas('ratings', function (Builder $query) use ($ratable_type, $ratable_id) {
                $query->where('ratable_type', $ratable_type)->where('rating', '>', 0);
                if (is_numeric($ratable_id)) {
                    $query->where('ratable_id', $ratable_id);
                } else {
                    $query->whereColumn('ratable_id', $ratable_id);
                }
            });
        }

        // I think 2 chars is safe without any further checks :)
        if ($country and strlen($country) === 2) {
            $users->where('country', $country);
        }

        $usersList = $users->with('photo')->with('ratings')->offset($offset)->limit($perPage)->get()
            ->append(['highlights']
            )->makeVisible(['works', 'rating']); //This magically adds rating from joined table
        $works = [];
        foreach ($usersList as $user) {
            $highlights = $user['highlights'];
            if ($highlights) {
                $works += $highlights->toArray();
            }
            $user->works = $highlights->pluck('id');
        }

        return ['users' => $usersList->toArray(), 'works' => $works];
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
        $user = User::where('username', $id)->with([
                                                   'photo',
                                                   'ratings' => function ($query) use ($lang) {
                                                       $query->where('language', '=', $lang);
                                                   }
                                               ])->firstOrFail()->makeVisible('country', 'ratings');
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

    public function csv()
    {
        $output = '';
        $output .= "email,first_name,last_name,country\n";
        $users = DB::connection('old')->table('user')->where('rate', '>', 0)->select(
            ['name', 'lastname', 'email', 'country_alpha2']
        )->get();
        foreach ($users as $user) {
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                $user->name = htmlspecialchars($user->name);
                $user->lastname = htmlspecialchars($user->lastname);
                $output .= "$user->email,$user->name,$user->lastname,$user->country_alpha2\n";
            }
        }
        return response($output, 200, ["Content-type" => "text/csv"]);
    }
}
