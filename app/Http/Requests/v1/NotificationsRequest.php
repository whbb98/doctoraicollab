<?php

namespace App\Http\Requests\v1;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotificationsRequest extends FormRequest
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
                'notification' => ['required', Rule::in(array_keys(Notifications::$types))],
                'receiver' => ['required', 'integer', 'exists:user,id']
            ];
        } else if ($this->method() == 'PATCH') {
            return [
                'read_status' => ['required', 'boolean']
            ];
        } else {
            return [];
        }
    }

    protected function passedValidation()
    {
        if ($this->method() == 'POST') {
            $this->merge([
                'datetime' => Carbon::now(),
                'sender' => Auth::user()->id
            ]);
        }
    }
}
