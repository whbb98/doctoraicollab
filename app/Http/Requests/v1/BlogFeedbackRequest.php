<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class BlogFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // will be true only for blog author
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $icd10_codes = App::make('icd10_codes');
        return [
            'feedback_options' => ['required', 'array'],
            'feedback_options.*' => ['distinct', Rule::in(array_column($icd10_codes, 'id'))]
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => 2,
            'labels' => array_values($this->feedback_options)
        ]);
    }
}
