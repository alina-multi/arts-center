<?php

namespace App\Http\Controllers;

use App\Rules\OwnsWork;
use App\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Validation\Rule;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Work::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $work = Work::create(['image_id'=>0]);
        $work->owners()->attach(Auth::id());
        return response($work);
    }

    /**
     * Get work details, basic stuff are already provided by gallery endpoint
     *
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id)
    {
        $work = Work::where('id', $id)->with(['details:work_id,year,width,height,length', 'tags:tags.id', 'tags.titles' => function ($query) use ($language) {
            $query->where('language', $language);
        }, 'blocks' => function ($query) use ($language) {
            $query->select('id', 'work_id', 'type', 'data')
                ->where(function ($query) use ($language) {
                    $query->where('language', $language)
                        ->orWhere('language', 'zz'); //zz means any language
                })->orderBy('order');
        }, 'blocks.images', 'owners:users.id,old_id,name,username'])->firstOrFail();

        //Normalize tags
        $tags = $work->tags->keyBy('id')->reject(function ($item) {
            return sizeof($item->titles) === 0; //If there are no title for this tag, delete it
        })->map(function ($item, $key) {
            return [
                'title' => $item->titles[0]->title,
                'count' => $item->count
            ];
        });
        $details = $work->details->toArray();
        $details['blocks'] = $work->blocks;
        $details['tags'] = $tags->keys();
        return ['details' => $details, 'tags' => $tags, 'owners' => $work->owners->pluck('id')];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $work->id)) {
            throw new UnauthorizedException();
        }
        $this->validate($request, [
            'published_at' => ['date_format:Y-m-d H:i:s'],
            'image_id' => ['exists:images,id']
        ]);
        $work->fill($request->all())->save();
        return $work;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        //
    }
}
