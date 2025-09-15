@extends('layouts.app')

@section('title', 'Space Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-calendar-event me-2"></i>Space Events
        </h1>
        <p class="text-light opacity-75 mb-0">Discover astronomical phenomena and historic space missions</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">Events</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <div class="mb-2">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('events.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus me-2"></i>Add Event
                </a>
            @endif
        </div>
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-6 text-primary mb-2"></i>
                <h4 class="text-light mb-1">{{ $events->total() ?? $events->count() }}</h4>
                <small class="text-muted">Total Events</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-clock display-6 text-info mb-2"></i>
                <h4 class="text-light mb-1">{{ $events->where('date', '>', now())->count() }}</h4>
                <small class="text-muted">Upcoming Events</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-check-circle display-6 text-success mb-2"></i>
                <h4 class="text-light mb-1">{{ $events->where('date', '<', now())->count() }}</h4>
                <small class="text-muted">Past Events</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-arrow-repeat display-6 text-warning mb-2"></i>
                <h4 class="text-light mb-1">{{ $events->where('is_recurring', true)->count() }}</h4>
                <small class="text-muted">Recurring Events</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card space-card mb-4">
    <div class="card-header bg-transparent border-bottom border-secondary">
        <h6 class="text-light mb-0">
            <i class="bi bi-funnel me-2"></i>Search & Filter Events
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('events.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-light small mb-2">
                    <i class="bi bi-search me-1"></i>Search Events
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-secondary text-light" 
                           name="search" value="{{ request('search') }}" 
                           placeholder="Search by title or description...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-light small mb-2">
                    <i class="bi bi-tag me-1"></i>Event Type
                </label>
                <select name="type" class="form-select bg-dark border-secondary text-light">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-light small mb-2">
                    <i class="bi bi-calendar me-1"></i>Event Status
                </label>
                <select name="status" class="form-select bg-dark border-secondary text-light">
                    <option value="">All Events</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label text-light small mb-2 d-block">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-light">
                        <i class="bi bi-funnel me-1"></i>Apply
                    </button>
                </div>
            </div>
        </form>
        
        @if(request()->hasAny(['search', 'type', 'status']))
            <div class="mt-3 pt-3 border-top border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Showing filtered results for: 
                        @if(request('search'))
                            <span class="text-light">"{{ request('search') }}"</span>
                        @endif
                        @if(request('type'))
                            <span class="badge bg-secondary ms-1">{{ ucfirst(str_replace('_', ' ', request('type'))) }}</span>
                        @endif
                        @if(request('status'))
                            <span class="badge bg-info ms-1">{{ ucfirst(request('status')) }}</span>
                        @endif
                    </small>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Clear Filters
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Events Grid -->
<div class="row g-4">
    @forelse($events as $event)
        <div class="col-lg-4 col-md-6">
            <div class="card space-card h-100 content-card">
                <div class="position-relative">
                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-space d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-calendar-event text-light display-1 opacity-25"></i>
                        </div>
                    @endif
                    
                    <!-- Event Type Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-{{ $event->type_color }} content-type-badge shadow">
                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                        </span>
                    </div>
                    
                    <!-- Status Indicator -->
                    <div class="position-absolute top-0 start-0 m-2">
                        @if($event->date && $event->date->isFuture())
                            <span class="badge bg-info shadow">
                                <i class="bi bi-clock me-1"></i>Upcoming
                            </span>
                        @elseif($event->date)
                            <span class="badge bg-secondary shadow">
                                <i class="bi bi-check-circle me-1"></i>Past
                            </span>
                        @else
                            <span class="badge bg-warning text-dark shadow">
                                <i class="bi bi-question-circle me-1"></i>TBA
                            </span>
                        @endif
                    </div>
                    
                    <!-- Recurring Indicator -->
                    @if($event->is_recurring)
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-warning text-dark shadow">
                                <i class="bi bi-arrow-repeat me-1"></i>Recurring
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h5 class="card-title text-light mb-2">{{ $event->title }}</h5>
                        <p class="card-text text-light opacity-75 flex-grow-1">
                            {{ Str::limit($event->description, 120) }}
                        </p>
                    </div>
                    
                    <!-- Event Info Grid -->
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="info-box bg-dark bg-opacity-25 rounded p-2 text-center">
                                <i class="bi bi-calendar text-space-gold d-block mb-1"></i>
                                <small class="text-muted d-block">Date</small>
                                <small class="text-light fw-semibold">{{ $event->date ? $event->date->format('M j') : 'TBA' }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="info-box bg-dark bg-opacity-25 rounded p-2 text-center">
                                <i class="bi bi-clock text-space-gold d-block mb-1"></i>
                                <small class="text-muted d-block">Time</small>
                                <small class="text-light fw-semibold">{{ $event->time ? Carbon\Carbon::parse($event->time)->format('g:i A') : 'TBA' }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="info-box bg-dark bg-opacity-25 rounded p-2 text-center">
                                <i class="bi bi-geo-alt text-space-gold d-block mb-1"></i>
                                <small class="text-muted d-block">Location</small>
                                <small class="text-light fw-semibold">{{ Str::limit($event->location, 10) }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Countdown or Status -->
                    <div class="mb-3">
                        @if($event->date && $event->date->isFuture())
                            <div class="countdown-badge bg-info bg-opacity-20 rounded p-2 text-center border border-info border-opacity-25">
                                <small class="text-info fw-semibold">
                                    @if($event->date->isToday())
                                        <i class="bi bi-star me-1"></i>Happening Today!
                                    @else
                                        <i class="bi bi-clock me-1"></i>{{ $event->date->diffInDays(now()) }} days to go
                                    @endif
                                </small>
                            </div>
                        @elseif($event->date)
                            <div class="countdown-badge bg-secondary bg-opacity-20 rounded p-2 text-center border border-secondary border-opacity-25">
                                <small class="text-muted fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i>{{ $event->date->diffForHumans() }}
                                </small>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-auto">
                        <div class="d-grid gap-2">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-1"></i>View Event Details
                            </a>
                            @if(auth()->user()->isAdmin())
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $event->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        @if(auth()->user()->isAdmin())
        <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light border border-danger">
                    <div class="modal-header border-bottom border-danger">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle text-danger me-2"></i>Delete Event
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to delete <strong>{{ $event->title }}</strong>?</p>
                        <div class="bg-dark bg-opacity-50 p-3 rounded border border-danger border-opacity-25">
                            <div class="d-flex align-items-center">
                                @if($event->image_url)
                                    <img src="{{ $event->image_url }}" class="rounded me-3 border" width="60" height="60" style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-gradient-space d-flex align-items-center justify-content-center me-3 border" style="width: 60px; height: 60px;">
                                        <i class="bi bi-calendar-event text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="text-light mb-1">{{ $event->title }}</h6>
                                    <small class="text-muted">{{ $event->date ? $event->date->format('M j, Y') : 'Date TBA' }}</small>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger mt-3 mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            This action cannot be undone. All event data will be permanently removed.
                        </p>
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @empty
        <div class="col-12">
            <div class="card space-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-calendar-event text-muted display-1 mb-4"></i>
                    <h4 class="text-light mb-3">No Events Found</h4>
                    <p class="text-muted mb-4">
                        {{ request()->hasAny(['search', 'type', 'status']) ? 'No events match your search criteria.' : 'Start tracking space events by adding your first event!' }}
                    </p>
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

<style>
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

.space-card {
    background: rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.text-space-gold {
    color: #ffc107;
}

.content-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.content-type-badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-box {
    transition: all 0.2s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-box:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(255, 193, 7, 0.3);
}

.countdown-badge {
    transition: all 0.2s ease;
}

.countdown-badge:hover {
    transform: scale(1.02);
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endsection