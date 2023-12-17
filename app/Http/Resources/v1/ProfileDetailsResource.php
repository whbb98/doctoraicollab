<?php

namespace App\Http\Resources\v1;

use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileDetailsResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'photo' => $this->getPhoto(),
            'cover' => $this->getCover(),
            'bio' => $this->bio,
            'city' => Helper::$dz_cities[$this->city],
            'hospital' => $this->hospital,
            'department' => $this->department,
            'occupation' => $this->occupation,
            'career' => $this->user->career->makeHidden(['id', 'user_id']),
            'contact' => $this->user->contact->makeHidden(['id', 'user_id'])
        ];
    }
}
