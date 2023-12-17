<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
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
        if(!$this->resource){
            return [];
        }
        return [
            'id' => $this->id,
            'datetime' => Carbon::parse($this->datetime)->format('Y-M-d H:i'),
            'visibility' => $this->visibility,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'interactions' => $this->postInteractions->makeHidden(['post_id']),
            'comments' => PostCommentResource::collection($this->postComments)
        ];
    }
}
