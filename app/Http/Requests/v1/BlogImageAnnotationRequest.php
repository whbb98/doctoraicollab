<?php

namespace App\Http\Requests\v1;

use App\Models\BlogImages;
use App\Models\UserAnnotations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogImageAnnotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => 2
        ]);
    }
}
