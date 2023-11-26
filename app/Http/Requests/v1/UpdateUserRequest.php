<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        if ($this->method() == 'PATCH') {
            return [
                'username' => ['sometimes', 'required', 'unique:user', 'alpha_num:ascii'],
                'first_name' => ['sometimes', 'required', 'alpha:ascii'],
                'last_name' => ['sometimes', 'required', 'alpha:ascii'],
                'email' => ['sometimes', 'required', 'email', 'unique:user'],
                'password' => ['sometimes', 'required', 'min:5', 'max:20'],
                'phone' => ['sometimes', 'required', 'unique:user', 'digits:10'],
                'birth_date' => ['sometimes', 'required', 'date'],
                'gender' => ['sometimes', 'required', Rule::in('M', 'F')],
            ];
        } else {
            return [];
        }
    }

    public function messages()
    {
        return [
        ];
    }

    protected function passedValidation()
    {
        if ($this->method() === 'PATCH' && $this->password) {
            $this->merge([
                'password' => Hash::make($this->password)
            ]);
        }
    }

}
