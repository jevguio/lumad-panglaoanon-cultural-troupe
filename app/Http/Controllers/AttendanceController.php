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
        if (!in_array(auth()->user()->type, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $events = Event::with('performers')->get();
        Log::info($events);
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
