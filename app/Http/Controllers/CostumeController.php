<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostumeController extends Controller
{
    public function index()
    {
        $performers = User::with('costumes')->get();
        $costumes = Costume::whereDoesntHave('user')->get();
        $user = Auth::user();
        // if (! in_array($user->type, ['admin', 'manager'])) {
        //     return view('performer.manage-costume', compact('performers', 'costumes'));
        // }

        return view('admin.manage-costume', compact('performers', 'costumes'));
    }
    public function status()
    {
        $performers = User::with('costumes')->get();
        $costumes = Costume::whereDoesntHave('user')->get();
        $user = Auth::user();
        // if (! in_array($user->type, ['admin', 'manager'])) {
            return view('performer.manage-costume', compact('performers', 'costumes'));
        // }

        // return view('admin.manage-costume', compact('performers', 'costumes'));
    }

    public function store(Request $req)
    {
        $imagePath = $req->file('image')->store('costumes', 'public');

        $costume = Costume::create([
            'name' => $req->name,
            'status' => 'returned',
            'img' => $imagePath,
        ]);

        return response()->json($costume);
    }

    public function show($id)
    {
        $costume= Costume::findOrFail($id);
        return response()->json([
            'id' => $costume->id,
            'status' => $costume->status,
            'img' => $costume->img,
            'date_returned' => $costume->date_returned,
            'date_lost' => $costume->date_lost,
            'date_complied' => $costume->date_complied,
            'report_detail' => $costume->report_detail,
            'report_img' => json_decode($costume->report_img ?? '[]'),
        ]);
    }

    public function update(Request $req, $id)
    {
        $costume = Costume::findOrFail($id);
        $costume->status = $req->status;
        $costume->name = $req->name;

        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('costumes', 'public');
            $costume->img = $imagePath;
        }

        $costume->save();

        return response()->json($costume);
    }

    public function destroy($id)
    {
        $costume = Costume::findOrFail($id);
        $costume->delete();

        return response()->json(['message' => 'deleted']);
    }
}
