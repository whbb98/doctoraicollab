<?php

namespace App\Http\Resources\v1;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class NotificationsResource extends JsonResource
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
            "id" => $this->id,
            "datetime" => Carbon::parse($this->datetime)->format('Y-M-d H:i'),
            "type" => $this->notification,
            "status" => $this->read_status,
            "sender" => $this->getUsername($this->sender),
            "receiver" => $this->getUsername($this->receiver),
            "message" => $this->getFullname($this->sender) . ' ' . Notifications::$types[$this->notification]
        ];
    }

    private function getUsername($id)
    {
        return User::find($id)->username;
    }

    private function getFullname($id)
    {
        $user = User::find($id);
        return $user->first_name . ' ' . $user->last_name;
    }
}
