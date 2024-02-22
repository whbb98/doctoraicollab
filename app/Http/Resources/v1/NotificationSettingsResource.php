<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationSettingsResource extends JsonResource
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
        } else {
            return [
                'new_follower' => !!$this->new_follower,
                'message_requests' => !!$this->message_requests,
                'blog_invitations' => !!$this->blog_invitations,
                'emails' => !!$this->emails,
                'sms' => !!$this->sms,
            ];
        }
    }
}
