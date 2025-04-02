<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLanguage;
use Illuminate\Http\Request;

class CourseLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course_languages = CourseLanguage::orderBy('updated_at', 'desc')->get();
        return response()->json($course_languages);
    }

    public function show(CourseLanguage $language)
    {
        return response()->json($language);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_languages',
        ]);
        $validated['slug'] = \Str::slug($validated['name']);
        $course_language = CourseLanguage::create($validated);
        return response()->json($course_language);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseLanguage $language)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_languages,name,' . $language->id,
        ]);
        $validated['slug'] = \Str::slug($validated['name']);
        $language->update($validated);
        return response()->json($language);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseLanguage $language)
    {
        $language->delete();
        return response()->json(['message' => 'Course language deleted']);
    }
}
