<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStep2Request extends FormRequest
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
        $options = [
            'capacity' => 'nullable|integer',
            'duration' => 'nullable|string',
            'qna' => 'nullable|boolean',
            'certificate' => 'nullable|boolean',
            'category_id' => 'nullable|exists:course_categories,id',
            'course_level_id' => 'nullable|exists:course_levels,id',
            'course_language_id' => 'nullable|exists:course_languages,id',
        ];
        return $options;
    }
}
