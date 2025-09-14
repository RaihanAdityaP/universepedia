@extends('layouts.app')

@section('title', 'Space Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1 fw-bold">
            <i class="bi bi-calendar-event me-2"></i>Space Events
        </h1>
        <p class="text-light opacity-75 mb-0 fw-medium">Discover astronomical phenomena and historic space missions</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-2"></i>Add Event
        </a>
    @endif
</div>

<!-- Search and Filter -->
<div class="card space-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('events.index') }}" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-light fw-bold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-secondary text-light fw-medium" 
                           name="search" value="{{ request('search') }}" 
                           placeholder="Search events..."
                           style="color: #ffffff !important;">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select bg-dark border-secondary text-light fw-medium"
                        style="color: #ffffff !important;">
                    <option value="" style="color: #ffffff;">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }} style="color: #ffffff;">
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-dark border-secondary text-light fw-medium"
                        style="color: #ffffff !important;">
                    <option value="" style="color: #ffffff;">All Events</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }} style="color: #ffffff;">Upcoming</option>
                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }} style="color: #ffffff;">Past</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-light w-100 fw-semibold">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Events Grid -->
<div class="row g-4">
    @forelse($events as $event)
        <div class="col-lg-4 col-md-6">
            <div class="card space-card h-100">
                @if($event->image_url)
                    <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-gradient bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-calendar-event text-light display-1 opacity-25"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title text-light mb-0 fw-bold">{{ $event->title }}</h5>
                        <span class="badge bg-{{ $event->type_color }} planet-type-badge">
                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                        </span>
                    </div>
                    
                    <p class="card-text text-light opacity-75 flex-grow-1 fw-medium">
                        {{ Str::limit($event->description, 120) }}
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <small class="text-muted d-block fw-bold">Date</small>
                            <small class="text-light fw-semibold">{{ $event->date ? $event->date->format('M j, Y') : 'TBA' }}</small>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block fw-bold">Time</small>
                            <small class="text-light fw-semibold">{{ $event->time ? Carbon\Carbon::parse($event->time)->format('g:i A') : 'TBA' }}</small>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block fw-bold">Location</small>
                            <small class="text-light fw-semibold">{{ Str::limit($event->location, 10) }}</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        @if($event->date && $event->date->isFuture())
                            <span class="badge bg-info fw-semibold">
                                <i class="bi bi-clock me-1"></i>{{ $event->date->isToday() ? 'Today' : 'in ' . $event->date->diffInDays(now()) . ' days' }}
                            </span>
                        @else
                            <span class="badge bg-secondary fw-semibold">
                                <i class="bi bi-check-circle me-1"></i>Past Event
                            </span>
                        @endif
                        
                        @if($event->is_recurring)
                            <span class="badge bg-warning text-dark fw-semibold ms-1">
                                <i class="bi bi-arrow-repeat me-1"></i>Recurring
                            </span>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="bi bi-eye me-1"></i>View Details
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning fw-semibold">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger fw-semibold">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card space-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-calendar-event text-muted display-1 mb-4"></i>
                    <h4 class="text-light mb-3 fw-bold">No Events Found</h4>
                    <p class="text-muted mb-4 fw-medium">{{ request()->hasAny(['search', 'type', 'status']) ? 'No events match your search criteria.' : 'Start tracking space events by adding your first event!' }}</p>
                    @if(!request()->hasAny(['search', 'type', 'status']) && auth()->user()->isAdmin())
                        <a href="{{ route('events.create') }}" class="btn btn-primary fw-semibold">
                            <i class="bi bi-plus me-2"></i>Add First Event
                        </a>
                    @elseif(request()->hasAny(['search', 'type', 'status']))
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light fw-semibold">
                            <i class="bi bi-arrow-left me-2"></i>View All Events
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($events->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $events->links() }}
    </div>
@endif
@endsection