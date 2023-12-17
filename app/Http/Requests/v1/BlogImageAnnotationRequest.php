<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use App\Models\BlogImages;
use App\Models\UserAnnotations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogImageAnnotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $blog = Blog::find($this->route('blogID'));
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        return in_array(Auth::user()->id, $participantsIDs);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image_id' => ['required', 'integer', Rule::exists('blog_images', 'id')],
            'annotation' => ['required', 'json']
        ];
    }
}
