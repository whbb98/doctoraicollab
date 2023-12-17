<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $blog = Blog::find($this->route('blogID'));
        if (!$blog) {
            return false;
        }
        return $blog->user_id == Auth::user()->id;
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
        $icd10_codes = App::make('icd10_codes');
        $user_codes = $this->feedback_options;

        $filteredData = array_filter($icd10_codes, function ($icd10) use ($user_codes) {
            return in_array($icd10['id'], $user_codes);
        });

        $this->merge([
            'user_id' => Auth::user()->id,
            'labels' => array_values($filteredData)
        ]);
    }
}
