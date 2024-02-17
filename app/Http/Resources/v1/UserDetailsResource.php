<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
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
            'username' => $this->username,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'abbreviatedName' => $this->first_name[0] . $this->last_name[0],
            'email' => $this->email,
            'phone' => $this->phone,
            'birthDate' => Carbon::parse($this->birth_date)->format('d-M-Y'),
            'joined' => Carbon::parse($this->joined)->format('M Y'),
            'isActive' => $this->is_active ? 'Identified' : 'not identified yet',
            'gender' => $this->gender,
            'profile' => $this->profile->makeHidden(['photo', 'cover', 'user_id']),
            'avatar' => $this->profile->getPhoto(),
            'cover' => $this->profile->getCover(),
            'career' => $this->career?->makeHidden(['user_id']),
            'contact' => new ContactResource($this->contact),
            'notificationSettings' => $this->notificationSettings->makeHidden('user_id'),
            'friends' => $this->friends
        ];
    }
}
