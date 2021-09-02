<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use App\Work;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('full')) {
            $subscriptions = Subscription::where(
                'user_id',
                Auth::id()
            )->with([
                        'subscribable' => function (
                            MorphTo $morphTo
                        ) {
                            $morphTo->morphWith([
                                                    Work::class => [
                                                        'image'
                                                    ],
                                                    User::class => [
                                                        'photo'
                                                    ]
                                                ]);
                        }
                    ])->get();
            $users = [];
            $works = [];
            foreach ($subscriptions as &$subscription) {
                if ($subscription->subscribable instanceof User) {
                    if (empty($users[$subscription->subscribable->id])) {
                        $users[$subscription->subscribable->id] = $subscription->subscribable;
                    }
                } elseif ($subscription->subscribable instanceof Work) {
                    if (empty($works[$subscription->subscribable->id])) {
                        $works[$subscription->subscribable->id] = $subscription->subscribable;
                    }
                }
                $subscription->unsetRelation('subscribable');
            }
            return compact('subscriptions', 'users', 'works');
        } else {
            return Subscription::where('user_id', Auth::id())->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                               'subscribable_type' => ['required', 'string', Rule::in(array_keys(Relation::morphMap()))],
                               'subscribable_id' => [
                                   'required',
                                   'integer',
                                   Rule::exists($request->subscribable_type . 's', 'id'),
                                   Rule::unique('subscriptions')->where(function ($query) use ($request) {
                                       return $query->where('subscribable_type', $request->subscribable_type)
                                           ->where('subscribable_id', $request->subscribable_id);
                                   })
                               ],
                           ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        return Subscription::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        if ($subscription->user_id == Auth::id()) {
            $subscription->delete();
        } else {
            abort(401);
        }
    }
}
