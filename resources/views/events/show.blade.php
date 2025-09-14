@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-calendar-event me-2"></i>{{ $event->title }}
        </h1>
        <p class="text-light opacity-75 mb-0">Detailed information about this space event</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('events.index') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-calendar-event me-1"></i>Events
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">{{ $event->title }}</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Hero Image & Basic Info -->
        <div class="card space-card mb-4">
            <div class="position-relative">
                @if($event->image)
                    <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="bg-gradient-space d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-calendar-event text-light display-1 opacity-25"></i>
                    </div>
                @endif
                
                <!-- Overlay badges -->
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-{{ $event->type_color }} content-type-badge shadow me-2">
                        {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                    </span>
                    @if($event->is_recurring)
                        <span class="badge bg-warning text-dark shadow">
                            <i class="bi bi-arrow-repeat me-1"></i>Recurring
                        </span>
                    @endif
                </div>
                
                <!-- Status badge -->
                <div class="position-absolute top-0 start-0 m-3">
                    @if($event->date && $event->date->isFuture())
                        <span class="badge bg-info shadow">
                            <i class="bi bi-clock me-1"></i>Upcoming Event
                        </span>
                    @elseif($event->date)
                        <span class="badge bg-secondary shadow">
                            <i class="bi bi-check-circle me-1"></i>Past Event
                        </span>
                    @else
                        <span class="badge bg-warning text-dark shadow">
                            <i class="bi bi-question-circle me-1"></i>Date TBA
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="text-light mb-3">About {{ $event->title }}</h2>
                    <p class="text-light opacity-85 lead">{{ $event->description }}</p>
                </div>
            </div>
        </div>
        
        <!-- Detailed Information -->
        <div class="row g-4">
            <!-- Event Details -->
            <div class="col-md-6">
                <div class="card space-card h-100">
                    <div class="card-header bg-transparent border-bottom border-secondary">
                        <h6 class="text-light mb-0">
                            <i class="bi bi-calendar-check me-2"></i>Event Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                <span class="text-muted">
                                    <i class="bi bi-calendar me-2"></i>Date
                                </span>
                                <span class="text-light fw-semibold">{{ $event->date ? $event->date->format('F j, Y') : 'TBA' }}</span>
                            </div>
                            
                            @if($event->time)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-clock me-2"></i>Time
                                    </span>
                                    <span class="text-light fw-semibold">{{ Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                                </div>
                            @endif
                            
                            @if($event->duration)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-hourglass me-2"></i>Duration
                                    </span>
                                    <span class="text-light fw-semibold">{{ $event->duration }}</span>
                                </div>
                            @endif
                            
                            <div class="info-item d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">
                                    <i class="bi bi-geo-alt me-2"></i>Location
                                </span>
                                <span class="text-light fw-semibold">{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Observation Info -->
            <div class="col-md-6">
                <div class="card space-card h-100">
                    <div class="card-header bg-transparent border-bottom border-secondary">
                        <h6 class="text-light mb-0">
                            <i class="bi bi-eye me-2"></i>Observation Info
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            @if($event->visibility)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-binoculars me-2"></i>Best Viewed From
                                    </span>
                                    <span class="text-light fw-semibold">{{ $event->visibility }}</span>
                                </div>
                            @endif
                            
                            @if($event->date)
                                <div class="info-item d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="bi bi-info-circle me-2"></i>Status
                                    </span>
                                    <span class="text-light fw-semibold">
                                        @if($event->date->isFuture())
                                            @if($event->date->isToday())
                                                <span class="text-success">Happening Today!</span>
                                            @else
                                                {{ $event->date->diffInDays(now()) }} days to go
                                            @endif
                                        @else
                                            Past Event ({{ $event->date->diffForHumans() }})
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        @if(!$event->visibility)
                            <div class="text-center py-3">
                                <i class="bi bi-info-circle text-muted mb-2 d-block"></i>
                                <small class="text-muted">No visibility information available</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="card space-card mb-4">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-graph-up me-2"></i>Quick Facts
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="stat-box bg-dark bg-opacity-25 rounded p-3 border border-info border-opacity-25">
                            <div class="text-info h4 mb-1">{{ $event->date ? ($event->date->isFuture() ? 'Upcoming' : 'Past') : 'TBA' }}</div>
                            <small class="text-muted">Event<br>Status</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box bg-dark bg-opacity-25 rounded p-3 border border-{{ $event->is_recurring ? 'warning' : 'secondary' }} border-opacity-25">
                            <div class="text-{{ $event->is_recurring ? 'warning' : 'secondary' }} h4 mb-1">
                                @if($event->is_recurring)
                                    <i class="bi bi-arrow-repeat"></i>
                                @else
                                    <i class="bi bi-x-circle"></i>
                                @endif
                            </div>
                            <small class="text-muted">Recurring<br>Event</small>
                        </div>
                    </div>
                </div>
                
                <hr class="border-secondary my-3">
                
                <!-- Event Type Info -->
                <div class="text-center mb-3">
                    <span class="badge bg-{{ $event->type_color }} content-type-badge-large">
                        <i class="bi bi-tag me-1"></i>{{ ucfirst(str_replace('_', ' ', $event->type)) }}
                    </span>
                </div>
                
                <hr class="border-secondary my-3">
                
                <!-- Timestamps -->
                <div class="text-center">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-calendar-plus me-1"></i>
                        Added {{ $event->created_at->format('M j, Y') }}
                    </small>
                    <small class="text-muted d-block mb-1">
                        {{ $event->created_at->diffForHumans() }}
                    </small>
                    @if($event->updated_at != $event->created_at)
                        <small class="text-muted d-block">
                            <i class="bi bi-clock-history me-1"></i>
                            Updated {{ $event->updated_at->diffForHumans() }}
                        </small>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-gear me-2"></i>Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Event
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-2"></i>Delete Event
                        </button>
                        <hr class="border-secondary">
                    @endif
                    <a href="{{ route('events.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border border-danger">
            <div class="modal-header border-bottom border-danger">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Delete Event
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to permanently delete <strong>{{ $event->title }}</strong>?</p>
                <div class="bg-dark bg-opacity-50 p-3 rounded border border-danger border-opacity-25">
                    <div class="d-flex align-items-center">
                        @if($event->image)
                            <img src="{{ $event->image_url }}" class="rounded me-3 border" width="60" height="60" style="object-fit: cover;">
                        @else
                            <div class="rounded bg-gradient-space d-flex align-items-center justify-content-center me-3 border" style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-event text-white"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="text-light mb-1">{{ $event->title }}</h6>
                            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $event->type)) }} Event</small>
                            @if($event->is_recurring)
                                <div class="mt-1">
                                    <span class="badge bg-warning badge-sm">Recurring</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. All event data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Forever
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

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

.content-type-badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.content-type-badge-large {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-item {
    transition: all 0.2s ease;
}

.info-item:hover {
    background-color: rgba(255, 255, 255, 0.05);
    transform: translateX(3px);
}

.stat-box {
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.info-grid .info-item:last-child {
    border-bottom: none !important;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endsection