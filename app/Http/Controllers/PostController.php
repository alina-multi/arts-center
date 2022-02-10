<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Post;
use App\Http\Requests\PostRequest;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
     * @param \App\Blacklist $blacklist
     * @return \Illuminate\Http\Response
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
