<?php

namespace App\Http\Resources\v1;

use App\Models\Base64Format;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BlogDetailsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'created_on' => Carbon::parse($this->created_on)->format('D m Y H:i'),
            'has_meeting' => $this->has_meeting,
            'author' => new UserResource(User::find($this->user_id)),
            'participants' => array_map(fn($p) => new UserResource(User::find($p['user_id'])), $this->blogParticipants->toArray()),
            'annotations' => $this->annotations,
            'feedback' => [
                'id' => $this->blogFeedback?->id,
                'labels' => $this->blogFeedback?->labels,
                'votes' => $this->blogFeedback?->feedbackData
            ],
            'ml_predictions' => $this->MLPredictions,
            'images' => array_map(fn($img) => [
                'id' => $img['id'],
                'base64' => (new Base64Format($img['image_binary']))->getBase64()
            ], $this->blogImages->toArray())
        ];
    }
}
