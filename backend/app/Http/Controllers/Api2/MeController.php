<?php

namespace App\Http\Controllers\Api2;

use App\Enums\ThreadType;
use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user()->load(['photo', 'threads', 'blacklists', 'follows', 'favorites']);
        $blacklists = $user->blacklists->pluck('blacklist_user_id')->toArray();
        $follows = $user->follows->mapToGroups(function (Follow $follow) {
            return [$follow->followable_type => $follow->followable_id];
        })->toArray();
        $favorites = $user->favorites->pluck('work_id')->toArray();
        $favoriteFolders = $user->favoriteFolders->toArray();
        $threads = $user->threads()->where('type', ThreadType::Direct)->with('participants', fn($query) => $query->where('user_id', '!=', $user->id))->get()->mapWithKeys(fn(Thread $thread) => [strval($thread?->participants?->first()?->user_id) ?? 0 => $thread->id]);
        return [
            ...$user->toArray(),
            'role' => $user->role,
            'approved_at' => $user->approved_at,
            'verified_at' => $user->verified_at,
            'email_verified_at' => $user->email_verified_at,
            'blacklists' => $blacklists,
            'follows' => $follows,
            'favorites' => [
                'works' => $favorites,
                'folders' => $favoriteFolders
            ],
            'unread' => $user->unreadNotifications->count(),
            'threads' => $threads
        ];
    }
}
