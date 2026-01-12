<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventHighlights;
use App\Models\FileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventHighlightsController extends Controller
{
    public function index()
    {
        // Only show events that have at least one highlight
        $showEvents = Event::where('is_show_event', true)
            ->whereHas('highlights') // <- only events with highlights
            ->with('highlights.files')
            ->get();

        $otherEvents = Event::where('is_show_event', false)
            ->whereHas('highlights') // <- only events with highlights
            ->with('highlights.files')
            ->get();

        return view('admin.highlights.index', compact('showEvents', 'otherEvents'));
    }

    public function history()
    {
        $showEvents = Event::where('is_show_event', true)->with('highlights.files')->get();
        $otherEvents = Event::where('is_show_event', false)->with('highlights.files')->get();
        return view('performer.history.index', compact('showEvents', 'otherEvents'));
    }

    public function highlights()
    {
        $showEvents = Event::where('is_show_event', true)->with('highlights.files')->get();
        $otherEvents = Event::where('is_show_event', false)->with('highlights.files')->get();
        return view('performer.highlights.index', compact('showEvents', 'otherEvents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $highlight = EventHighlights::create([
            'event_id' => $request->event_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('highlights/images', 'public');
                FileUploads::create([
                    'event_highlights_id' => $highlight->id,
                    'paths' => $path,
                    'type' => 'image',
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $file) {
                $path = $file->store('highlights/videos', 'public');
                FileUploads::create([
                    'event_highlights_id' => $highlight->id,
                    'paths' => $path,
                    'type' => 'video',
                ]);
            }
        }

        return redirect()->route('manage.events.highlights')->with('success', 'Highlight added successfully!');
    }

    public function show($id)
    {
        $highlight = EventHighlights::with('files')->findOrFail($id);
        return response()->json($highlight);
    }

    public function update(Request $request, $id)
    {
        $highlight = EventHighlights::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('highlights/images', 'public');
                FileUploads::create([
                    'event_highlights_id' => $highlight->id,
                    'paths' => $path,
                    'type' => 'image',
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $file) {
                $path = $file->store('highlights/videos', 'public');
                FileUploads::create([
                    'event_highlights_id' => $highlight->id,
                    'paths' => $path,
                    'type' => 'video',
                ]);
            }
        }

        return redirect()->route('manage.events.highlights')->with('success', 'Highlight updated!');
    }

    public function destroy($id)
    {
        $highlight = EventHighlights::with('files')->findOrFail($id);

        // delete media files
        foreach ($highlight->files as $file) {
            Storage::disk('public')->delete($file->paths);
            $file->delete();
        }

        $highlight->delete();

        // If request is AJAX, return JSON
        if (request()->ajax()) {
            return response()->json(['message' => 'Highlight removed!']);
        }

        // Otherwise, redirect normally
        return redirect()->route('manage.events.highlights')->with('success', 'Highlight removed!');
    }

}
