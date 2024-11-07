<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Thread::class);
    }
    public function index(Request $request)
    {
        return $request->user()->threads->load('participants', 'participants.user', 'participants.user.photo', 'lastMessage', 'lastMessage.user', 'lastMessage.user.photo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateThreadRequest $request)
    {
        $thread = Thread::create($request->validated());
        foreach ($request->participants as $participant) {
            $thread->participants()->create(['user_id' => $participant]);
        }
        // Always add user that created the channel
        $thread->participants()->create([
            'user_id' => $request->user()->id,
            'approved_at' => now()
        ]);
        return $thread->load('participants');
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        return $thread->load('messages', 'messages.user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        return $thread->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        return $thread->delete();
    }
}
