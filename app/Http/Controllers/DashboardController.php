<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Planet;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_planets' => Planet::count(),
            'total_events' => Event::count(),
            'past_events' => Event::past()->count(), // Ganti dari upcoming_events ke past_events
        ];

        $recent_planets = Planet::latest()->take(5)->get();
        $past_events = Event::past()->orderBy('date', 'desc')->take(5)->get(); // Ganti dari upcoming_events

        return view('dashboard.index', compact('stats', 'recent_planets', 'past_events'));
    }
}