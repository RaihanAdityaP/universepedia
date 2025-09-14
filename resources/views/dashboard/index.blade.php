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
            <small class="badge bg-warning text-dark">
                <i class="bi bi-shield-check me-1"></i>Administrator
            </small>
        @else
            <small class="badge bg-info">
                <i class="bi bi-rocket me-1"></i>Space Explorer
            </small>
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
        <div class="card space-card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 mb-3 text-primary"></i>
                <h3 class="mb-1 text-light">{{ number_format($stats['total_users']) }}</h3>
                <p class="mb-0 opacity-75 text-light">Space Explorers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-globe display-4 mb-3 text-success"></i>
                <h3 class="mb-1 text-light">{{ number_format($stats['total_planets']) }}</h3>
                <p class="mb-0 opacity-75 text-light">Planets Cataloged</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-4 mb-3 text-warning"></i>
                <h3 class="mb-1 text-light">{{ number_format($stats['total_events']) }}</h3>
                <p class="mb-0 opacity-75 text-light">Space Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-clock display-4 mb-3 text-info"></i>
                <h3 class="mb-1 text-light">{{ number_format($stats['past_events']) }}</h3>
                <p class="mb-0 opacity-75 text-light">Past Events</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent/Featured Planets -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-light">
                    <i class="bi bi-globe me-2"></i>Featured Planets
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
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-light fw-bold">{{ $planet->name }}</h6>
                                        <p class="mb-1 text-light opacity-75 small">{{ Str::limit($planet->description, 60) }}</p>
                                        <small class="text-muted fw-semibold">
                                            <i class="bi bi-rulers me-1"></i>{{ $planet->size }}
                                            <span class="ms-2"><i class="bi bi-moon me-1"></i>{{ $planet->moons }} moons</span>
                                        </small>
                                    </div>
                                    <div class="text-end ms-2">
                                        <span class="badge bg-{{ $planet->type_color }} planet-type-badge mb-2">
                                            {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                                        </span>
                                        @if($planet->is_habitable)
                                            <br><span class="badge bg-success small">Habitable</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('planets.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>Explore All Planets
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-globe text-muted display-1 mb-3"></i>
                        <p class="text-muted">No planets in the catalog yet.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('planets.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i>Add First Planet
                            </a>
                        @else
                            <p class="text-muted small">Check back soon as we add more celestial bodies!</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Past Events -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-light">
                    <i class="bi bi-calendar-event me-2"></i>Past Events
                </h5>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Add Event
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($past_events->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($past_events as $event)
                            <div class="list-group-item bg-transparent border-secondary">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-light fw-bold">{{ $event->title }}</h6>
                                        <p class="mb-1 text-light opacity-75 small">{{ Str::limit($event->description, 50) }}</p>
                                        <small class="text-muted fw-semibold">
                                            <i class="bi bi-calendar me-1"></i>{{ $event->formatted_date }}
                                            @if($event->time)
                                                at {{ $event->time->format('g:i A') }}
                                            @endif
                                            <span class="ms-2"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($event->location, 20) }}</span>
                                        </small>
                                    </div>
                                    <div class="text-end ms-2">
                                        <span class="badge bg-{{ $event->type_color }} planet-type-badge mb-2">
                                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                                        </span>
                                        <br><small class="text-secondary fw-semibold">
                                            {{ abs($event->days_until) }} days ago
                                        </small>
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
                        <p class="text-muted">No past space events recorded.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i>Add First Event
                            </a>
                        @else
                            <p class="text-muted small">Check back soon for amazing astronomical records!</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions for Users -->
@if(!auth()->user()->isAdmin() && ($recent_planets->count() > 0 || $past_events->count() > 0))
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card space-card">
            <div class="card-body text-center">
                <h6 class="text-space-gold mb-3">
                    <i class="bi bi-compass me-2"></i>Explore the Universe
                </h6>
                <div class="row g-3">
                    @if($recent_planets->count() > 0)
                        <div class="col-md-6">
                            <a href="{{ route('planets.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-globe me-2"></i>Discover Planets
                                <small class="d-block mt-1">{{ $stats['total_planets'] }} celestial bodies to explore</small>
                            </a>
                        </div>
                    @endif
                    @if($past_events->count() > 0)
                        <div class="col-md-6">
                            <a href="{{ route('events.index') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-calendar-event me-2"></i>Space Events
                                <small class="d-block mt-1">{{ $stats['past_events'] }} recorded phenomena</small>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.space-card {
    background: rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.text-space-gold {
    color: #ffc107;
}

.stats-card {
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.planet-type-badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.list-group-item {
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
    transform: translateX(3px);
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}
</style>
@endsection