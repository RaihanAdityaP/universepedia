<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Planet;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $events = Event::onlyTrashed()->with('creator')->latest('deleted_at')->get();
        $planets = Planet::onlyTrashed()->with('creator')->latest('deleted_at')->get();
        $comments = Comment::onlyTrashed()->with('user')->latest('deleted_at')->get();

        return view('admin.trash', compact('events', 'planets', 'comments'));
    }
}