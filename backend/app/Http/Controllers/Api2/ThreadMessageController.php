<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Thread;
use App\Notifications\NewMessage;

class ThreadMessageController extends Controller
{
    public function store(Thread $thread, MessageRequest $request)
    {
        $user_id = $request->user()->id;
        $this->authorize('view', $thread);
        $newMessage = $thread->messages()->create([
            ...$request->validated(),
            'user_id' => $user_id,
        ]);
        $part = $thread->participants;
        $thread->participants
            ->where('user_id', '!=', $user_id)
            ->whereNotNull('approved_at') // Only notify approved participants
            ->each(fn(Participant $participant) => $participant->user->notify(new NewMessage($newMessage, $participant->user_id)));
        return $newMessage;
    }

    public function update(Thread $thread, MessageRequest $request, Message $message)
    {
        $this->authorize('view', $thread);
        $this->authorize('update', $message);
        return $message->update($request->validated());
    }

    public function destroy(Thread $thread, Message $message)
    {
        $this->authorize('view', $thread);
        $this->authorize('delete', $message);
        return $message->delete();
    }
}
