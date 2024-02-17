<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

class ContactResource extends JsonResource
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
                'phone' => $this->phone,
                'email' => $this->email,
                'from_day' => $this->from_day,
                'to_day' => $this->to_day,
                'from_time' => Carbon::createFromTimeString($this->from_time)->format('H:i'),
                'to_time' => Carbon::createFromTimeString($this->to_time)->format('H:i')
            ];
        }
    }
}
