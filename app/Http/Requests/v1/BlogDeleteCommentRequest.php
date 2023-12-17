<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogDeleteCommentRequest extends FormRequest
{
    private $participantsIDs;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $blog = Blog::find($this->route('blogID'));
        if (!$blog) {
            return false;
        }
        $this->participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        return in_array(Auth::user()->id, $this->participantsIDs);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment_id' => ['required', Rule::exists('blog_comments', 'id')]
        ];
    }
}
