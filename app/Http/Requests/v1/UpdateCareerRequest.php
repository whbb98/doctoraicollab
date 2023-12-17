<?php

namespace App\Http\Requests\v1;

use App\Models\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCareerRequest extends FormRequest
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
                'type' => ['required', Rule::in(array_values(Helper::$career_types))],
                'career_name' => ['required'],
                'period' => ['required', 'date_format:Y-m-d'],
                'organization' => ['required']
            ];
        } else if ($this->method() == 'PATCH') {
            return [
                'type' => ['sometimes', 'required', Rule::in('education', 'reward', 'experience')],
                'career_name' => ['sometimes', 'required'],
                'period' => ['sometimes', 'required', 'date_format:Y-m-d'],
                'organization' => ['sometimes', 'required']
            ];
        } else {
            return [];
        }
    }

    protected function passedValidation()
    {
        //this will be replaced by sanctum soon
        $this->merge([
            'user_id' => Auth::user()->id
        ]);
    }
}
