<?php

namespace App\Http\Resources\v1;

use App\Models\Base64Format;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BlogResource extends JsonResource
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
        $flag = null;
        if ($this->user_id === Auth::user()->id) {
            $flag = 'myBlog';
        } else {
            $participants = $this->blogParticipants->toArray();
            foreach ($participants as $p) {
                if ($p['user_id'] === Auth::user()->id && $p['blog_id'] === $this->id) {
                    if ($p['status'] === null) {
                        $flag = 'pending';
                    } elseif ($p['status'] === 1) {
                        $flag = 'participating';
                    } else {
                        $flag = 'refused';
                    }
                }
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_on' => $this->created_on,
            'has_meeting' => $this->has_meeting,
            'meeting' => $this->meeting,
            'user_id' => $this->user_id,
            'participants' => count(new BlogParticipantCollection($this->blogParticipants)),
            'comments' => count($this->blogComments),
            'flag' => $flag,
            'cover' => (new Base64Format($this->blogImages[0]['image_binary'], null, null))->getBase64()
        ];
    }
}
