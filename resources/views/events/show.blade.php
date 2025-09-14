@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card space-card">
            @if($event->image)
                <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 400px; object-fit: cover;">
            @else
                <div class="bg-gradient bg-secondary d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-calendar-event text-light display-1 opacity-25"></i>
                </div>
            @endif
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="text-light mb-0 fw-bold">{{ $event->title }}</h1>
                    <div>
                        <span class="badge bg-{{ $event->type_color }} me-2 fw-semibold">
                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                        </span>
                        @if($event->is_recurring)
                            <span class="badge bg-warning text-dark fw-semibold">
                                <i class="bi bi-arrow-repeat me-1"></i>Recurring
                            </span>
                        @endif
                    </div>
                </div>
                
                <p class="text-light opacity-75 lead mb-4 fw-medium">{{ $event->description }}</p>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="bg-dark bg-opacity-25 rounded p-3">
                            <h6 class="text-space-gold mb-2 fw-bold">
                                <i class="bi bi-calendar-check me-2"></i>Event Details
                            </h6>
                            <ul class="list-unstyled mb-0 text-light fw-medium">
                                <li><strong class="fw-bold">Date:</strong> {{ $event->date ? $event->date->format('F j, Y') : 'TBA' }}</li>
                                @if($event->time)
                                    <li><strong class="fw-bold">Time:</strong> {{ Carbon\Carbon::parse($event->time)->format('g:i A') }}</li>
                                @endif
                                @if($event->duration)
                                    <li><strong class="fw-bold">Duration:</strong> {{ $event->duration }}</li>
                                @endif
                                <li><strong class="fw-bold">Location:</strong> {{ $event->location }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-dark bg-opacity-25 rounded p-3">
                            <h6 class="text-space-gold mb-2 fw-bold">
                                <i class="bi bi-eye me-2"></i>Visibility Information
                            </h6>
                            <ul class="list-unstyled mb-0 text-light fw-medium">
                                @if($event->visibility)
                                    <li><strong class="fw-bold">Best Viewed From:</strong> {{ $event->visibility }}</li>
                                @endif
                                @if($event->date)
                                    @if($event->date->isFuture())
                                        <li><strong class="fw-bold">Countdown:</strong> {{ $event->date->isToday() ? 'Today!' : $event->date->diffInDays(now()) . ' days to go' }}</li>
                                    @else
                                        <li><strong class="fw-bold">Status:</strong> Past Event ({{ $event->date->diffForHumans() }})</li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card space-card mb-4">
            <div class="card-body">
                <h6 class="text-light mb-3 fw-bold">Actions</h6>
                <div class="d-grid gap-2">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning fw-semibold">
                            <i class="bi bi-pencil me-2"></i>Edit Event
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 fw-semibold">
                                <i class="bi bi-trash me-2"></i>Delete Event
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('events.index') }}" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-arrow-left me-2"></i>Back to Events
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Event Status -->
        <div class="card space-card">
            <div class="card-body">
                <h6 class="text-light mb-3 fw-bold">Event Status</h6>
                
                @if($event->date)
                    @if($event->date->isFuture())
                        <div class="text-center p-3 bg-info bg-opacity-20 rounded mb-3">
                            <div class="text-info h2 mb-1">
                                {{ $event->date->isToday() ? '🎯' : '⏰' }}
                            </div>
                            <div class="text-space-gold h4 mb-0 fw-bold">
                                {{ $event->date->isToday() ? 'Today!' : $event->date->diffInDays(now()) . ' Days' }}
                            </div>
                            @if(!$event->date->isToday())
                                <small class="text-muted fw-medium">until event</small>
                            @endif
                        </div>
                    @else
                        <div class="text-center p-3 bg-secondary bg-opacity-20 rounded mb-3">
                            <div class="text-muted h2 mb-1">📅</div>
                            <div class="text-muted h6 mb-0 fw-semibold">Past Event</div>
                            <small class="text-muted fw-medium">{{ $event->date->diffForHumans() }}</small>
                        </div>
                    @endif
                @else
                    <div class="text-center p-3 bg-warning bg-opacity-20 rounded mb-3">
                        <div class="text-warning h2 mb-1">❓</div>
                        <div class="text-warning h6 mb-0 fw-semibold">Date TBA</div>
                    </div>
                @endif
                
                <hr class="border-secondary">
                
                <small class="text-muted d-block fw-medium">Added {{ $event->created_at->diffForHumans() }}</small>
                @if($event->updated_at != $event->created_at)
                    <small class="text-muted d-block fw-medium">Updated {{ $event->updated_at->diffForHumans() }}</small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection