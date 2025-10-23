<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Planet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $typeFilter = $request->input('type');
        $sort = $request->input('sort', 'latest');

        // Get events
        $events = Event::search($search)
            ->filterByType($typeFilter)
            ->sort($sort)
            ->with('creator')
            ->paginate(6, ['*'], 'events_page');

        // Get planets
        $planets = Planet::search($search)
            ->sort($sort)
            ->with('creator')
            ->paginate(6, ['*'], 'planets_page');

        return view('dashboard', compact('events', 'planets', 'search', 'typeFilter', 'sort'));
    }
}