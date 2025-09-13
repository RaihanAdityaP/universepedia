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
                <i class="bi bi-people display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_users']) }}</h3>
                <p class="mb-0 opacity-75">Total Users</p>
                <small class="text-light opacity-50">
                    {{ $stats['admin_users'] }} Admins, {{ $stats['regular_users'] }} Users
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-globe display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_planets']) }}</h3>
                <p class="mb-0 opacity-75">Total Planets</p>
                <small class="text-light opacity-50">
                    {{ $stats['habitable_planets'] }} Potentially Habitable
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['total_events']) }}</h3>
                <p class="mb-0 opacity-75">Total Events</p>
                <small class="text-light opacity-50">
                    {{ $stats['upcoming_events'] }} Upcoming
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-graph-up display-4 mb-3"></i>
                <h3 class="mb-1">{{ number_format($stats['past_events']) }}</h3>
                <p class="mb-0 opacity-75">Past Events</p>
                <small class="text-light opacity-50">
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
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Planet Types Distribution
                </h5>
            </div>
            <div class="card-body">
                @if($stats['planet_types']->count() > 0)
                    @foreach($stats['planet_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-light">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-muted d-block">{{ $count }} planet(s)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary">{{ number_format(($count / $stats['total_planets']) * 100, 1) }}%</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ ($count / $stats['total_planets']) * 100 }}%"></div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">No planet data available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Event Types Distribution -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header border-0">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-week me-2"></i>Event Types Distribution
                </h5>
            </div>
            <div class="card-body">
                @if($stats['event_types']->count() > 0)
                    @foreach($stats['event_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-light">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-muted d-block">{{ $count }} event(s)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">{{ number_format(($count / $stats['total_events']) * 100, 1) }}%</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($count / $stats['total_events']) * 100 }}%"></div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">No event data available</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card space-card">
            <div class="card-header border-0">
                <h5 class="mb-0">
                    <i class="bi bi-activity me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3">Recent Users</h6>
                        @forelse($recent_activity['recent_users'] as $user)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                                <div>
                                    <div class="text-light small">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small">No recent users</p>
                        @endforelse
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3">Recent Planets</h6>
                        @forelse($recent_activity['recent_planets'] as $planet)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-globe text-white"></i>
                                </div>
                                <div>
                                    <div class="text-light small">{{ $planet->name }}</div>
                                    <div class="text-muted small">{{ $planet->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small">No recent planets</p>
                        @endforelse
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="text-space-gold mb-3">Recent Events</h6>
                        @forelse($recent_activity['recent_events'] as $event)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-warning rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-event text-dark"></i>
                                </div>
                                <div>
                                    <div class="text-light small">{{ Str::limit($event->title, 20) }}</div>
                                    <div class="text-muted small">{{ $event->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small">No recent events</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection