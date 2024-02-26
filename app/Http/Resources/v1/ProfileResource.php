<?php

namespace App\Http\Resources\v1;

use App\Models\Helper;
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
        if (!$this->resource) {
            return [];
        }
        return [
            'user' => new UserResource($this->user),
            'photo' => $this->getPhoto(),
            'cover' => $this->getCover(),
            'city' => Helper::$dz_cities[$this->city],
            'hospital' => $this->hospital,
            'department' => $this->department,
            'occupation' => $this->occupation
        ];
    }
}
