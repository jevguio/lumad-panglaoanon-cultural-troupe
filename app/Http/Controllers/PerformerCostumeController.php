<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformerCostumeController extends Controller
{
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

    public function borrow($id)
    {
        $costume = Costume::findOrFail($id);

        // if ($costume->status === 'borrowed') {
        //     return response()->json(['error' => 'Already borrowed'], 400);
        // }

        $costume->status = 'borrowed';
        $costume->user_id = Auth::id(); // 👈 assign borrower
        $costume->date_complied = now();
        $costume->save();

        return response()->json(['message' => 'Costume borrowed']);
    }

    public function returnCostume($id)
    {
        $costume = Costume::findOrFail($id);

        $costume->status = 'returned';
        $costume->date_returned = now();
        $costume->user_id = null; // 👈 assign borrower
        $costume->save();

        return response()->json(['message' => 'Costume returned']);
    }

    public function lost(Request $request, $id)
    {
        $request->validate([
            'report_detail' => 'required|string',
            'report_img.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $costume = Costume::findOrFail($id);

        $imagePaths = [];

        if ($request->hasFile('report_img')) {
            foreach ($request->file('report_img') as $image) {
                $path = $image->store('lost_reports', 'public');
                $imagePaths[] = $path;
            }
        }

        $costume->status = 'lost';
        $costume->date_lost = now();
        $costume->report_detail = $request->report_detail;
        $costume->report_img = json_encode($imagePaths);
        $costume->save();

        return response()->json(['message' => 'Lost report submitted']);
    }
}
