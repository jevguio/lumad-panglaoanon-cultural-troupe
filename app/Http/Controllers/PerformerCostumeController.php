<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use Illuminate\Http\Request;

class PerformerCostumeController extends Controller
{
    public function show($id)
    {
        return Costume::findOrFail($id);
    }

    public function borrow($id)
    {
        $costume = Costume::findOrFail($id);

        // if ($costume->status === 'borrowed') {
        //     return response()->json(['error' => 'Already borrowed'], 400);
        // }

        $costume->status = 'borrowed';
        $costume->date_complied = now();
        $costume->save();

        return response()->json(['message' => 'Costume borrowed']);
    }

    public function returnCostume($id)
    {
        $costume = Costume::findOrFail($id);

        $costume->status = 'returned';
        $costume->date_returned = now();
        $costume->save();

        return response()->json(['message' => 'Costume returned']);
    }

    public function lost($id)
    {
        $costume = Costume::findOrFail($id);

        $costume->status = 'lost';
        $costume->date_lost = now();
        $costume->save();

        return response()->json(['message' => 'Costume marked as lost']);
    }
}
