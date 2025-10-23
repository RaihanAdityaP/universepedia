<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $actionFilter = $request->input('action');

        // Log aktivitas view 
        if (Auth::check()) {
            ActivityLogger::log(
                action: 'view',
                description: 'Viewed Activity Log page'
            );
        }

        $logs = ActivityLog::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('description', 'like', "%{$search}%");
            })
            ->when($actionFilter, function ($query, $action) {
                $query->where('action', $action);
            })
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs', compact('logs', 'search', 'actionFilter'));
    }
}