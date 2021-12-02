<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\Facades\ResponseCache;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:255'
        ]);
        $user = Auth::user();
        $user->fill($request->attributes);
        ResponseCache::clear(['user']);
        return response()->json($user);
    }
}
