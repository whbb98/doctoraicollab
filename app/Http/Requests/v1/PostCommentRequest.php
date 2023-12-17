<?php

namespace App\Http\Requests\v1;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = Post::find($this->route('postID'));
        $user = Auth::user();
        return $post?->user_id == $user->id || $post?->visibility;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'comment' => ['required', 'max:255'],
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => Auth::user()->id,
            'datetime' => Carbon::now()
        ]);
    }
}
