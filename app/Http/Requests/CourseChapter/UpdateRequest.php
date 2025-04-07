<?php

namespace App\Http\Requests\CourseChapter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $chapterId = $this->route('chapter'); // Get chapter id from route

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('course_chapters', 'title')->ignore($chapterId),
            ],
            'course_id' => 'required|exists:courses,id',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];
    }
}
