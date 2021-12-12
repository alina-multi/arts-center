<?php

namespace App\Http\Controllers;

use App\Jobs\TranslateWork;
use App\Rules\OwnsWork;
use App\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Spatie\ResponseCache\Facades\ResponseCache;

/** @OA\Info(title="Arts 2.0 Api", version="0.1") */
class WorkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $work = Work::create(['image_id' => 0]);
        $work->owners()->attach(Auth::id());
        return response($work);
    }

    /**
     * @OA\Get(
     *     path="/api/work/{work_id}",
     *     summary="Work details",
     *     description="Get work details, basic stuff are already provided by gallery endpoint",
     *     operationId="getWorkDetails",
     *       @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *         )
     *     )
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id)
    {
        $work = Work::where('id', $id)->with([
                                                 'details:work_id,year,width,height,length',
                                                 'category:tags.id',
                                                 'category.titles' => function ($query) use ($language) {
                                                     $query->where('language', $language);
                                                 },
                                                 'tags:tags.id',
                                                 'tags.titles',
                                                 'blocks' => function ($query) use ($language) {
                                                     $query->select('id', 'work_id', 'type', 'data')
                                                         ->where(function ($query) use ($language) {
                                                             $query->where('language', $language)
                                                                 ->orWhere('language', 'zz'); //zz means any language
                                                         })->orderBy('order');
                                                 },
                                                 'blocks.images',
                                                 'owners:users.id,old_id,name,username,image_id',
                                                 'owners.photo',
                                                 'votes',
                                                 'votes.user',
                                                 'votes.user.photo'
                                             ])->firstOrFail();

        //Normalize tags
        $tags = $work->tags->keyBy('id')->reject(function ($item) {
            return sizeof($item->titles) === 0; //If there are no title for this tag, delete it
        })->map(function ($item, $key) {
            return [
                'title' => $item->titles[0]->title,
                'count' => $item->count
            ];
        });
        //Normalize category
        $category = $work->category->keyBy('id')->reject(function ($item) {
            return sizeof($item->titles) === 0; //If there are no title for this tag, delete it
        })->map(function ($item, $key) {
            return [
                'title' => $item->titles[0]->title,
                'count' => $item->count
            ];
        });
        $details = [];
        if (!empty($work->details)) {
            $details = $work->details->toArray();
        }
        $details['blocks'] = $work->blocks;
        $details['tags'] = $tags->keys();
        $details['category'] = $category->keys();
        $votes = [];
        $users = [];
        foreach ($work->votes as $vote) {
            if (!empty($vote->user)) {
                $votes[] = $vote->user_id;
                $users[$vote->user->id] = $vote->user;
            }
        }
        return [
            'details' => $details,
            'tags' => $tags,
            'category' => $category,
            'owners' => $work->owners->pluck('id'),
            'votes' => $votes,
            'users' => $users,
            'rating' => $work->rating
        ];
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
            abort(401);
        }
        $this->validate($request, [
            'published_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'image_id' => ['exists:images,id'],
            'tags.*.id' => ['integer', 'exists:tags,id'],
            'category.*.id' => ['integer', 'exists:tags,id']
        ]);
        $work->tags()->sync(array_merge((array) $request->tags, (array) $request->category));
        $work->fill($request->all());
        foreach ($work->titles as $title) {
            if ($title->language) {
                $field = 'show_' . $title->language;
                if (isset($work->$field)) { // We can have language that don't have fields in DB yet
                    $work->$field = 1;
                }
            }
        }
        $work->save();
        if ($work->published_at) {
            ResponseCache::clear(['gallery', 'work']); // For now let's make it super simple and clear all gallery and work cache
            // If there is something to translate do it now
            if (sizeof($work->titles) < 3) {
                TranslateWork::dispatch($work);
            }
        }

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
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $work->id)) {
            abort(401);
        }
        $work->delete();
        ResponseCache::clear(['gallery', 'work']); // For now let's make it super simple and clear all gallery and work cache
        return response()->noContent();
    }
}
