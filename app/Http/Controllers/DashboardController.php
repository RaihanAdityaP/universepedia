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
            'upcoming_events' => Event::upcoming()->count(),
        ];

        $recent_planets = Planet::latest()->take(5)->get();
        $upcoming_events = Event::upcoming()->orderBy('date')->take(5)->get();

        return view('dashboard.index', compact('stats', 'recent_planets', 'upcoming_events'));
    }
}