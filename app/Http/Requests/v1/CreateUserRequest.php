<?php

namespace App\Http\Requests\v1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'username' => ['required', 'unique:user', 'alpha_num:ascii'],
            'first_name' => ['required', 'alpha:ascii'],
            'last_name' => ['required', 'alpha:ascii'],
            'email' => ['required', 'email', 'unique:user'],
            'password' => ['required', 'min:5', 'max:20'],
            'phone' => ['required', 'unique:user', 'digits:10'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', Rule::in('M', 'F')],
        ];
    }

    public function messages()
    {
        return [];
    }

    protected function passedValidation()
    {
        $this->merge([
            'joined' => Carbon::now(),
            'password' => Hash::make($this->password)
        ]);
    }

}
