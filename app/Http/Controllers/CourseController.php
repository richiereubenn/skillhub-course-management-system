<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'schedule'=>'nullable|string|max:255',
            'instructor'=>'nullable|string|max:255',
        ]);

        Course::create($validated);
        return back()->with('success','Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'schedule'=>'nullable|string|max:255',
            'instructor'=>'nullable|string|max:255',
        ]);

        $course->update($validated);
        return back()->with('success','Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success','Course deleted successfully.');
    }
}
