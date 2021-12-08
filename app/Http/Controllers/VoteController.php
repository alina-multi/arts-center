<?php

namespace App\Http\Controllers;

use App\Jobs\RecountUserRatings;
use App\Vote;
use App\Work;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'vote' => [Rule::in([1, -1])],
                'votable_type' => ['required', Rule::in(array_keys(Relation::morphMap()))],
                'votable_id' => ['required', 'integer',
                Rule::unique('votes')->where(function ($query) use ($request) {
                    return $query->where('votable_type', $request->votable_type)
                        ->where('votable_id', $request->votable_id)
                        ->where('user_id', Auth::id());
                })
            ],
            ]
        );

        $data = $request->all();
        $data['ip'] = $request->ip();
        $data['user_id'] = Auth::id();
        $class = Relation::getMorphedModel($data['votable_type']);
        $model = $class::firstOrFail('id', $data['votable_id']);
        $vote = Vote::create($data);
        $newRating = 1 + (int) Vote::where('votable_id', $data['votable_id'])
                ->where('votable_type', $data['votable_type'])->sum(
                    'vote'
                );
        $model->rating = $newRating;
        $model->save();
        // todo: logic to send to feed if newRating is equal to certain threshold
        if ($model instanceof Work) {
            foreach ($model->owners as $owner) {
                RecountUserRatings::dispatch($owner->id);
            }
        } elseif (!empty($model->user_id)) {
            RecountUserRatings::dispatch($model->user_id);
        }

        return ['rating' => $newRating, 'vote' => $vote];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Vote $votes
     * @return \Illuminate\Http\Response
     */
    public function show($type_id)
    {
        list($type, $id) = explode('_', $type_id);
        if (!in_array($type, array_keys(Relation::morphMap()))) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return Vote::where('votable_type', $type)->where('votable_id', $id)->with('user')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Vote $votes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $votes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Vote $votes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $votes)
    {
        //
    }
}
