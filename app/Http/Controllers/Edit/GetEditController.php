<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Work;
use Illuminate\Http\Request;

class GetEditController extends Controller
{
    public function __invoke($id)
    {
        return Work::where('id', $id)->where('user_id', Auth::id())->with('blocks', 'blocks.images', 'titles', 'image')->firstOrFail();
    }
}
