<?php

namespace App\Http\Resources\v1;

use App\Models\User;
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
        if (!$this->resource) {
            return [];
        }
        $user = User::find($this->user_id);
        return [
            'id' => $this->id,
            'datetime' => Carbon::parse($this->datetime)->format('Y-M-d H:i'),
            'visibility' => $this->visibility,
            'description' => $this->description,
            'userFullName' => $user->first_name . ' ' . $user->last_name,
            'abbreviatedName' => $user->first_name[0] . $user->last_name[0],
            'avatar' => $user->profile->getPhoto(),
            'interactions' => $this->postInteractions->makeHidden(['post_id']),
            'comments' => PostCommentResource::collection($this->postComments),
            'files' => FileResource::collection($this->postData)
        ];
    }
}
