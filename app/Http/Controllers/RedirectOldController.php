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
            return redirect('https://arts.center/ru',301);
        }
        return redirect('https://arts.center/ru/work/' . $work->id, 301);
    }

    public function user($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect('https://arts.center/ru',301);
        }
        return redirect('https://arts.center/ru/' . $user->username, 301);
    }

    public function art($art)
    {
        $title = TagTitle::where('title', $art)->first();

        if (!$title) {
            return redirect('https://arts.center/ru',301);
        }

        $ruTitle = TagTitle::where('tag_id', $title->tag_id)->where('language', 'ru')->first();

        if (!$ruTitle) {
            return redirect('https://arts.center/ru',301);
        }

        return redirect('https://arts.center/ru/tag/' . $ruTitle->title, 301);
    }

    public function enWork($userId, $folder, $workId)
    {
        $work = Work::where('old_id', $workId)->first();
        if (!$work) {
            return redirect('https://arts.center',301);
        }
        return redirect('https://arts.center/work/' . $work->id, 301);
    }

    public function enUser($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect('https://arts.center',301);
        }
        return redirect('https://arts.center/' . $user->username, 301);
    }

    public function enArt($art)
    {
        $title = TagTitle::where('title', $art)->first();

        if (!$title) {
            return redirect('https://arts.center/ru',301);
        }

        return redirect('https://arts.center/tag/' . $art, 301);
    }
}
