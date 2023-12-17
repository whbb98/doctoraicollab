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
            'email' => $this->email,
            'phone' => $this->phone,
            'birthDate' => Carbon::parse($this->birth_date)->format('d-M-Y'),
            'joined' => Carbon::parse($this->joined)->format('d-M-Y H:i'),
            'isActive' => $this->is_active ? 'Identified' : 'not identified yet',
            'gender' => $this->gender,
            'profile' => $this->profile->makeHidden('user_id'),
            'career' => $this->career,
            'contact' => $this->contact,
            'notificationSettings' => $this->notificationSettings->makeHidden('user_id'),
            'friends'=>$this->friends
        ];
    }
}
