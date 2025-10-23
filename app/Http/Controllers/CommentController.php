<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Planet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:event,planet',
            'id' => 'required|integer',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $model = $validated['type'] === 'event' 
            ? Event::findOrFail($validated['id']) 
            : Planet::findOrFail($validated['id']);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'commentable_type' => get_class($model),
            'commentable_id' => $model->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        ActivityLogger::log(
            action: 'comment',
            model: $model,
            description: 'Added a comment',
            newValue: ['content' => $comment->content]
        );

        return back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        ActivityLogger::log(
            action: 'delete_comment',
            description: 'Soft deleted a comment',
            oldValue: ['content' => $comment->content]
        );

        $comment->delete();

        return back()->with('success', 'Comment deleted (can be restored).');
    }

    public function forceDelete($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        ActivityLogger::log(
            action: 'force_delete_comment',
            description: 'Permanently deleted a comment',
            oldValue: ['content' => $comment->content]
        );

        $comment->forceDelete();

        return back()->with('success', 'Comment permanently deleted!');
    }

    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->restore();

        ActivityLogger::log(
            action: 'restore_comment',
            description: 'Restored a deleted comment',
            newValue: ['content' => $comment->content]
        );

        return back()->with('success', 'Comment restored successfully!');
    }
}