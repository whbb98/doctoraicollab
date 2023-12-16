<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImagePredictionsRequest extends FormRequest
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
        $ids = Blog::find($this->route('blogID'))->blogImages->pluck('id');
        return [
            'image_id' => ['required', Rule::in($ids)],
            'predictions' => ['required', 'json']
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => 2,
            'datetime' => Carbon::now()
        ]);
    }
}
