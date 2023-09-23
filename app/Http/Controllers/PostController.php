<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\Blog;
use App\Models\Post;
use App\Http\Requests\PostRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Blog $blog)
    {
        return $blog->posts()->orderBy('published_at','DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(PostRequest $request)
    {
        $blog = Blog::findOrFail($request->blog_id);
        $this->authorize('update', $blog);
        $translations = $request->post('translations');
        $post = Post::create($request->only(['blog_id','published_at']));
        // todo: check maybe "upsert" will work with relation in the future
        foreach ($translations as $translation) {
            $post->translations()->updateOrCreate([
                'language' => $translation['language']
            ],
                array_intersect_key($translation, array_flip(['body', 'title']))
            );
        }
        return $post;
    }

    public function update(Post $post, PostRequest $request)
    {
        $this->authorize('update', $post->blog);
        $translations = $request->post('translations');
        foreach ($translations as $translation) {
            $post->translations()->updateOrCreate([
                'language' => $translation['language']
            ],
                array_intersect_key($translation, array_flip(['about', 'title']))
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blacklist $blacklist
     * @return Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post->blog);
        return $post->delete();
    }

    public function show(Post $post)
    {
        $post->load('translations');
        $post->translations->makeVisible('body');
        return $post;
    }
}
