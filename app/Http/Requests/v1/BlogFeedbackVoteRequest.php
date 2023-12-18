<?php

namespace App\Http\Requests\v1;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogFeedbackVoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $blog;
    private $participantsIDs;

    public function authorize(): bool
    {
        $this->blog = Blog::find($this->route('blogID'));
        if (!$this->blog) {
            return false;
        }
        $this->participantsIDs = array_map(fn($p) => $p['user_id'], $this->blog->blogParticipants->toArray());
        return in_array(Auth::user()->id, $this->participantsIDs);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $feedback = $this->blog->blogFeedback;
        $labels = array_map(fn($el) => $el['id'], json_decode($feedback->labels ?? '[]', true));
        if ($this->method() == 'POST') {
            return [
                'answer' => ['required', Rule::in($labels)]
            ];
        } else {
            return [];
        }
    }

    protected function passedValidation()
    {
        if ($this->method() == 'POST') {
            $this->merge([
                'voted_by' => Auth::user()->id,
                'datetime' => Carbon::now()
            ]);
        }
    }
}
