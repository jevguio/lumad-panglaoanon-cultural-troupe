<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function performerAvailability()
    {
        $events = Event::with('selectedPerformers')->get();
        Log::info($events);
        $users = User::all();
        Log::info($users);

        return view('admin.events.performer-availability', compact('events', 'users'));
    }

    public function store(Request $request)
    {

        Log::info($request);
        $request->validate([
            'title' => 'required|string',
            'client' => 'required',
            'venue' => 'required',
            'type' => 'required',
            'date' => 'required',
            'time' => 'required',
            'status' => 'required',
            'performers' => 'required|numeric',
            'is_show_event' => 'nullable',
            'description' => 'nullable',
        ]);

        // $request->validate([
        //     'title' => 'required|string',
        //     'client' => 'required|string',
        //     'venue' => 'required|string',
        //     'type' => 'required|string',
        //     'date' => 'required|date',
        //     'time' => 'required',
        //     'status' => 'required|string',
        //     'required_performers' => 'required|numeric',
        //     'description' => 'nullable|string',
        //     'is_show_event' => 'required|boolean',
        //     'mode' => 'nullable|string',
        // ]);
        Log::info($request);
        $ev = Event::create([
            'title' => $request->title,
            'client' => $request->client,
            'venue' => $request->venue,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'required_performers' => $request->performers,
            'description' => $request->description,
            'is_show_event' => $request->is_show_event == 'on' ?? false,
            'mode' => $request->is_show_event == 'on' ? 'Show' : $request->mode ?? 'Others',
        ]);

        Log::info($ev);

        return back()->with('success', 'Event added successfully.');
    }

    public function performerHistory()
    {
        $events = User::with('attendedEvents')->get();

        return view('admin.events.performer-history', compact('events'));
    } 
    
    public function updatePerformerAvailability(Request $request, $eventId, $userId)
    {
        try {
            $request->validate([
                'status' => 'required|in:selected,unselected,undo',
            ]);
    
            $event = Event::findOrFail($eventId);
            $user = User::findOrFail($userId);
    
            // Update pivot (selected performers)
            if ($event->selectedPerformers()->where('user_id', $userId)->exists()) {
                $event->selectedPerformers()->updateExistingPivot($userId, [
                    'status' => $request->status,
                ]);
            } else {
                $event->selectedPerformers()->attach($userId, [
                    'status' => $request->status,
                ]);
            }
    
            // Prepare Google Calendar client
            $calendar = app(\App\Services\GoogleCalendarService::class)->client();
    
            // Parse event start and end using Carbon
            $startDateTime = Carbon::parse($event->date . ' ' . $event->time)->toIso8601String();
            $endDateTime = Carbon::parse($event->date . ' ' . $event->end_time)->toIso8601String();
    
            // Prepare Google Calendar event
            $calendarEvent = new \Google\Service\Calendar\Event([
                'summary' => $event->title ?: 'No Title',
                'location' => $event->venue ?: '',
                'description' => $event->description ?: '',
                'start' => [
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Asia/Manila',
                ],
                'end' => [
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Asia/Manila',
                ],
                'attendees' => [
                    ['email' => $user->email],
                ],
                'reminders' => ['useDefault' => true],
            ]);
    
            // Insert event and send invite
            $calendar->events->insert(
                'primary',
                $calendarEvent,
                ['sendUpdates' => 'all']
            );
    
            return response()->json([
                'success' => true,
                'status' => $request->status,
            ]);
    
        } catch (\Google\Service\Exception $e) {
            Log::error('Google Calendar Error: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    //
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'client' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'status' => 'sometimes|string',
            'required_performers' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $event->update($request->all());

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $showEvents = Event::where('is_show_event', true)->orderBy('id')->get();
        $otherEvents = Event::where('is_show_event', false)->orderBy('id')->get();
        $user = Auth::user();
        if ($user->type == 'admin' || $user->type == 'manager') {
            return view('admin.events.index', compact('showEvents', 'otherEvents'));
        } else {
            return view('events.index', compact('showEvents', 'otherEvents'));
        }

    }

    public function create()
    {
        $showEvents = Event::where('is_show_event', true)->orderBy('id')->get();
        $otherEvents = Event::where('is_show_event', false)->orderBy('id')->get();
        $user = Auth::user();
        if ($user->type == 'admin' || $user->type == 'manager') {
            return view('admin.events.create', compact('showEvents', 'otherEvents'));
        } else {
            return redirect()->route('dashboard');

        }

    }

    public function mySchedule()
    {
        // Example: only events assigned to logged-in performer
        $mySchedules = Event::whereHas('selectedPerformers', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();

        return view('events.my-schedule', compact('mySchedules'));
    }

    public function availability()
    {
        $events = Event::all();

        return view('events.availability', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with('selectedPerformers') // make sure relation exists
            ->findOrFail($id);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'client' => $event->client,
            'venue' => $event->venue,
            'type' => $event->type,
            'date' => $event->date,
            'time' => $event->time,
            'status' => $event->status,
            'required_performers' => $event->required_performers,
            'description' => $event->description,
            'selectedPerformers' => $event->selectedPerformers->pluck('name'), // return only names
        ]);
    }

    public function updateStatus(Request $request, Event $event)
    {
        $request->validate(['status' => 'required|in:available,unavailable,cancelled']);
        $event->status = $request->status;
        $event->save();

        return response()->json(['success' => true, 'status' => $event->status]);
    }
}
