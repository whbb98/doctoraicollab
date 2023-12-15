<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogFeedbackVoteRequest extends FormRequest
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
        $feedback = Blog::find($this->route('blogID'))->blogFeedback;
        $labels = array_map(fn($el) => $el['id'], json_decode($feedback->labels ?? '[]', true));
        return [
            'answer' => ['required', Rule::in($labels)]
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'voted_by' => 3,
            'datetime' => Carbon::now()
        ]);
    }
}
