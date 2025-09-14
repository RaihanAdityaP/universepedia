@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-bar-chart me-2"></i>Reports & Analytics
        </h1>
        <p class="text-light opacity-75 mb-0">Comprehensive insights into your space exploration data</p>
    </div>
</div>

<!-- Overview Stats -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 mb-3 text-white"></i>
                <h3 class="mb-1 text-white fw-bold">{{ number_format($stats['total_users']) }}</h3>
                <p class="mb-0 text-white fw-semibold">Total Users</p>
                <small class="text-white opacity-75 fw-medium">
                    {{ $stats['admin_users'] }} Admins, {{ $stats['regular_users'] }} Users
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-globe display-4 mb-3 text-white"></i>
                <h3 class="mb-1 text-white fw-bold">{{ number_format($stats['total_planets']) }}</h3>
                <p class="mb-0 text-white fw-semibold">Total Planets</p>
                <small class="text-white opacity-75 fw-medium">
                    {{ $stats['habitable_planets'] }} Potentially Habitable
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-4 mb-3 text-white"></i>
                <h3 class="mb-1 text-white fw-bold">{{ number_format($stats['total_events']) }}</h3>
                <p class="mb-0 text-white fw-semibold">Total Events</p>
                <small class="text-white opacity-75 fw-medium">
                    {{ $stats['upcoming_events'] }} Upcoming
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-graph-up display-4 mb-3 text-white"></i>
                <h3 class="mb-1 text-white fw-bold">{{ number_format($stats['past_events']) }}</h3>
                <p class="mb-0 text-white fw-semibold">Past Events</p>
                <small class="text-white opacity-75 fw-medium">
                    Historical Records
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Planet Types Distribution -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header border-0">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-pie-chart me-2"></i>Planet Types Distribution
                </h5>
            </div>
            <div class="card-body">
                @if($stats['planet_types']->count() > 0)
                    @foreach($stats['planet_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-white fw-semibold">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-light opacity-75 d-block fw-medium">{{ $count }} planet(s)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary fw-semibold">{{ number_format(($count / $stats['total_planets']) * 100, 1) }}%</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ ($count / $stats['total_planets']) * 100 }}%"></div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3 fw-medium">No planet data available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Event Types Distribution -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header border-0">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-calendar-week me-2"></i>Event Types Distribution
                </h5>
            </div>
            <div class="card-body">
                @if($stats['event_types']->count() > 0)
                    @foreach($stats['event_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-white fw-semibold">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-light opacity-75 d-block fw-medium">{{ $count }} event(s)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success fw-semibold">{{ number_format(($count / $stats['total_events']) * 100, 1) }}%</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($count / $stats['total_events']) * 100 }}%"></div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3 fw-medium">No event data available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card space-card">
            <div class="card-header border-0">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-activity me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3 fw-semibold">Recent Users</h6>
                        @forelse($recent_activity['recent_users'] as $user)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                                <div>
                                    <div class="text-white small fw-semibold">{{ $user->name }}</div>
                                    <div class="text-light opacity-75 small fw-medium">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small fw-medium">No recent users</p>
                        @endforelse
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3 fw-semibold">Recent Planets</h6>
                        @forelse($recent_activity['recent_planets'] as $planet)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-globe text-white"></i>
                                </div>
                                <div>
                                    <div class="text-white small fw-semibold">{{ $planet->name }}</div>
                                    <div class="text-light opacity-75 small fw-medium">{{ $planet->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small fw-medium">No recent planets</p>
                        @endforelse
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3 fw-semibold">Recent Events</h6>
                        @forelse($recent_activity['recent_events'] as $event)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-warning rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-event text-dark"></i>
                                </div>
                                <div>
                                    <div class="text-white small fw-semibold">{{ Str::limit($event->title, 20) }}</div>
                                    <div class="text-light opacity-75 small fw-medium">{{ $event->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small fw-medium">No recent events</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection