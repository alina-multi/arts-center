<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Mail\NewIdeaPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function idea()
    {
        return Feedback::where('type', 'idea')->whereNotNull('approved_at')->orderBy('rating', 'desc')->get();
    }

    public function feedback()
    {
        return Feedback::where('type', 'feedback')->get();
    }

    public function complaint()
    {
        return Feedback::where('type', 'complaint')->get();
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
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
