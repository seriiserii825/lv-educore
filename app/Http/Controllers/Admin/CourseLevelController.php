<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLevel\StoreRequest;
use App\Http\Requests\CourseLevel\UpdateRequest;
use App\Models\CourseLevel;
use App\Services\Admin\CourseLevelService;
use Illuminate\Http\Request;

class CourseLevelController extends Controller
{
    protected CourseLevelService $service;
    public function __construct(CourseLevelService $service) {
        $this->service = $service;
    }

    public function index()
    {
        $levels = CourseLevel::orderBy('updated_at', 'desc')->get();
        return response()->json($levels, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $level = $this->service->store($request->name);
        return response()->json($level, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(CourseLevel $level)
    {
        return response()->json($level, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, CourseLevel $level)
    {
        $level = $this->service->update($level, $request->name);
        return response()->json($level, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseLevel $level)
    {
        $level->delete();
        return response()->json(['message' => 'Course level deleted'], 200);
    }
}
