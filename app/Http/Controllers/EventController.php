<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $typeFilter = $request->input('type');
        $sort = $request->input('sort', 'latest');

        $events = Event::search($search)
            ->filterByType($typeFilter)
            ->sort($sort)
            ->with('creator', 'ratings')
            ->paginate(12);

        return view('events.index', compact('events', 'search', 'typeFilter', 'sort'));
    }

    public function show(Event $event)
    {
        $event->load('creator', 'favorites', 'comments', 'ratings');
        $userRating = $event->ratings()->where('user_id', auth()->id())->first();
        
        return view('events.show', compact('event', 'userRating'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:meteor_shower,eclipse,planet_alignment,comet_appearance,supermoon,other',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($validated);

        ActivityLogger::log(
            action: 'create',
            model: $event,
            oldValue: null,
            newValue: $event->toArray()
        );

        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $oldData = $event->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:meteor_shower,eclipse,planet_alignment,comet_appearance,supermoon,other',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        $newData = $event->fresh()->toArray();

        ActivityLogger::log(
            action: 'update',
            model: $event,
            oldValue: $oldData,
            newValue: $newData
        );

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $oldData = $event->toArray();

        ActivityLogger::log(
            action: 'soft_delete',
            model: $event,
            oldValue: $oldData,
            newValue: null
        );

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event soft deleted! Can be restored by admin.');
    }

    public function forceDelete($id)
    {
        $event = Event::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        ActivityLogger::log(
            action: 'force_delete',
            description: 'Permanently deleted event: ' . $event->title,
            oldValue: $event->toArray(),
            newValue: null
        );

        $event->forceDelete();

        return redirect()->route('admin.trash')
            ->with('success', 'Event permanently deleted!');
    }

    public function restore($id)
    {
        $event = Event::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $event->restore();

        ActivityLogger::log(
            action: 'restore',
            model: $event,
            description: 'Restored event: ' . $event->title,
            newValue: $event->toArray()
        );

        return redirect()->route('admin.trash')
            ->with('success', 'Event restored successfully!');
    }
}