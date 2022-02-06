<?php

namespace App\Http\Controllers;

use App\Blacklist;
use App\Blog;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $translations = $request->post('translations');
        $blog = Blog::create();
        $blog->owners()->attach(Auth::id());
        // todo: check maybe "upsert" will work with relation in the future
        foreach ($translations as $translation) {
            $blog->translations()->updateOrCreate([
                'language' => $translation['language']
            ],
                array_intersect_key($translation, array_flip(['about', 'title']))
            );
        }
        return $blog;
    }

    public function update(Blog $blog, BlogRequest $request)
    {
        $this->authorize('update', $blog);
        $translations = $request->post('translations');
        foreach ($translations as $translation) {
            $blog->translations()->updateOrCreate([
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
    public function destroy(Blog $blog)
    {
        $this->authorize('destroy', $blog);
        return $blog->delete();
    }
}
