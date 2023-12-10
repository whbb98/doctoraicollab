<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            'id' => $this->id,
//            'user_id' => $this->user_id,
//            'blog_id' => $this->blog_id,
//            'status' => $this->status,
            'username' => User::find($this->user_id)->username
        ];
    }
}
