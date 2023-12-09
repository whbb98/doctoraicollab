<?php

namespace App\Http\Requests\v1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBlogRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'cover_image' => ['sometimes', 'required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'],
            'files' => ['required', 'array', 'min:3'],
            'files.*' => ['required', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            'has_meeting' => ['sometimes', 'required', 'boolean'],
            'scheduled' => [
                'required_if:has_meeting,true',
                'date_format:Y-m-d H:i',
                'after:' . Carbon::now()->addHour()->format('Y-m-d H:i')
            ],
            'link' => ['required_if:has_meeting,true', 'url:https'],
            'duration' => ['required_if:has_meeting,true', 'integer', 'min:15'],
            'patient_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'participants' => ['required','array','min:1',Rule::exists('User','username')]
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => 2,
            'created_on' => Carbon::now(),
        ]);
    }
}
