<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'seo_description' => 'required|string',
            'demo_video_storage' => 'required|string|in:upload,youtube,vimeo,external_link',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
        ];
        if ($this->demo_video_storage === 'upload') {
            $options['thumbnail'] = 'required|file|mimes:mp4|max:102400';
        } else {
            $options['demo_video_source'] = 'required|string';
        }
        return $options;
    }
}
