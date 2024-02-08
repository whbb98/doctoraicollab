<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'joined' => Carbon::parse($this->joined)->format('d-M-Y'),
            'isActive' => $this->is_active ? 'Identified' : 'not identified yet',
            'gender' => $this->gender,
            'avatar' => $this->profile->getPhoto()
        ];
    }
}
