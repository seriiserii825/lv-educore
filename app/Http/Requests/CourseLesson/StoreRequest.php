<?php

namespace App\Http\Requests\CourseLesson;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $options = [
            'title' => 'required|string|max:255|unique:courses,title',
            'description' => 'required|string',
            'file_path' => 'required|string',
            'storage' => 'required|string',
            'file_type' => 'required|in:video,audio,text,pdf',
            'volume' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'downloadable' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'is_preview' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'lesson_type' => 'required|in:lesson,live',
        ];
        if ($this->demo_video_storage === 'upload') {
            $options['video_file'] = 'required|file|mimes:mp4|max:102400';
        } else {
            $options['video_input'] = 'required|string';
        }
        return $options;
    }
}
