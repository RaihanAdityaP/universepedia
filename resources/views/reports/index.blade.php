@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-bar-chart me-2"></i>Reports & Analytics
        </h1>
        <p class="text-light opacity-75 mb-0">Comprehensive insights into your space exploration data</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">Reports</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<!-- Overview Stats -->
<div class="row g-4 mb-5">
    @php
        $statCards = [
            ['icon' => 'bi-people', 'color' => 'primary', 'title' => 'Total Users', 'value' => number_format($stats['total_users']), 'subtitle' => "{$stats['admin_users']} Admins, {$stats['regular_users']} Users"],
            ['icon' => 'bi-globe', 'color' => 'success', 'title' => 'Total Planets', 'value' => number_format($stats['total_planets']), 'subtitle' => "{$stats['habitable_planets']} Potentially Habitable"],
            ['icon' => 'bi-calendar-event', 'color' => 'warning', 'title' => 'Total Events', 'value' => number_format($stats['total_events']), 'subtitle' => "{$stats['upcoming_events']} Upcoming"],
            ['icon' => 'bi-graph-up', 'color' => 'info', 'title' => 'Past Events', 'value' => number_format($stats['past_events']), 'subtitle' => 'Historical Records'],
        ];
    @endphp

    @foreach($statCards as $card)
        <div class="col-md-3">
            <div class="card space-card h-100 text-center">
                <div class="card-body">
                    <i class="bi {{ $card['icon'] }} display-6 text-{{ $card['color'] }} mb-2"></i>
                    <h4 class="text-light mb-1">{{ $card['value'] }}</h4>
                    <small class="text-muted">{{ $card['title'] }}</small>
                    <div>
                        <small class="text-light opacity-75 d-block">{{ $card['subtitle'] }}</small>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Planet Types Distribution -->
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Planet Types Distribution
                </h6>
            </div>
            <div class="card-body">
                @if($stats['planet_types']->count() > 0)
                    @foreach($stats['planet_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-light fw-semibold">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-muted d-block">{{ $count }} planet(s)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary fw-semibold">{{ number_format(($count / $stats['total_planets']) * 100, 1) }}%</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
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
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-calendar-week me-2"></i>Event Types Distribution
                </h6>
            </div>
            <div class="card-body">
                @if($stats['event_types']->count() > 0)
                    @foreach($stats['event_types'] as $type => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-light fw-semibold">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <small class="text-muted d-block">{{ $count }} event(s)</small>
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
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-activity me-2"></i>Recent Activity
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @foreach(['recent_users' => ['icon' => 'person', 'color' => 'primary', 'title' => 'Recent Users'], 
                              'recent_planets' => ['icon' => 'globe', 'color' => 'success', 'title' => 'Recent Planets'], 
                              'recent_events' => ['icon' => 'calendar-event', 'color' => 'warning', 'title' => 'Recent Events']] as $key => $meta)
                        <div class="col-md-4">
                            <h6 class="text-space-gold mb-3 fw-semibold">{{ $meta['title'] }}</h6>
                            @forelse($recent_activity[$key] as $item)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-{{ $meta['color'] }} rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-{{ $meta['icon'] }} text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-white small fw-semibold">
                                            {{ $key === 'recent_events' ? Str::limit($item->title, 20) : $item->name }}
                                        </div>
                                        <div class="text-light opacity-75 small fw-medium">{{ $item->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small fw-medium">No recent {{ strtolower(str_replace('Recent ', '', $meta['title'])) }}</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.space-card {
    transition: all 0.3s ease;
}
.space-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
}
.bg-gradient-space {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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