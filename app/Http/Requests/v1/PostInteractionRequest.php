<?php

namespace App\Http\Requests\v1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PostInteractionRequest extends FormRequest
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
            'post_id' => ['required', 'integer', 'min:1'],
            'is_liked' => ['required', 'boolean'],
            'is_shared' => ['required', 'boolean']
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => 2, //will be replaced by sanctum user
            'datetime' => Carbon::now()
        ]);
    }
}
