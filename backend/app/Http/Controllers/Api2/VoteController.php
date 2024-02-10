<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Jobs\RecountUserRatings;
use App\Models\Vote;
use App\Models\Work;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $allowedVotes = $request->votable_type === 'comment' ? [1, -1] : [1];
        $request->validate(
            [
                'vote' => [Rule::in($allowedVotes)],
                'votable_type' => ['required', Rule::in(array_keys(Relation::morphMap()))],
                'votable_id' => ['required', 'integer'],
            ]
        );

        $class = Relation::getMorphedModel($request->votable_type);
        $model = $class::findOrFail($request->votable_id);
        Vote::updateOrCreate([
            'user_id' => Auth::id(),
            'votable_id' => $request->votable_id,
            'votable_type' => $request->votable_type,
        ], [
            'vote' => $request->vote,
            'ip' => $request->ip(),
        ]);
        // Rating starts with 1
        $model->rating = 1 + Vote::where('votable_id', $request->votable_id)
                ->where('votable_type', $request->votable_type)->sum(
                    'vote'
                );
        $model->save();
        // todo: logic to send to feed if newRating is equal to certain threshold
        if ($model instanceof Work) {
            foreach ($model->owners as $owner) {
                RecountUserRatings::dispatch($owner->id);
            }
        } elseif (!empty($model->user_id)) {
            RecountUserRatings::dispatch($model->user_id);
        }

        return ['rating' => $model->rating];
    }

    public function destroy(Request $request)
    {
        $request->validate(
            [
                'votable_type' => ['required', Rule::in(array_keys(Relation::morphMap()))],
                'votable_id' => ['required', 'integer'],
            ]
        );
        $class = Relation::getMorphedModel($request->votable_type);
        $model = $class::findOrFail($request->votable_id);
        Vote::where([
            'user_id' => Auth::id(),
            'votable_id' => $request->votable_id,
            'votable_type' => $request->votable_type])
            ->delete();
        $model->rating = 1 + Vote::where('votable_id', $request->votable_id)
                ->where('votable_type', $request->votable_type)->sum(
                    'vote'
                );
        $model->save();

        return ['rating' => $model->rating];
    }
}
