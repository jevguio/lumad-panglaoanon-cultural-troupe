<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Costume;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;

        // Search Events
        $events = Event::where(['title','venue','client'], 'like', "%$query%")->get(['id','title','imageUrl']);

        // Search Costume
        $costumes = Costume::where(['name','status'], 'like', "%$query%")->get(['id','name','image']);

        return response()->json([
            'events' => $events,
            'costumes' => $costumes
        ]);
    }
}
