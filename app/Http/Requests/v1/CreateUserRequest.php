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
            'username' => ['required', 'unique:user'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:user'],
            'password' => ['required', 'min:5', 'max:20'],
            'phone' => ['required', 'unique:user'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', Rule::in('M', 'F')],
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'The Phone Number is Already Exists, Try another one'
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'joined' => Carbon::now(),
            'password' => Hash::make($this->password)
        ]);
    }

}
