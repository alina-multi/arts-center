<?php

namespace App\Http\Controllers;

use App\Vote;
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
                'vote' => [Rule::in([1])],
                'votable_id' => 'required|integer',
                'votable_type' => ['required', Rule::in(['work', 'comment'])],
            ]
        );

        $data = $request->all();
        $data['ip'] = $request->ip();
        $data['user_id'] = Auth::id();
        $class = Relation::getMorphedModel($data['votable_type']);
        $model = $class::firstOrFail('id', $data['votable_id']);
        $vote = Vote::create($data);
        $newRating = 1 + Vote::where('votable_id', $data['votable_id'])
                ->where('votable_type', $data['votable_type'])->sum(
                    'vote'
                );
        $model->rating = $newRating;
        $model->save();
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
        if (!in_array($type,['comment', 'work'])) {
            throw new AccessDeniedException();
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
