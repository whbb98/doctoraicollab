<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ImagePredictionsRequest extends FormRequest
{
    private $blog;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->blog = Blog::find($this->route('blogID'));
        if (!$this->blog) {
            return false;
        }
        return $this->blog->user_id == Auth::user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ids = $this->blog->blogImages->pluck('id');
        return [
            'image_id' => ['required', Rule::in($ids)],
            'predictions' => ['required', 'json']
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'datetime' => Carbon::now()
        ]);
    }
}
