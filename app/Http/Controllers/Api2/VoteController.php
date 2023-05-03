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
        $model = $class::findOrFail($data['votable_id']);
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
}
