<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Event;
use App\Models\Planet;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $favorites = $user->favorites()
            ->with(['favoritable' => function ($query) {
                $query->withTrashed();
            }])
            ->latest()
            ->paginate(12);

        // Filter out null favoritable (deleted items)
        $favorites->getCollection()->transform(function ($favorite) {
            return $favorite->favoritable ? $favorite : null;
        })->filter();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:event,planet',
            'id' => 'required|integer',
        ]);

        $model = $validated['type'] === 'event' 
            ? Event::findOrFail($validated['id']) 
            : Planet::findOrFail($validated['id']);

        $user = auth()->user();

        $favorite = $user->favorites()
            ->where('favoritable_type', get_class($model))
            ->where('favoritable_id', $model->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            ActivityLogger::log('unfavorite', $model);
            $message = 'Removed from favorites!';
            $status = 'unfavorited';
        } else {
            $user->favorites()->create([
                'favoritable_type' => get_class($model),
                'favoritable_id' => $model->id,
            ]);
            ActivityLogger::log('favorite', $model);
            $message = 'Added to favorites!';
            $status = 'favorited';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status,
            ]);
        }

        return back()->with('success', $message);
    }
}