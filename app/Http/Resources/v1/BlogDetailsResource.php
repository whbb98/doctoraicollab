<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'created_on' => $this->created_on,
            'has_meeting' => $this->has_meeting,
            'user_id' => $this->user_id,
            'patient_id' => $this->patient_id,
            'participants' => new BlogParticipantCollection($this->blogParticipants),
            'feedback' => [
                'id' => $this->blogFeedback->id,
                'labels' => $this->blogFeedback->labels,
                'votes' => $this->blogFeedback->feedbackData
            ],
            'ml_predictions' => $this->MLPredictions
        ];
    }
}
