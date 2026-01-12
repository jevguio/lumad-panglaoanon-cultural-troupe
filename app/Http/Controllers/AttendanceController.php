<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index()
    {
        // Only admin or manager
        $events = Event::with('selectedPerformers')->get();

        if (! in_array(auth()->user()->type, ['admin', 'manager'])) {
            $events = $events->map(function ($event) {
                $event->selectedPerformers = $event->selectedPerformers->where('id', auth()->id());
                return $event;
            });

            return view('performer.attendance.index', compact('events'));
        }
 

        return view('admin.attendance.index', compact('events'));
    }

    public function update(Request $request, $eventId, $userId)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $event = Event::findOrFail($eventId);
        $event->performers()->updateExistingPivot($userId, [
            'attendance' => $request->status,
        ]);

        return back()->with('success', 'Attendance updated!');
    }
}
