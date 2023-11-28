<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        if (!$this->resource) {
            return [];
        }
        return [
            'photo' => $this->getPhoto(),
            'cover' => $this->getCover(),
            'bio' => $this->bio,
            'city' => $this->city,
            'hospital' => $this->hospital,
            'department' => $this->department,
            'userId' => $this->user_id
        ];
    }
}
