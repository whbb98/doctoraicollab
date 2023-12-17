<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $participantsIDs;

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
            'comment_id' => ['sometimes', 'required', Rule::exists('blog_comments', 'id')],
            'comment' => ['required', 'max:255'],
            'replied_to' => ['sometimes', 'required', Rule::in($this->participantsIDs)]
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => Auth::user()->id,
            'comment' => strip_tags($this->comment),
            'datetime' => Carbon::now(),
        ]);
    }

    public function messages()
    {
        return [
            'replied_to' => 'you must reply to a participant!'
        ];
    }
}
