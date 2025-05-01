<?php

namespace App\Http\Requests\CourseLesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lesson_id = $this->route('lesson'); // Get lesson id from route
        $options = [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lessons', 'title')
                    ->ignore($lesson_id) // ignore first
                    ->where(function ($query) {
                        $query->where('id', $this->route('lesson'));
                    }),
            ],
            'storage' => 'required|in:upload,youtube,vimeo,external_link',
            'file_type' => 'required|in:video,audio,text,pdf',
            'volume' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'downloadable' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'is_preview' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'lesson_type' => 'nullable|in:lesson,live',
        ];
        if ($this->storage === 'upload') {
            $options['video_file'] = 'nullable|file|mimes:mp4|max:30480'; // 20MB
        } else {
            $options['video_input'] = 'required|string';
        }
        return $options;
    }

}
