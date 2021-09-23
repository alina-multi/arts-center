<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockPut;
use App\Rules\BlockData;
use App\Rules\OwnsWork;
use App\WorkBlock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

class BlockController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, WorkBlock $block)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $block->work_id)) {
            throw new UnauthorizedException();
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkBlock $block)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $block->work_id)) {
            throw new UnauthorizedException();
        }
        $block->delete();
        return response()->noContent();
    }
}
