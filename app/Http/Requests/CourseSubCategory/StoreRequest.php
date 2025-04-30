<?php
namespace App\Http\Requests\CourseSubCategory;
use Illuminate\Foundation\Http\FormRequest;
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:course_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string',
            'show_at_tranding' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ];
    }
}


