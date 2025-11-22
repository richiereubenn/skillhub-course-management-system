<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Participant;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'registration_date' => 'nullable|date',
        ]);

        if ($course->participants()->where('participant_id', $validated['participant_id'])->exists()) {
            return back()->withErrors(['participant_id'=>'Participant already registered for this course.']);
        }

        $course->participants()->attach($validated['participant_id'], [
            'registration_date' => $validated['registration_date'] ?? now()
        ]);

        return back()->with('success','Participant registered to course successfully.');
    }

    public function destroy(Course $course, Participant $participant)
    {
        $course->participants()->detach($participant->id);
        return back()->with('success','Registration deleted successfully.');
    }
}
