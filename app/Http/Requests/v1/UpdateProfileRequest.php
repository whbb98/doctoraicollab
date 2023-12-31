<?php

namespace App\Http\Requests\v1;

use App\Models\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'photo' => ['sometimes', 'required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'cover' => ['sometimes', 'required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'bio' => ['sometimes', 'required', 'max:255'],
                'city' => ['sometimes', 'required', 'integer', Rule::in(array_keys(Helper::$dz_cities))],
                'hospital' => ['sometimes', 'required', 'max:255'],
                'occupation' => ['sometimes', 'required', 'max:255'],
                'department' => ['sometimes', 'required', 'max:255']
            ];
        } else {
            return [];
        }
    }

    protected function passedValidation()
    {
    }
}
