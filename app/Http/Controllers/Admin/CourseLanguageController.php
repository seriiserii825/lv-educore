<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLanguage\StoreRequest;
use App\Http\Requests\CourseLanguage\UpdateRequest;
use App\Services\Admin\CourseLanguageService;
use App\Models\CourseLanguage;

class CourseLanguageController extends Controller
{
    protected $service;

    public function __construct(CourseLanguageService $service)
    {
        $this->service = $service;
    }

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
    public function store(StoreRequest $request)
    {
        $course_language = $this->service->store($request->name);
        return response()->json($course_language);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, CourseLanguage $language)
    {
        $language = $this->service->update($language, $request->name);
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
