<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!$this->resource) {
            return [];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_on' => $this->created_on,
            'has_meeting' => $this->has_meeting,
            'user_id' => $this->user_id,
            'participants' => count(new BlogParticipantCollection($this->blogParticipants)),
//            'cover_image' => 'data:image/jpeg;base64,' . base64_encode($this->cover_image)
        ];
    }
}
