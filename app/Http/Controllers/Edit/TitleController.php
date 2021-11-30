<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockPut;
use App\Rules\BlockData;
use App\Rules\OwnsWork;
use App\WorkBlock;
use App\WorkTitle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Spatie\ResponseCache\Facades\ResponseCache;

class TitleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'language' => ['required'],
                'title' => ['required', 'string', 'max:30'],
                'work_id' => [
                    'required',
                    'exists:works,id',
                    new OwnsWork,
                    // It should have unique combination of work_id and language
                    Rule::unique('work_titles')->where(
                        function ($query) use ($request) {
                            return $query->where('language', $request->language);
                        }
                    )
                ],
            ]
        );
        ResponseCache::clear(['gallery', 'work']
        ); // For now let's make it super simple and clear all gallery and work cache
        $title = WorkTitle::create($request->all());
        $work = $title->work;
        $work->{"show_$title->language"} = 1;
        $work->save();
        return $title;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param BlockPut $request
     * @param WorkBlock $block
     * @return WorkBlock
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, WorkTitle $title)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $title->work_id)) {
            throw new UnauthorizedException();
        }
        $this->validate($request, [
            'title' => ['required', 'string', 'max:30'],
        ]);

        $title->title = $request->input('title');
        $title->save();

        ResponseCache::clear(['gallery', 'work']
        ); // For now let's make it super simple and clear all gallery and work cache
        return $title;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkTitle $title)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $title->work_id)) {
            throw new UnauthorizedException();
        }
        $work = $title->work;
        $work->{"show_$title->language"} = 0;
        $work->save();

        $title->delete();
        ResponseCache::clear(['gallery', 'work']
        ); // For now let's make it super simple and clear all gallery and work cache
        return response()->noContent();
    }
}
