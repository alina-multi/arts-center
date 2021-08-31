<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use App\Http\Controllers\Gallery\{IndexTrait, RelatedTrait, TagTrait, UserTrait};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentController extends Controller
{

    protected $commentTypes = ['work'];

    public function rules()
    {
        return [
            'commentable_id' => 'required|integer',
            'commentable_type' => [
                'required',
                Rule::in(array_keys(Relation::morphMap())),
            ],
            'comment_id' => 'integer|exists:comments,id',
            'depth' => 'integer',
            'body' => 'required|array'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $parts = explode('_', $id);
        $type = $parts[0];
        $ident = empty($parts[1]) ?: $parts[1];

        if (!in_array($type, $this->commentTypes)) {
            abort(404);
        }

        $comments = Comment::where('commentable_type', $type)
            ->where('commentable_id', $ident)
            ->with('user', 'votes', 'votes.user', 'votes.user.photo')
            ->orderBy('depth')
            ->orderBy('created_at')
            ->get()->toArray();


        $users = [];
        $tree = [];
        $idRef = []; //Flat id -> ref in tree

        function addToUsers(&$users, $user)
        {
            if(empty($users[$user['id']])) {
                $users[$user['id']] = $user;
            }
        }
        foreach ($comments as &$comment) {
            if (!empty($comment['user'])) {
                addToUsers($users, $comment['user']);
                unset($comment['user']);
            }
            $userVote = [];
            foreach ($comment['votes'] as $vote) {
                if (!empty($vote['user'])) {
                    addToUsers($users, $vote['user']);
                    $userVote[] = $vote['user']['id'];
                }
            }

            $comment['votes'] = $userVote;

            if (!$comment['comment_id']) {
                $tree[] = &$comment;
                $idRef[$comment['id']] = &$comment;
            } else {
               if (empty($idRef[$comment['comment_id']]['children'])) {
                   $idRef[$comment['comment_id']]['children'] = [];
               }
               $idRef[$comment['comment_id']]['children'][] = &$comment;
               $idRef[$comment['id']] = &$comment;
            }
        }
        return ['comments' => $tree, 'users' => $users];
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $data = $request->all();
        $data['commentable_type'] = $data['commentable_type'];
        $data['user_id'] = Auth::id();
        if (!empty($data['comment_id'])) {
            $parent = Comment::where('id',$request->comment_id)->firstOrFail();
            $newDepth = (int) $parent->depth + 1;
            // If we try to go to deep, just post it one level higher
            if ($newDepth > 5) {
                $newDepth--;
                $data['comment_id'] = $parent->comment_id;
            }
            $data['depth'] = $newDepth;
        }
        return Comment::create($data);
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            throw new UnauthorizedException('You can only edit your own comments'.$comment->user_id.' - '.Auth::id());
        }
        $request->validate(['body' => 'required|array']);
        $comment->body = $request->get('body');
        $comment->save();
        return $comment;
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            throw new UnauthorizedException('You can only delete your own comments'.$comment->user_id.' - '.Auth::id());
        }
        $comment->delete();
    }

}
