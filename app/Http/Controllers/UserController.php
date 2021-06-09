<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        //
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
        $user = User::where('id',$id)->firstOrFail();
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
