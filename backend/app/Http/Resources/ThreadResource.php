<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'last_message' => $this->messages->last(),
            'participants' => $this->participants,
            'pivot' => $this->pivot,
            'unread_messages' => $this->messages->where('created_at', '>', $this->pivot->last_read ?? now()->subYear())->where('user_id', '!=', $request->user()->id)->where('type', '!=', 'deleted')->count(),
        ];
    }
}
