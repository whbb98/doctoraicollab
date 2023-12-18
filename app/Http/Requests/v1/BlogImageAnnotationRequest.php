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
    private $blog;
    private $participantsIDs;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->blog = Blog::find($this->route('blogID'));
        $this->participantsIDs = array_map(fn($p) => $p['user_id'], $this->blog->blogParticipants->toArray());
        return in_array(Auth::user()->id, $this->participantsIDs);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $blogImagesIDs = array_map(fn($obj) => $obj['id'], $this->blog->blogImages->toArray());
        if ($this->method() == 'POST') {
            return [
                'image_id' => ['required', 'integer', Rule::in($blogImagesIDs)],
                'annotation' => ['required', 'json']
            ];
        } else {
            return [
                'image_id' => ['required', 'integer', Rule::in($blogImagesIDs)],
                'user_id' => ['required', Rule::in($this->participantsIDs)]
            ];
        }
    }
}
