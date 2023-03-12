<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockPut;
use App\Rules\BlockData;
use App\Rules\OwnsWork;
use App\Models\WorkBlock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class BlockController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'work_id' => ['required', 'exists:works,id', new OwnsWork],
            'type' => ['required',
                Rule::in(['image', 'text', 'grid', 'embed']),
            ],
            'language' => ['required'],
            'data' => ['present', 'array'],
            'images' => ['array'],
            'order' => ['required', 'numeric']
        ]);
        $block = WorkBlock::create($request->all());
        $images = $request->input('images');
        $syncImages = [];
        if ($images) {
            foreach ($images as $image) {
                if (!empty($image['id'])) {
                    $syncImages[]=$image['id'];
                }
            }
        }
        $block->images()->sync($syncImages);
        $block->load('images');
        return $block;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param BlockPut $request
     * @param WorkBlock $block
     * @return WorkBlock
     * @throws ValidationException
     */
    public function update(Request $request, WorkBlock $block)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $block->work_id)) {
            abort(401);
        }
        $this->validate($request, [
            'data' => ['array'],
            'images' => ['array'],
            'order' => ['numeric']
        ]);

        $block->fill($request->toArray());
        $block->save();

        $images = $request->input('images');
        $syncImages = [];
        if ($images) {
            foreach ($images as $image) {
                if (!empty($image['id'])) {
                    $syncImages[]=$image['id'];
                }
            }
        }
        $block->images()->sync($syncImages);
        $block->load('images');
        return $block;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(WorkBlock $block)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $block->work_id)) {
            abort(401);
        }
        $block->delete();
        return response()->noContent();
    }
}
