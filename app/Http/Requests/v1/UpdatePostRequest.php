<?php

namespace App\Http\Requests\v1;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $post = Post::find(($this->route('postID')));
        return $user->id == $post?->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'visibility' => ['sometimes', 'required', 'boolean'],
            'description' => ['required', 'max:255'],
            'files.*' => ['sometimes', 'required', 'mimes:jpg,png,pdf,csv']
        ];
    }

    protected function passedValidation()
    {
        if (!$this->visibility) {
            $this->merge(['visibility' => 0]);
        }
        $this->merge([
            'datetime' => Carbon::now(),
            'user_id' => Auth::user()->id
        ]);
    }
}
