<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Planet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'latest');

        $planets = Planet::search($search)
            ->sort($sort)
            ->with('creator', 'ratings')
            ->paginate(12);

        return view('planets.index', compact('planets', 'search', 'sort'));
    }

    public function show(Planet $planet)
    {
        $planet->load('creator', 'favorites', 'comments', 'ratings');
        $userRating = $planet->ratings()->where('user_id', auth()->id())->first();
        
        return view('planets.show', compact('planet', 'userRating'));
    }

    public function create()
    {
        return view('planets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'size' => 'required|string|max:255',
            'distance' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('planets', 'public');
        }

        $planet = Planet::create($validated);

        ActivityLogger::log(
            action: 'create',
            model: $planet,
            oldValue: null,
            newValue: $planet->toArray()
        );

        return redirect()->route('planets.show', $planet)
            ->with('success', 'Planet created successfully!');
    }

    public function edit(Planet $planet)
    {
        return view('planets.edit', compact('planet'));
    }

    public function update(Request $request, Planet $planet)
    {
        $oldData = $planet->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'size' => 'required|string|max:255',
            'distance' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($planet->image) {
                Storage::disk('public')->delete($planet->image);
            }
            $validated['image'] = $request->file('image')->store('planets', 'public');
        }

        $planet->update($validated);
        $newData = $planet->fresh()->toArray();

        ActivityLogger::log(
            action: 'update',
            model: $planet,
            oldValue: $oldData,
            newValue: $newData
        );

        return redirect()->route('planets.show', $planet)
            ->with('success', 'Planet updated successfully!');
    }

    public function destroy(Planet $planet)
    {
        $oldData = $planet->toArray();

        ActivityLogger::log(
            action: 'soft_delete',
            model: $planet,
            oldValue: $oldData,
            newValue: null
        );

        $planet->delete();

        return redirect()->route('planets.index')
            ->with('success', 'Planet soft deleted! Can be restored by admin.');
    }

    public function forceDelete($id)
    {
        $planet = Planet::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($planet->image) {
            Storage::disk('public')->delete($planet->image);
        }

        ActivityLogger::log(
            action: 'force_delete',
            description: 'Permanently deleted planet: ' . $planet->name,
            oldValue: $planet->toArray(),
            newValue: null
        );

        $planet->forceDelete();

        return redirect()->route('admin.trash')
            ->with('success', 'Planet permanently deleted!');
    }

    public function restore($id)
    {
        $planet = Planet::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $planet->restore();

        ActivityLogger::log(
            action: 'restore',
            model: $planet,
            description: 'Restored planet: ' . $planet->name,
            newValue: $planet->toArray()
        );

        return redirect()->route('admin.trash')
            ->with('success', 'Planet restored successfully!');
    }
}