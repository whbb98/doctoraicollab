<?php

namespace App\Http\Requests\v1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends FormRequest
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
            'visibility' => ['sometimes', 'required', 'boolean'],
            'description' => ['required', 'max:255'],
            'files.*' => ['sometimes', 'required', 'mimes:jpg,jpeg,png,gif']
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'datetime' => Carbon::now(),
            'user_id' => Auth::user()->id
        ]);
    }
}
