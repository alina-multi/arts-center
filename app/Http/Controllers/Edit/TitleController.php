<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockPut;
use App\Rules\BlockData;
use App\Rules\OwnsWork;
use App\Models\WorkBlock;
use App\Models\WorkTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class TitleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
     * @throws ValidationException
     */
    public function update(Request $request, WorkTitle $title)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $title->work_id)) {
            abort(401);
        }
        $this->validate($request, [
            'title' => ['required', 'string', 'max:30'],
        ]);

        $title->title = $request->input('title');
        $title->save();

        return $title;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(WorkTitle $title)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $title->work_id)) {
            abort(401);
        }
        $work = $title->work;
        $work->{"show_$title->language"} = 0;
        $work->save();

        $title->delete();
        return response()->noContent();
    }
}
