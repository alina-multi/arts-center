<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function store( $request)
    {
        return Thread::create([
            'user_id' => $request->user()->id,
            ...$request->all()
        ]);
    }
}
