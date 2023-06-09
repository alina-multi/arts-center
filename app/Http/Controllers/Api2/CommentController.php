<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $data = $request->all();
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

    public function update(CommentRequest $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => "You can't edit this"], 401);
        }
        $comment->text = $request->get('text');
        return $comment->save();
    }

    public function destroy(Comment $comment)
    {
        if (!$comment->canDelete(Auth::id())) {
            return response()->json(['error' => "You can't delete this"], 401);
        }
        $comment->delete();
    }
}
