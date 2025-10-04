<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\User;
use Illuminate\Http\Request;

class CostumeController extends Controller
{
    public function index()
    {
        $performers = User::with('costumes')->get();

        return view('manage-costume', compact('performers'));
    }
 

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'nullable|integer',
            'status' => 'required|string',
        ]);

        Costume::create($request->all());

        return redirect()->route('costumes.index')->with('success', 'Costume added successfully!');
    }

    public function show(Costume $costume)
    {
        return response()->json($costume); // For modal view
    }

    public function update(Request $request, Costume $costume)
    {
        $costume->update($request->all());

        return redirect()->route('costumes.index')->with('success', 'Costume updated successfully!');
    }

    public function destroy(Costume $costume)
    {
        $costume->delete();

        return redirect()->route('costumes.index')->with('success', 'Costume removed!');
    }
}
