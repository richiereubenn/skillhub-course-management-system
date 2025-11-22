<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::latest()->paginate(10);
        return view('participants.index', compact('participants'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:32',
            'email'=>'required|email|unique:participants,email',
            'address'=>'nullable|string|max:500',
        ]);

        Participant::create($validated);

        return back()->with('success','Participant created successfully.');
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:32',
            'email'=>"required|email|unique:participants,email,{$participant->id}",
            'address'=>'nullable|string|max:500',
        ]);

        $participant->update($validated);

        return back()->with('success','Participant updated successfully.');
    }

    public function delete(Participant $participant)
    {
        $participant->delete();
        return back()->with('success','Participant deleted successfully.');
    }
}
