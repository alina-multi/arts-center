<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadMessageController extends Controller
{
    public function store(Thread $thread, MessageRequest $request)
    {
        $this->authorize('view', $thread);
        return $thread->messages()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);
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
