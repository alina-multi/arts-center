<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:255'
        ]);
        $user = Auth::user();
        $user->fill($request->attributes);
        return response()->json($user);
    }
}
