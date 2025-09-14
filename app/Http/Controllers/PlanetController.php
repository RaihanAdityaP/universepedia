<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanetController extends Controller
{
    public function index(Request $request)
    {
        $query = Planet::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $planets = $query->paginate(12);
        $types = Planet::distinct()->pluck('type');

        return view('planets.index', compact('planets', 'types'));
    }

    public function show(Planet $planet)
    {
        return view('planets.show', compact('planet'));
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
            'size' => 'required|string',
            'distance_from_sun' => 'nullable|string',
            'diameter' => 'nullable|string',
            'mass' => 'nullable|string',
            'orbital_period' => 'nullable|string',
            'rotation_period' => 'nullable|string',
            'temperature' => 'nullable|string',
            'moons' => 'nullable|integer|min:0',
            'type' => 'required|string|in:terrestrial,gas_giant,ice_giant,dwarf_planet,exoplanet,other',
            'atmosphere' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['is_habitable'] = $request->has('is_habitable') ? 1 : 0;
        $validated['has_rings'] = $request->has('has_rings') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('planets', 'public');
        }

        Planet::create($validated);

        return redirect()->route('planets.index')->with('success', 'Planet created successfully!');
    }

    public function edit(Planet $planet)
    {
        return view('planets.edit', compact('planet'));
    }

    public function update(Request $request, Planet $planet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'size' => 'required|string',
            'distance_from_sun' => 'nullable|string',
            'diameter' => 'nullable|string',
            'mass' => 'nullable|string',
            'orbital_period' => 'nullable|string',
            'rotation_period' => 'nullable|string',
            'temperature' => 'nullable|string',
            'moons' => 'nullable|integer|min:0',
            'type' => 'required|string|in:terrestrial,gas_giant,ice_giant,dwarf_planet,exoplanet,other',
            'atmosphere' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['is_habitable'] = $request->has('is_habitable') ? 1 : 0;
        $validated['has_rings'] = $request->has('has_rings') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($planet->image) {
                Storage::disk('public')->delete($planet->image);
            }
            $validated['image'] = $request->file('image')->store('planets', 'public');
        }

        $planet->update($validated);

        return redirect()->route('planets.index')->with('success', 'Planet updated successfully!');
    }

    public function destroy(Planet $planet)
    {
        if ($planet->image) {
            Storage::disk('public')->delete($planet->image);
        }

        $planet->delete();

        return redirect()->route('planets.index')->with('success', 'Planet deleted successfully!');
    }
}