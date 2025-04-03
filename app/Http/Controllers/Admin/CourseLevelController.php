<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CourseLevel;
use Illuminate\Http\Request;
class CourseLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = CourseLevel::orderBy('updated_at', 'desc')->get();
        return response()->json($levels, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_levels,name',
        ]);
        $validated['slug'] = \Str::slug($validated['name']);
        $level = CourseLevel::create($validated);
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
    public function update(Request $request, CourseLevel $level)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_levels,name,' . $level->id,
        ]);
        $validated['slug'] = \Str::slug($validated['name']);
        $level->update($validated);
        return response()->json($level, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
