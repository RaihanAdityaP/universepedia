<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Planet;
use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'total_planets' => Planet::count(),
            'habitable_planets' => Planet::where('is_habitable', true)->count(),
            'planet_types' => Planet::select('type', \DB::raw('count(*) as total'))
                                   ->groupBy('type')
                                   ->pluck('total', 'type'),
            'total_events' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
            'past_events' => Event::past()->count(),
            'event_types' => Event::select('type', \DB::raw('count(*) as total'))
                                  ->groupBy('type')
                                  ->pluck('total', 'type'),
        ];

        $recent_activity = [
            'recent_users' => User::latest()->take(5)->get(),
            'recent_planets' => Planet::latest()->take(5)->get(),
            'recent_events' => Event::latest()->take(5)->get(),
        ];

        return view('reports.index', compact('stats', 'recent_activity'));
    }
}