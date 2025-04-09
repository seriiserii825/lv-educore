<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

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
        $options = [
            'title' => 'required|string|max:255|unique:courses,title,' . $this->course->id,
            'seo_description' => 'required|string',
            'demo_video_storage' => 'required|string',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ];
        // thumbnail can be a image or string
        if ($this->hasFile('thumbnail')) {
            $options['thumbnail'] = 'required|image';
        } else {
            $options['thumbnail'] = 'required|string';
        }
        if ($this->demo_video_storage === 'upload') {
            $options['video_file'] = 'nullable|file|mimes:mp4|max:102400';
        } else {
            $options['video_input'] = 'required|string';
        }
        return $options;
    }
}
