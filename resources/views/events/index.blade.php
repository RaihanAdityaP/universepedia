@extends('layouts.app')

@section('title', 'Space Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-calendar-event me-2"></i>Space Events
        </h1>
        <p class="text-light opacity-75 mb-0">Discover upcoming astronomical phenomena and space missions</p>
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
                    <span class="input-group-text bg-transparent border-secondary text-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-transparent border-secondary text-light" 
                           name="search" value="{{ request('search') }}" 
                           placeholder="Search events...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select bg-transparent border-secondary text-light">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-transparent border-secondary text-light">
                    <option value="">All Events</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Events Grid -->
<div class="row g-4">
    @forelse($events as $event)
        <div class="col-lg-6">
            <div class="card space-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title text-light mb-0">{{ $event->title }}</h5>
                        <span class="badge bg-{{ $event->type_color }} planet-type-badge">
                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                        </span>
                    </div>
                    
                    <p class="card-text text-light opacity-75">
                        {{ Str::limit($event->description, 150) }}
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <small class="text-muted d-block">Time</small>
                            <small class="text-light">{{ $event->time ? $event->time->format('g:i A') : 'TBA' }}</small>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Location</small>
                            <small class="text-light">{{ Str::limit($event->location, 15) }}</small>
                        </div>
                    </div>
                    
                    @if($event->days_until >= 0)
                        <div class="mb-3">
                            <span class="badge bg-info">
                                <i class="bi bi-clock me-1"></i>{{ $event->days_until === 0 ? 'Today' : 'in ' . $event->days_until . ' days' }}
                            </span>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-eye me-1"></i>View Details
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
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
                    <h4 class="text-light mb-3">No Events Found</h4>
                    <p class="text-muted mb-4">{{ request()->hasAny(['search', 'type', 'status']) ? 'No events match your search criteria.' : 'Start tracking space events by adding your first event!' }}</p>
                    @if(!request()->hasAny(['search', 'type', 'status']) && auth()->user()->isAdmin())
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus me-2"></i>Add First Event
                        </a>
                    @elseif(request()->hasAny(['search', 'type', 'status']))
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light">
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