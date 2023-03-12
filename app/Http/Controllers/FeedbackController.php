<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Mail\NewIdeaPosted;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function idea($language)
    {
        $feedbacks = Feedback::where('type', 'idea')
            ->where('language', $language)
            ->whereNotNull('approved_at')
            ->orderBy('rating', 'desc')
            ->with('user', 'user.photo', 'votes', 'votes.user', 'votes.user.photo')
            ->get();
        return $this->denormilizeOutput($feedbacks);
    }

    public function feedback($language)
    {
        $feedbacks = Feedback::where('type', 'feedback')
            ->where('language', $language)
            ->whereNotNull('approved_at')
            ->orderBy('rating', 'desc')
            ->with('user', 'user.photo', 'votes', 'votes.user', 'votes.user.photo')
            ->get();
        return $this->denormilizeOutput($feedbacks);
    }

    public function complaint($language)
    {
        $feedbacks = Feedback::where('type', 'complaint')
            ->where('language', $language)
            ->whereNotNull('approved_at')
            ->orderBy('rating', 'desc')
            ->with('user', 'user.photo', 'votes', 'votes.user', 'votes.user.photo')
            ->get();
        return $this->denormilizeOutput($feedbacks);
    }


    function denormilizeOutput($feedbacks)
    {
        $votes = [];
        $users = [];
        $ratings = [];
        $feedbacksOutput = [];
        foreach ($feedbacks as $feedback) {
            $this->addToUsers($users, $feedback->user);
            foreach ($feedback->votes as $vote) {
                $this->addToUsers($users, $vote->user);
                $votes['feedback_' . $feedback->id][] = $vote->user->id;
            }
            $feedbackArray = $feedback->toArray();
            $ratings['feedback_' . $feedback->id] = $feedback->rating;

            unset($feedbackArray['user'], $feedbackArray['votes'], $feedbackArray['rating']);
            $feedbacksOutput[] = $feedbackArray;
        }
        return ['votes' => $votes, 'users' => $users, 'ratings' => $ratings, 'feedbacks' => $feedbacksOutput];
    }

    function addToUsers(&$users, $user)
    {
        if (empty($users[$user['id']])) {
            $users[$user['id']] = $user;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
                               'language' => ['required', Rule::in(config('app.languages'))],
                               'title' => [
                                   Rule::requiredIf($request->type !== 'complaint'),
                                   'string',
                               ],
                               'body' => [
                                   Rule::requiredIf($request->type !== 'complaint' || $request->category === 'other')
                               ],
                               'type' => ['required', Rule::in(array_keys(Feedback::TYPE_CATEGORY))],
                               'category' => [
                                   Rule::requiredIf($request->type === 'complaint'),
                                   Rule::in(Feedback::TYPE_CATEGORY['complaint'])
                               ],
                               'feedbackable_id' => [
                                   Rule::requiredIf($request->type === 'complaint')
                               ],
                               'feedbackable_type' => [
                                   Rule::requiredIf($request->type === 'complaint'),
                                   Rule::in(array_keys(Relation::morphMap()))
                               ],

                           ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $feedback = Feedback::create($data);
        Mail::to('stepan@arts.center')->send(new NewIdeaPosted($feedback));
        return $feedback;
    }

    /**
     * Display the specified resource.
     *
     * @param Feedback $feedback
     * @return Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Feedback $feedback
     * @return Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feedback $feedback
     * @return Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
