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
        if ($this->method() === 'PATCH') {
            return [
                'username' => ['sometimes', 'required', 'unique:user'],
                'first_name' => ['sometimes', 'required'],
                'last_name' => ['sometimes', 'required'],
                'email' => ['sometimes', 'required', 'email', 'unique:user'],
                'password' => ['sometimes', 'required', 'min:5', 'max:20'],
                'phone' => ['sometimes', 'required', 'unique:user'],
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
            'phone.unique' => 'The Phone Number is Already Exists, Try another one'
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
