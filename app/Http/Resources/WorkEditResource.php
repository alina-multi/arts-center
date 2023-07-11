<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkEditResource extends JsonResource
{
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'images' => $this->whenLoaded('images'),
            'owners' => $this->whenLoaded('owners'),
            'titles' => $this->whenLoaded('titles'),
        ];
    }
}
