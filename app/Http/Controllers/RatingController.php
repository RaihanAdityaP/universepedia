<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Event;
use App\Models\Planet;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:event,planet',
            'id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $model = $validated['type'] === 'event' 
            ? Event::findOrFail($validated['id']) 
            : Planet::findOrFail($validated['id']);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'ratable_type' => get_class($model),
                'ratable_id' => $model->id,
            ],
            [
                'rating' => $validated['rating'],
            ]
        );

        ActivityLogger::log(
            action: 'rate',
            model: $model,
            description: 'Rated ' . ($model->title ?? $model->name),
            newValue: ['rating' => $rating->rating]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully!',
                'average' => $model->averageRating(),
                'total' => $model->totalRatings(),
            ]);
        }

        return back()->with('success', 'Rating submitted successfully!');
    }
}