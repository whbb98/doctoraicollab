<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'datetime' => $this->datetime,
            'visibility' => $this->visibility,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'interactions' => $this->postInteractions,
            'comments' => PostCommentResource::collection($this->postComments)
        ];
    }
}
