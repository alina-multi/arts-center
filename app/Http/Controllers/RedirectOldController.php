<?php

namespace App\Http\Controllers;

use App\TagTitle;
use App\User;
use App\Work;
use Illuminate\Http\Request;

class RedirectOldController extends Controller
{
    public function work($userId, $workId)
    {
        $work = Work::where('old_id', $workId)->first();
        if (!$work) {
            return redirect()->route('home', [], 301);
        }
        return redirect('https://arts.center/work/' . $work->id, 301);
    }

    public function user($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect()->route('home', [], 301);
        }
        return redirect('https://arts.center/' . $user->username, 301);
    }

    public function art($art)
    {
        $title = TagTitle::where('title', $art)->first();

        if (!$title) {
            return redirect()->route('home', [], 301);
        }

        $ruTitle = TagTitle::where('tag_id', $title->tag_id)->where('language', 'ru')->first();

        if (!$ruTitle) {
            return redirect()->route('home', [], 301);
        }

        return redirect('https://arts.center/tag/' . $ruTitle->title, 301);
    }
}
