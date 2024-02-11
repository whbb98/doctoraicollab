<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user' => $user->username,
            'abbreviatedName' => $user->first_name[0] . $user->last_name[0],
            'avatar' => $user->profile->getPhoto(),
            'fullName' => $user->first_name . ' ' . $user->last_name,
            'datetime' => Carbon::parse($this->datetime)->format('Y-M-d H:i')
        ];
    }
}
