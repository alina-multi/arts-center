<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Follow;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public $language;

    public function index(Request $request, $language)
    {
        $this->language = $language;
        $user = Auth::user();
        if ($user) {
            $perPage = 30;
            $page = $request->page ?? 1;
            $offset = ($page - 1) * $perPage;

            $users = [];
            $works = [];
            $feedsArray = [];
            $feeds = Feed::where('user_id', $user->id)->orderBy('id', 'DESC')
                ->with([
                           'feedable' => function (
                               MorphTo $morphTo
                           ) {
                               $morphTo->morphWith([
                                                       Work::class => [
                                                           'image',
                                                           'owners',
                                                           'titles' => function ($query) {
                                                               $query->where('language', $this->language);
                                                           },
                                                       ],
                                                       Comment::class => [
                                                           'user',
                                                           'commentable' => function (MorphTo $morphTo) {
                                                               $morphTo->morphWith([
                                                                                       Work::class => [
                                                                                           'image',
                                                                                           'owners',
                                                                                           'titles' => function ($query
                                                                                           ) {
                                                                                               $query->where(
                                                                                                   'language',
                                                                                                   $this->language
                                                                                               );
                                                                                           },
                                                                                       ]
                                                                                   ]);
                                                           }
                                                       ]
                                                   ]);
                           }
                       ])->offset($offset)->limit($perPage)->get();
            foreach ($feeds as &$feed) {
                if ($feed->feedable instanceof Comment) {
                    $feed->comment = $feed->feedable;
                    if ($feed->feedable->commentable instanceof Work) {
                        $works[$feed->feedable->commentable->id] = $feed->feedable->commentable;
                        $this->processWork($users, $works, $feed->feedable->commentable);
                        $feed->work = $feed->feedable->commentable->id;
                        $users[$feed->feedable->user->id] = $feed->feedable->user;
                        $feed->feedable->unsetRelation('commentable');
                        $feed->feedable->unsetRelation('user');
                    }
                } elseif ($feed->feedable instanceof Work) {
                    $this->processWork($users, $works, $feed->feedable);
                    $feed->work = $feed->feedable->id;
                }
                $feed->unsetRelation('feedable');
            }
            return [
                'feeds' => $feeds->append(['work', 'comment'])->makeVisible(['work', 'comment']),
                'users' => $users,
                'works' => $works
            ];
        } else {
            abort(401);
        }
    }

    public function processWork(&$users, &$works, &$work)
    {
        $owners = [];
        if ($work->owners) {
            foreach ($work->owners as $user) {
                if (is_object($user)) {
                    $users[$user->id] = $user;
                    $owners[] = $user->id;
                }
            }
            if (sizeof($owners)) {
                $work->unsetRelation('owners');
                $work->owners = $owners;
            }
        }
        $works[$work->id] = $work;
    }
}
