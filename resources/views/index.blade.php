@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </h1>
        <p class="text-light opacity-75 mb-0">Welcome back, {{ auth()->user()->name }}!</p>
        @if(auth()->user()->isAdmin())
            <small class="badge bg-warning text-dark">Administrator</small>
        @else
            <small class="badge bg-info">Space Explorer</small>
        @endif
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_users']) }}</h3>
                <p class="mb-0 opacity-75">Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-globe display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_planets']) }}</h3>
                <p class="mb-0 opacity-75">Planets</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_events']) }}</h3>
                <p class="mb-0 opacity-75">Total Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-clock display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['upcoming_events']) }}</h3>
                <p class="mb-0 opacity-75">Upcoming Events</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Planets -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-globe me-2"></i>Recent Planets
                </h5>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('planets.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Add Planet
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($recent_planets->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recent_planets as $planet)
                            <div class="list-group-item bg-transparent border-secondary">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-light">{{ $planet->name }}</h6>
                                        <p class="mb-1 text-light opacity-75 small">{{ Str::limit($planet->description, 50) }}</p>
                                        <small class="text-muted">{{ $planet->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-{{ $planet->type_color }} planet-type-badge">
                                        {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('planets.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>View All Planets
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-globe text-muted display-1 mb-3"></i>
                        <p class="text-muted">No planets added yet.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('planets.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i>Add First Planet
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Upcoming Events -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-event me-2"></i>Upcoming Events
                </h5>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Add Event
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($upcoming_events->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($upcoming_events as $event)
                            <div class="list-group-item bg-transparent border-secondary">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-light">{{ $event->title }}</h6>
                                        <p class="mb-1 text-light opacity-75 small">{{ Str::limit($event->description, 40) }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>{{ $event->formatted_date }}
                                            @if($event->time)
                                                at {{ $event->time->format('g:i A') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="text-end ms-2">
                                        <span class="badge bg-{{ $event->type_color }} planet-type-badge">
                                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                                        </span>
                                        @if($event->days_until >= 0)
                                            <small class="d-block text-space-gold mt-1">
                                                {{ $event->days_until === 0 ? 'Today' : 'in ' . $event->days_until . ' days' }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>View All Events
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-event text-muted display-1 mb-3"></i>
                        <p class="text-muted">No upcoming events.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i>Add First Event
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection